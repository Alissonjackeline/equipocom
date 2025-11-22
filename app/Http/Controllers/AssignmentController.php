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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assignments = Assignment::with(['user', 'boss', 'assignedTeams.equipment'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('asignacion.index', compact('assignments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    // Obtener usuarios activos
    $users = User::where('Status', 1)->get();
    
    // Obtener jefes activos
    $bosses = Boss::where('Status', 1)->get();
    
    // Obtener equipos disponibles (estado 1 = Disponible) y que no estén asignados
    $equipments = Equipment::where('status', 1)->get();

    return view('asignacion.create', compact('users', 'bosses', 'equipments'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'User_id' => 'required|exists:users,idUser',
        'Boss_id' => 'required|exists:bosses,idBoss',
        'Date' => 'required|date',
        'equipments' => 'required|array|min:1',
        'equipments.*' => 'exists:equipment,idEquipment',
        'Comment' => 'nullable|string|max:150',
        'Document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'Image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    try {
        DB::beginTransaction();

        // 1. Crear la asignación principal
        $assignment = Assignment::create([
            'User_id' => $request->User_id,
            'Boss_id' => $request->Boss_id,
            'Date' => $request->Date,
            'Comment' => $request->Comment,
            'Status' => 1
        ]);

        // Subir documentos si existen
        if ($request->hasFile('Document')) {
            $documentPath = $request->file('Document')->store('documents/assignments', 'public');
            $assignment->update(['Document' => $documentPath]);
        }

        if ($request->hasFile('Image')) {
            $imagePath = $request->file('Image')->store('images/assignments', 'public');
            $assignment->update(['Image' => $imagePath]);
        }

        // 2. Asignar equipos en assigned_team y actualizar estado
        foreach ($request->equipments as $equipmentId) {
            // Verificar que el equipo esté disponible
            $equipment = Equipment::where('idEquipment', $equipmentId)
                ->where('status', 1)
                ->first();

            if ($equipment) {
                // Crear relación en assigned_team
                AssignedTeam::create([
                    'Equipment_id' => $equipmentId,
                    'Assignment_id' => $assignment->idAssignment,
                    'Status' => 1
                ]);

                // Actualizar estado del equipo a "En uso" (estado 3)
                $equipment->update(['status' => 3]);
            }
        }

        DB::commit();

        return redirect()->route('asignacion.index')
            ->with('success', 'Asignación creada exitosamente.');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()
            ->with('error', 'Error al crear la asignación: ' . $e->getMessage())
            ->withInput();
    }
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $assignment = Assignment::with([
            'user', 
            'boss', 
            'assignedTeams.equipment'
        ])->findOrFail($id);
        
        return view('asignacion.show', compact('assignment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $assignment = Assignment::with('assignedTeams.equipment')->findOrFail($id);
        $users = User::where('Status', 1)->get();
        $bosses = Boss::where('Status', 1)->get();
        $equipments = Equipment::where('status', 1)->get();

        return view('asignacion.edit', compact('assignment', 'users', 'bosses', 'equipments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $assignment = Assignment::findOrFail($id);
        
        $request->validate([
            'User_id' => 'required|exists:users,idUser',
            'Boss_id' => 'required|exists:bosses,idBoss',
            'Date' => 'required|date',
            'Comment' => 'nullable|string|max:150',
            'Document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            DB::beginTransaction();

            $assignment->update([
                'User_id' => $request->User_id,
                'Boss_id' => $request->Boss_id,
                'Date' => $request->Date,
                'Comment' => $request->Comment
            ]);

            // Actualizar documentos si se proporcionan nuevos
            if ($request->hasFile('Document')) {
                // Eliminar documento anterior si existe
                if ($assignment->Document) {
                    Storage::disk('public')->delete($assignment->Document);
                }
                $documentPath = $request->file('Document')->store('documents/assignments', 'public');
                $assignment->update(['Document' => $documentPath]);
            }

            if ($request->hasFile('Image')) {
                // Eliminar imagen anterior si existe
                if ($assignment->Image) {
                    Storage::disk('public')->delete($assignment->Image);
                }
                $imagePath = $request->file('Image')->store('images/assignments', 'public');
                $assignment->update(['Image' => $imagePath]);
            }

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $assignment = Assignment::findOrFail($id);

            // Obtener equipos asignados para revertir su estado
            $assignedEquipments = AssignedTeam::where('Assignment_id', $id)->pluck('Equipment_id');

            // Revertir estado de equipos a "Disponible" (estado 1)
            Equipment::whereIn('idEquipment', $assignedEquipments)->update(['status' => 1]);

            // Eliminar registros relacionados en assigned_team
            AssignedTeam::where('Assignment_id', $id)->delete();

            // Eliminar archivos
            if ($assignment->Document) {
                Storage::disk('public')->delete($assignment->Document);
            }
            if ($assignment->Image) {
                Storage::disk('public')->delete($assignment->Image);
            }

            // Eliminar la asignación
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

    // Método para buscar equipos disponibles por código patrimonial o serie
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

    // Método para obtener datos del usuario
    public function getUserData(Request $request)
    {
        $user = User::find($request->id);
        return response()->json($user);
    }

    // Método para cambiar estado de la asignación
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