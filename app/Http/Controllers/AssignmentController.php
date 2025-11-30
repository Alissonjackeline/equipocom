<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignedTeam;
use App\Models\Equipment;
use App\Models\User;
use App\Models\Boss;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Assignment::with(['user', 'boss', 'assignedTeams.equipment.equipmentType']);

        if ($request->filled('desde')) {
            $query->whereDate('Date', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $query->whereDate('Date', '<=', $request->hasta);
        }

        if ($request->filled('usuario_id')) {
            $query->where('User_id', $request->usuario_id);
        }

        if ($request->filled('estado')) {
            $query->whereHas('assignedTeams', function($q) use ($request) {
                $q->where('Status', $request->estado);
            });
        }

        $assignments = $query->orderBy('created_at', 'desc')->get();
        
        $users = User::where('Status', 1)->get();
        $bosses = Boss::where('Status', 1)->get();

        return view('asignacion.index', compact('assignments', 'users', 'bosses'));
    }

    public function create()
    {
        $users = User::where('Status', 1)->get();
        $bosses = Boss::where('Status', 1)->get();
        $equipments = Equipment::where('status', 1)->get();

        return view('asignacion.create', compact('users', 'bosses', 'equipments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'User_id' => 'required|exists:users,idUser',
            'Boss_id' => 'required|exists:bosses,idBoss',
            'Date' => 'required|date',
            'equipments' => 'required|array|min:1',
            'equipments.*' => 'exists:equipment,idEquipment',
            'Comment' => 'nullable|string|max:150',
            'Document' => 'required|file|mimes:pdf|max:2048',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            DB::beginTransaction();

            $documentPath = null;
            $imagePath = null;
            $currentDate = now()->format('Ymd_His');
            if ($request->hasFile('Document')) {
                $documentFile = $request->file('Document');
                $documentName = 'documento_' . $currentDate . '_' . uniqid() . '.' . $documentFile->getClientOriginalExtension();
                $documentPath = $documentFile->storeAs('documents/assignments', $documentName, 'public');
            }
            if ($request->hasFile('Image')) {
                $imageFile = $request->file('Image');
                $imageName = 'imagen_' . $currentDate . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                $imagePath = $imageFile->storeAs('images/assignments', $imageName, 'public');
            }

            $assignment = Assignment::create([
                'User_id' => $request->User_id,
                'Boss_id' => $request->Boss_id,
                'Date' => $request->Date,
                'Comment' => $request->Comment,
                'Document' => $documentPath, 
                'Image' => $imagePath, 
                'Status' => 1
            ]);

            foreach ($request->equipments as $equipmentId) {
                $equipment = Equipment::where('idEquipment', $equipmentId)
                    ->where('status', 1)
                    ->first();

                if ($equipment) {
                    AssignedTeam::create([
                        'Equipment_id' => $equipmentId,
                        'Assignment_id' => $assignment->idAssignment,
                        'Status' => 1
                    ]);

                    $equipment->update(['status' => 3]);
                }
            }

            DB::commit();

            return redirect()->route('asignacion.create')
                ->with('success', 'Asignación creada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            if ($documentPath && Storage::disk('public')->exists($documentPath)) {
                Storage::disk('public')->delete($documentPath);
            }
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            return redirect()->back()
                ->with('error', 'Error al crear la asignación: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(string $id)
    {
        $assignment = Assignment::with(['user', 'boss', 'assignedTeams.equipment.equipmentType'])->findOrFail($id);
        $users = User::where('Status', 1)->get();
        $bosses = Boss::where('Status', 1)->get();
        $equipments = Equipment::where('status', 1)->get();

        return view('asignacion.edit', compact('assignment', 'users', 'bosses', 'equipments'));
    }

   public function update(Request $request, string $id)
{
    $assignment = Assignment::findOrFail($id);
    
    $request->validate([
        'User_id' => 'required|exists:users,idUser',
        'Boss_id' => 'required|exists:bosses,idBoss',
        'Date' => 'required|date',
        'Comment' => 'nullable|string|max:150',
        'Document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'Image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'equipment_status' => 'nullable|array',
        'equipment_status.*' => 'in:0,1',
        'new_equipments' => 'nullable|array',
        'new_equipments.*' => 'exists:equipment,idEquipment',
        'removed_equipments' => 'nullable|array',
        'removed_equipments.*' => 'exists:equipment,idEquipment'
    ]);

    try {
        DB::beginTransaction();

        // Actualizar datos básicos de la asignación
        $updateData = [
            'User_id' => $request->User_id,
            'Boss_id' => $request->Boss_id,
            'Date' => $request->Date,
            'Comment' => $request->Comment
        ];

        $currentDate = now()->format('Ymd_His');
        
        // Manejar documento e imagen (código existente)
        if ($request->hasFile('Document')) {
            if ($assignment->Document) {
                Storage::disk('public')->delete($assignment->Document);
            }
            
            $documentFile = $request->file('Document');
            $documentName = 'documento_' . $currentDate . '_' . uniqid() . '.' . $documentFile->getClientOriginalExtension();
            $documentPath = $documentFile->storeAs('documents/assignments', $documentName, 'public');
            $updateData['Document'] = $documentPath;
        }
        
        if ($request->hasFile('Image')) {
            if ($assignment->Image) {
                Storage::disk('public')->delete($assignment->Image);
            }
            
            $imageFile = $request->file('Image');
            $imageName = 'imagen_' . $currentDate . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
            $imagePath = $imageFile->storeAs('images/assignments', $imageName, 'public');
            $updateData['Image'] = $imagePath;
        }

        $assignment->update($updateData);

        // Log para debugging
        Log::info('Datos recibidos en update:', [
            'assignment_id' => $id,
            'equipment_status' => $request->equipment_status,
            'new_equipments' => $request->new_equipments,
            'removed_equipments' => $request->removed_equipments
        ]);

        // 1. PRIMERO: Manejar equipos removidos (los que se desactivaron)
        if ($request->has('removed_equipments')) {
            foreach ($request->removed_equipments as $equipmentId) {
                $assignedTeam = AssignedTeam::where('Assignment_id', $id)
                    ->where('Equipment_id', $equipmentId)
                    ->first();

                if ($assignedTeam) {
                    // Eliminar la asignación
                    $assignedTeam->delete();
                    
                    // Actualizar estado del equipo a disponible
                    $equipment = Equipment::find($equipmentId);
                    if ($equipment) {
                        $equipment->update(['status' => 1]); // 1 = Disponible
                        Log::info("Equipo {$equipmentId} removido de asignación {$id} y marcado como disponible");
                    }
                }
            }
        }

        // 2. LUEGO: Manejar estado de equipos existentes que NO fueron removidos
        if ($request->has('equipment_status')) {
            foreach ($request->equipment_status as $equipmentId => $status) {
                // Solo procesar si el equipo NO está en la lista de removidos
                if (!$request->has('removed_equipments') || !in_array($equipmentId, $request->removed_equipments)) {
                    $assignedTeam = AssignedTeam::where('Assignment_id', $id)
                        ->where('Equipment_id', $equipmentId)
                        ->first();

                    if ($assignedTeam) {
                        $assignedTeam->update(['Status' => $status]);
                        
                        // Actualizar estado del equipo en la tabla equipment
                        $equipment = Equipment::find($equipmentId);
                        if ($equipment) {
                            $equipmentStatus = $status ? 3 : 1; // 3 = Asignado, 1 = Disponible
                            $equipment->update(['status' => $equipmentStatus]);
                            Log::info("Equipo {$equipmentId} actualizado a estado: {$equipmentStatus}");
                        }
                    }
                }
            }
        }

        // 3. FINALMENTE: Manejar nuevos equipos
        if ($request->has('new_equipments')) {
            Log::info("Procesando nuevos equipos: ", $request->new_equipments);
            
            foreach ($request->new_equipments as $equipmentId) {
                // Verificar si el equipo ya está asignado a ESTA asignación
                $existingAssignment = AssignedTeam::where('Assignment_id', $id)
                    ->where('Equipment_id', $equipmentId)
                    ->first();

                if (!$existingAssignment) {
                    // Verificar que el equipo esté disponible
                    $equipment = Equipment::where('idEquipment', $equipmentId)
                        ->where('status', 1) // Solo equipos disponibles
                        ->first();

                    if ($equipment) {
                        // Crear nueva asignación
                        AssignedTeam::create([
                            'Equipment_id' => $equipmentId,
                            'Assignment_id' => $id,
                            'Status' => 1
                        ]);

                        // Actualizar estado del equipo
                        $equipment->update(['status' => 3]); // 3 = Asignado
                        Log::info("Nuevo equipo {$equipmentId} agregado a asignación {$id}");
                    } else {
                        Log::warning("Equipo {$equipmentId} no disponible o no encontrado");
                    }
                } else {
                    Log::info("Equipo {$equipmentId} ya está asignado a esta asignación");
                }
            }
        }

        DB::commit();

        return redirect()->route('asignacion.index')
            ->with('success', 'Asignación actualizada exitosamente.');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error al actualizar asignación: ' . $e->getMessage());
        return redirect()->back()
            ->with('error', 'Error al actualizar la asignación: ' . $e->getMessage())
            ->withInput();
    }
}

    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $assignment = Assignment::findOrFail($id);
            $assignedEquipments = AssignedTeam::where('Assignment_id', $id)->pluck('Equipment_id');
            
            Equipment::whereIn('idEquipment', $assignedEquipments)->update(['status' => 1]);
            
            AssignedTeam::where('Assignment_id', $id)->delete();
            
            // Eliminar archivos
            if ($assignment->Document) {
                Storage::disk('public')->delete($assignment->Document);
            }
            if ($assignment->Image) {
                Storage::disk('public')->delete($assignment->Image);
            }
            
            $assignment->delete();

            DB::commit();

            return redirect()->route('asignacion.index')
                ->with('success', 'Asignación eliminada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('asignacion.index')
                ->with('error', 'Error al eliminar la asignación: ' . $e->getMessage());
        }
    }

    public function searchEquipment(Request $request)
    {
        $search = $request->get('search');
        $assignmentId = $request->get('assignment_id');
        $getSelected = $request->get('get_selected');
        $ids = $request->get('ids');

        $query = Equipment::where('status', 1); 

        if ($getSelected && $ids) {
            $idArray = explode(',', $ids);
            $query->whereIn('idEquipment', $idArray);
        } else {
            // Búsqueda normal
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('CodigoPatri', 'LIKE', "%{$search}%")
                      ->orWhere('Series', 'LIKE', "%{$search}%")
                      ->orWhere('Brand', 'LIKE', "%{$search}%")
                      ->orWhere('Model', 'LIKE', "%{$search}%");
                });
            }

            if ($assignmentId) {
                $assignedEquipmentIds = AssignedTeam::where('Assignment_id', $assignmentId)
                    ->pluck('Equipment_id')
                    ->toArray();
                
                if (!empty($assignedEquipmentIds)) {
                    $query->whereNotIn('idEquipment', $assignedEquipmentIds);
                }
            }
        }

        $equipments = $query->get(['idEquipment', 'CodigoPatri', 'Series', 'Brand', 'Model', 'Description']);

        return response()->json($equipments);
    }

    public function getUserData(Request $request)
    {
        $user = User::find($request->id);
        return response()->json($user);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'Status' => 'required|in:0,1'
        ]);

        $assignment = Assignment::findOrFail($id);
        $assignment->update(['Status' => $request->Status]);

        return redirect()->back()
            ->with('success', 'Estado de la asignación actualizado exitosamente.');
    }

    /**
     * Obtener equipos asignados a una asignación específica
     */
    public function getAssignedEquipment($id)
    {
        $assignedTeams = AssignedTeam::with('equipment.equipmentType')
            ->where('Assignment_id', $id)
            ->get();

        return response()->json($assignedTeams);
    }

    /**
     * Remover equipo de una asignación
     */
    public function removeEquipment(Request $request, $assignmentId)
    {
        try {
            DB::beginTransaction();

            $assignedTeam = AssignedTeam::where('Assignment_id', $assignmentId)
                ->where('Equipment_id', $request->equipment_id)
                ->firstOrFail();

            // Actualizar estado del equipo a disponible
            $equipment = Equipment::find($request->equipment_id);
            if ($equipment) {
                $equipment->update(['status' => 1]);
            }

            // Eliminar la asignación
            $assignedTeam->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Equipo removido exitosamente.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al remover el equipo: ' . $e->getMessage()
            ], 500);
        }
    }
}