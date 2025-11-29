<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    /**
     * Constructor con middlewares de permisos
     */
    public function __construct()
    {
        $this->middleware('permission:Ver-Inventario', ['only' => ['index']]);
        $this->middleware('permission:Crear-Inventario', ['only' => ['create', 'store']]);
        $this->middleware('permission:Editar-Inventario', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Eliminar-Inventario', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $equipmentTypes = EquipmentType::where('Status', 1)->get();
        $suppliers = Supplier::where('Status', 1)->get();
        $equipmentsAll = Equipment::with(['equipmentType', 'supplier'])->get();
        $usuarioFiltro = $request->has('tipo_id') || $request->has('estado_id');

        if (!$usuarioFiltro) {
            return view('inventario.index', [
                'equipments' => collect([]),  
                'equipmentsAll' => $equipmentsAll, 
                'equipmentTypes' => $equipmentTypes,
                'suppliers' => $suppliers,
            ]);
        }

        $equipments = Equipment::with(['equipmentType', 'supplier'])
            ->when($request->tipo_id !== null && $request->tipo_id !== '', function ($q) use ($request) {
                $q->where('equipmentType_id', $request->tipo_id);
            })
            ->when($request->estado_id !== null && $request->estado_id !== '', function ($q) use ($request) {
                $q->where('Status', $request->estado_id);
            })
            ->get();

        return view('inventario.index', compact('equipments', 'equipmentsAll', 'equipmentTypes', 'suppliers'));
    }

    public function create()
    {
        $equipmentTypes = EquipmentType::where('Status', 1)->get();
        $suppliers = Supplier::where('Status', 1)->get();

        return view('inventario.create', compact('equipmentTypes', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'EquipmentType_id' => 'required|integer|exists:equipment_types,idEquipmentType',
            'CodigoPatri' => 'required|string|max:50|unique:equipment,CodigoPatri',
            'Series' => 'required|string|max:50|unique:equipment,Series',
            'Model' => 'required|string|max:50',
            'Brand' => 'required|string|max:50',
            'Description' => 'required|string|max:150',
            'Price' => 'nullable|numeric|min:0|max:99999999.99',
            'Supplier_id' => 'required|integer|exists:suppliers,idSupplier',
            'status' => 'required|integer|between:1,8',
            'Imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $data = $request->all();

            if ($request->hasFile('Imagen')) {
                $image = $request->file('Imagen');
                $imageName = 'equipment_' . time() . '.' . $image->getClientOriginalExtension();

                // Guardar en storage/app/public/equipments
                $path = $image->storeAs('equipments', $imageName, 'public');
                $data['Imagen'] = $path;
            }

            Equipment::create($data);

            return redirect()->route('inventario.create')
                ->with('success', 'El equipo se registró correctamente.');
        } catch (QueryException $e) {
            return redirect()->route('inventario.create')
                ->with('error', 'Error en base de datos al crear el equipo.')
                ->withInput();
        }
    }

    public function edit($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipmentTypes = EquipmentType::where('Status', 1)->get();
        $suppliers = Supplier::where('Status', 1)->get();

        return view('inventario.edit', compact('equipment', 'equipmentTypes', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $equipment = Equipment::findOrFail($id);

        $request->validate([
            'EquipmentType_id' => 'required|integer|exists:equipment_types,idEquipmentType',
            'CodigoPatri' => [
                'required',
                'string',
                'max:50',
                Rule::unique('equipment', 'CodigoPatri')->ignore($id, 'idEquipment')
            ],
            'Series' => [
                'required',
                'string',
                'max:50',
                Rule::unique('equipment', 'Series')->ignore($id, 'idEquipment')
            ],
            'Model' => 'required|string|max:50',
            'Brand' => 'required|string|max:50',
            'Description' => 'required|string|max:150',
            'Price' => 'required|numeric|min:0|max:99999999.99',
            'Supplier_id' => 'required|integer|exists:suppliers,idSupplier',
            'status' => 'required|integer|between:1,8',
            'Imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $data = $request->all();

            if ($request->hasFile('Imagen')) {
                if ($equipment->Imagen && Storage::disk('public')->exists($equipment->Imagen)) {
                    Storage::disk('public')->delete($equipment->Imagen);
                }

                $image = $request->file('Imagen');
                $imageName = 'equipment_' . time() . '.' . $image->getClientOriginalExtension();

                $path = $image->storeAs('equipments', $imageName, 'public');
                $data['Imagen'] = $path;
            }

            $equipment->update($data);

            return redirect()->route('inventario.index')
                ->with('success', 'El equipo fue actualizado correctamente.');
        } catch (QueryException $e) {
            return redirect()->route('inventario.edit', $id)
                ->with('error', 'Error en base de datos al actualizar el equipo.')
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $equipment = Equipment::findOrFail($id);

            if ($equipment->Imagen && Storage::disk('public')->exists($equipment->Imagen)) {
                Storage::disk('public')->delete($equipment->Imagen);
            }

            $equipment->delete();

            return redirect()->route('inventario.index')
                ->with('success', 'El equipo fue eliminado correctamente.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('inventario.index')
                ->with('error', 'El equipo no existe.');
        } catch (QueryException $e) {
            return redirect()->route('inventario.index')
                ->with('error', 'Error en base de datos al eliminar el equipo.');
        }
    }

    /**
     * Mostrar historial de inventario
     */
    public function historialinventario()
    {
        return view('inventario.historial');
    }
}