<?php

namespace App\Http\Controllers;

use App\Models\EquipmentReturn;
use App\Models\Assignment;
use App\Models\Boss;
use App\Models\Equipment;
use App\Models\AssignedTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DevolucionController extends Controller
{
    public function index()
    {
        $returns = EquipmentReturn::with(['assignment.user', 'equipment.equipmentType', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('devolucion.index', compact('returns'));
    }

    public function create()
    {
        $bosses = Boss::where('Status', 1)->get();
        return view('devolucion.create', compact('bosses'));
    }

    public function getBossAssignments($bossId)
    {
        // Primero obtener los datos del jefe
        $boss = Boss::with(['area.headquarters'])
            ->where('idBoss', $bossId)
            ->where('Status', 1)
            ->first();

        if (!$boss) {
            return response()->json(['error' => 'Jefe no encontrado'], 404);
        }

        $assignments = Assignment::with([
                'user', 
                'assignedTeams' => function($query) {
                    $query->where('Status', 1); // SOLO assigned_teams activos
                },
                'assignedTeams.equipment.equipmentType', 
                'assignedTeams.equipment.supplier'
            ])
            ->where('Boss_id', $bossId)
            ->where('Status', 1) 
            ->whereHas('assignedTeams', function($query) {
                $query->where('Status', 1); 
            })
            ->get();

        return response()->json([
            'boss' => $boss,
            'assignments' => $assignments
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'Assignment_id' => 'required|exists:assignments,idAssignment',
            'Equipment_id' => 'required|exists:equipment,idEquipment',
            'User_id' => 'required|exists:users,idUser',
            'Date' => 'required|date',
            'estado' => 'required|in:1,2,4,5,6',
            'comentario' => 'nullable|string|max:150',
            'documento' => 'required|file|mimes:pdf|max:2048',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            DB::beginTransaction();
            $assignedTeam = AssignedTeam::where('Assignment_id', $request->Assignment_id)
                ->where('Equipment_id', $request->Equipment_id)
                ->where('Status', 1)
                ->first();

            if (!$assignedTeam) {
                return redirect()->back()
                    ->with('error', 'El equipo no está asignado activamente a esta asignación o ya fue devuelto.')
                    ->withInput();
            }

            $currentDate = now()->format('Ymd_His');
            $documentPath = null;
            $imagePath = null;

            // Procesar documento
            if ($request->hasFile('documento')) {
                $documentFile = $request->file('documento');
                $documentName = 'devolucion_doc_' . $currentDate . '_' . uniqid() . '.' . $documentFile->getClientOriginalExtension();
                $documentPath = $documentFile->storeAs('documents/returns', $documentName, 'public');
            }

            // Procesar imagen
            if ($request->hasFile('imagen')) {
                $imageFile = $request->file('imagen');
                $imageName = 'devolucion_img_' . $currentDate . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                $imagePath = $imageFile->storeAs('images/returns', $imageName, 'public');
            }

            // Crear registro de devolución
            $equipmentReturn = EquipmentReturn::create([
                'Assignment_id' => $request->Assignment_id,
                'Equipment_id' => $request->Equipment_id,
                'User_id' => $request->User_id,
                'Date' => $request->Date,
                'Document' => $documentPath,
                'Image' => $imagePath,
                'Comment' => $request->comentario,
                'Status' => 1
            ]);

            Equipment::where('idEquipment', $request->Equipment_id)
                ->update(['status' => $request->estado]);

            $assignedTeam->update(['Status' => 0]);

            DB::commit();

            return redirect()->route('devolucion.create')
                ->with('success', 'Devolución registrada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($documentPath && Storage::disk('public')->exists($documentPath)) {
                Storage::disk('public')->delete($documentPath);
            }
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            return redirect()->back()
                ->with('error', 'Error al registrar la devolución: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $return = EquipmentReturn::with(['equipment', 'assignment.user'])->findOrFail($id);
        return view('devolucion.edit', compact('return'));
    }

    public function update(Request $request, $id)
    {
        // Implementar lógica de actualización si es necesario
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $return = EquipmentReturn::findOrFail($id);

            // Eliminar archivos
            if ($return->Document) {
                Storage::disk('public')->delete($return->Document);
            }
            if ($return->Image) {
                Storage::disk('public')->delete($return->Image);
            }

            $return->delete();

            DB::commit();

            return redirect()->route('devolucion.index')
                ->with('success', 'Devolución eliminada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('devolucion.index')
                ->with('error', 'Error al eliminar la devolución: ' . $e->getMessage());
        }
    }
}