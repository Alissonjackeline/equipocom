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

class AssignmentController extends Controller
{
  public function index(Request $request)
{
    $query = Assignment::with(['user', 'boss', 'assignedTeams.equipment.equipmentType']);

    // Filtros
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
        // Filtrar por estado de assigned_team
        $query->whereHas('assignedTeams', function($q) use ($request) {
            $q->where('Status', $request->estado);
        });
    }

    $assignments = $query->orderBy('created_at', 'desc')->get();
    
    // Obtener datos para los filtros y modales
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

            // Procesar documento
            if ($request->hasFile('Document')) {
                $documentFile = $request->file('Document');
                $documentName = 'documento_' . $currentDate . '_' . uniqid() . '.' . $documentFile->getClientOriginalExtension();
                $documentPath = $documentFile->storeAs('documents/assignments', $documentName, 'public');
            }

            // Procesar imagen
            if ($request->hasFile('Image')) {
                $imageFile = $request->file('Image');
                $imageName = 'imagen_' . $currentDate . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                $imagePath = $imageFile->storeAs('images/assignments', $imageName, 'public');
            }

            // Crear la asignación
            $assignment = Assignment::create([
                'User_id' => $request->User_id,
                'Boss_id' => $request->Boss_id,
                'Date' => $request->Date,
                'Comment' => $request->Comment,
                'Document' => $documentPath, 
                'Image' => $imagePath, 
                'Status' => 1
            ]);

            // Asignar equipos
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
            
            // Limpiar archivos en caso de error
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
        $assignment = Assignment::with('assignedTeams.equipment')->findOrFail($id);
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
            'Document' => 'nullable|file|mimes:pdf|max:2048',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            DB::beginTransaction();

            $updateData = [
                'User_id' => $request->User_id,
                'Boss_id' => $request->Boss_id,
                'Date' => $request->Date,
                'Comment' => $request->Comment
            ];

            $currentDate = now()->format('Ymd_His');

            // Procesar nuevo documento
            if ($request->hasFile('Document')) {
                // Eliminar documento anterior si existe
                if ($assignment->Document) {
                    Storage::disk('public')->delete($assignment->Document);
                }
                
                $documentFile = $request->file('Document');
                $documentName = 'documento_' . $currentDate . '_' . uniqid() . '.' . $documentFile->getClientOriginalExtension();
                $documentPath = $documentFile->storeAs('documents/assignments', $documentName, 'public');
                $updateData['Document'] = $documentPath;
            }

            // Procesar nueva imagen
            if ($request->hasFile('Image')) {
                // Eliminar imagen anterior si existe
                if ($assignment->Image) {
                    Storage::disk('public')->delete($assignment->Image);
                }
                
                $imageFile = $request->file('Image');
                $imageName = 'imagen_' . $currentDate . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                $imagePath = $imageFile->storeAs('images/assignments', $imageName, 'public');
                $updateData['Image'] = $imagePath;
            }

            $assignment->update($updateData);

            DB::commit();

            return redirect()->route('asignacion.index')
                ->with('success', 'Asignación actualizada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
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
            
            // Revertir estado de equipos
            Equipment::whereIn('idEquipment', $assignedEquipments)->update(['status' => 1]);
            
            // Eliminar relaciones
            AssignedTeam::where('Assignment_id', $id)->delete();
            
            // Eliminar archivos
            if ($assignment->Document) {
                Storage::disk('public')->delete($assignment->Document);
            }
            if ($assignment->Image) {
                Storage::disk('public')->delete($assignment->Image);
            }
            
            // Eliminar asignación
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
        
        $equipments = Equipment::where('status', 1) // Solo equipos disponibles
            ->where(function($query) use ($search) {
                $query->where('CodigoPatri', 'LIKE', "%{$search}%")
                      ->orWhere('Series', 'LIKE', "%{$search}%");
            })
            ->get(['idEquipment', 'CodigoPatri', 'Series', 'Brand', 'Model', 'Description']);

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
}