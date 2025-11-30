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
use App\Models\User;

class DevolucionController extends Controller
{
    public function index()
    {
        $returns = EquipmentReturn::with(['assignment.user', 'equipment.equipmentType', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();
        $users = User::where('Status', 1)->get();
        return view('devolucion.index', compact('returns','users'));
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
            'assignedTeams' => function ($query) {
                $query->where('Status', 1); // SOLO assigned_teams activos
            },
            'assignedTeams.equipment.equipmentType',
            'assignedTeams.equipment.supplier'
        ])
            ->where('Boss_id', $bossId)
            ->where('Status', 1)
            ->whereHas('assignedTeams', function ($query) {
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
            'estado' => 'required|in:1,2,4,5',
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

            if ($request->hasFile('documento')) {
                $documentFile = $request->file('documento');
                $documentName = 'devolucion_doc_' . $currentDate . '_' . uniqid() . '.' . $documentFile->getClientOriginalExtension();
                $documentPath = $documentFile->storeAs('documents/returns', $documentName, 'public');
            }

            if ($request->hasFile('imagen')) {
                $imageFile = $request->file('imagen');
                $imageName = 'devolucion_img_' . $currentDate . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                $imagePath = $imageFile->storeAs('images/returns', $imageName, 'public');
            }
            $devolucion = ($request->estado == 1) ? 1 : 0;

            $equipmentReturn = EquipmentReturn::create([
                'Assignment_id' => $request->Assignment_id,
                'Equipment_id' => $request->Equipment_id,
                'User_id' => $request->User_id,
                'Date' => $request->Date,
                'Devolucion' => $devolucion,
                'Document' => $documentPath,
                'Image' => $imagePath,
                'Comment' => $request->comentario,
                'Status' => $request->estado
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'Date' => 'required|date',
            'estado' => 'required|in:1,2,4,5,6',
            'comentario' => 'nullable|string|max:150',
            'documento' => 'nullable|file|mimes:pdf|max:2048',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            DB::beginTransaction();

            $equipmentReturn = EquipmentReturn::findOrFail($id);

            $currentDate = now()->format('Ymd_His');
            $documentPath = $equipmentReturn->Document;
            $imagePath = $equipmentReturn->Image;

            if ($request->hasFile('documento')) {
                if ($documentPath && Storage::disk('public')->exists($documentPath)) {
                    Storage::disk('public')->delete($documentPath);
                }

                $documentFile = $request->file('documento');
                $documentName = 'devolucion_doc_' . $currentDate . '_' . uniqid() . '.' . $documentFile->getClientOriginalExtension();
                $documentPath = $documentFile->storeAs('documents/returns', $documentName, 'public');
            }

            if ($request->hasFile('imagen')) {
                // Eliminar imagen anterior si existe
                if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }

                $imageFile = $request->file('imagen');
                $imageName = 'devolucion_img_' . $currentDate . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                $imagePath = $imageFile->storeAs('images/returns', $imageName, 'public');
            }

            $devolucion = ($request->estado == 1) ? 1 : 0;
            $equipmentReturn->update([
                'Date' => $request->Date,
                'Devolucion' => $devolucion,
                'Document' => $documentPath,
                'Image' => $imagePath,
                'Comment' => $request->comentario,
                'Status' => $request->estado
            ]);

            Equipment::where('idEquipment', $equipmentReturn->Equipment_id)
                ->update(['status' => $request->estado]);

            $assignedTeam = AssignedTeam::where('Assignment_id', $equipmentReturn->Assignment_id)
                ->where('Equipment_id', $equipmentReturn->Equipment_id)
                ->first();

            if ($assignedTeam) {
                $assignedTeam->update([
                    'Status' => ($request->estado == 1) ? 0 : 1
                ]);
            }

            DB::commit();

            return redirect()->route('devolucion.index')
                ->with('success', 'Devolución actualizada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('devolucion.index')
                ->with('error', 'Error al actualizar la devolución: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $return = EquipmentReturn::findOrFail($id);

            $assignmentId = $return->Assignment_id;
            $equipmentId = $return->Equipment_id;

            $posteriorAssignments = AssignedTeam::where('Equipment_id', $equipmentId)
                ->where('created_at', '>', $return->created_at)
                ->exists();

            if ($posteriorAssignments) {
                return redirect()->route('devolucion.index')
                    ->with('error', 'No se puede eliminar esta devolución.');
            }

            $posteriorReturns = EquipmentReturn::where('Equipment_id', $equipmentId)
                ->where('created_at', '>', $return->created_at)
                ->exists();

            if ($posteriorReturns) {
                return redirect()->route('devolucion.index')
                    ->with('error', 'No se puede eliminar esta devolución porque existen devoluciones posteriores del mismo equipo.');
            }

            $equipment = Equipment::find($equipmentId);

            if ($equipment && $equipment->status == 3) {
                return redirect()->route('devolucion.index')
                    ->with('error', 'No se puede eliminar porque el equipo cuenta con historial.');
            }

            AssignedTeam::where('Assignment_id', $assignmentId)
                ->where('Equipment_id', $equipmentId)
                ->update(['Status' => 1]);

            Equipment::where('idEquipment', $equipmentId)
                ->update(['status' => 3]);

            if ($return->Document && Storage::disk('public')->exists($return->Document)) {
                Storage::disk('public')->delete($return->Document);
            }
            if ($return->Image && Storage::disk('public')->exists($return->Image)) {
                Storage::disk('public')->delete($return->Image);
            }

            $return->delete();

            DB::commit();

            return redirect()->route('devolucion.index')
                ->with('success', 'Devolución eliminada exitosamente. La asignación ha sido reactivada.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('devolucion.index')
                ->with('error', 'Error al eliminar la devolución: ' . $e->getMessage());
        }
    }
}