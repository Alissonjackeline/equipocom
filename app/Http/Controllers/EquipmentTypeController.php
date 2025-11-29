<?php

namespace App\Http\Controllers;

use App\Models\EquipmentType;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

class EquipmentTypeController extends Controller
{
    /**
     * Constructor con middlewares de permisos
     */
    public function __construct()
    {
        $this->middleware('permission:Ver-Tipo-Equipo', ['only' => ['index']]);
        $this->middleware('permission:Crear-Tipo-Equipo', ['only' => ['store']]);
        $this->middleware('permission:Editar-Tipo-Equipo', ['only' => ['update']]);
        $this->middleware('permission:Estado-Tipo-Equipo', ['only' => ['destroy']]);
    }

    /**
     * Mostrar listado de tipos de equipo
     */
    public function index()
    {
        $equipmentTypes = EquipmentType::all();
        return view('tipoequipo.index', compact('equipmentTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Name' => 'required|string|max:100|unique:equipment_types,Name',
            'Description' => 'nullable|string|max:150'
        ], [
            'Name.required' => 'El nombre del tipo de equipo es obligatorio',
            'Name.unique' => 'Este tipo de equipo ya está registrado',
            'Name.max' => 'El nombre no debe exceder los 100 caracteres',
            'Description.max' => 'La descripción no debe exceder los 150 caracteres'
        ]);

        try {
            EquipmentType::create($request->all());

            return redirect()->route('tipoequipo.index')
                ->with('success', 'El tipo de equipo se registró correctamente.');

        } catch (QueryException $e) {
            return redirect()->route('tipoequipo.index')
                ->with('error', 'Error en base de datos al crear el tipo de equipo.');
        }
    }

    /**
     * Actualizar tipo de equipo
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('equipment_types', 'Name')->ignore($id, 'idEquipmentType')
            ],
            'Description' => 'nullable|string|max:150'
        ], [
            'Name.required' => 'El nombre del tipo de equipo es obligatorio',
            'Name.unique' => 'Este tipo de equipo ya está registrado',
            'Name.max' => 'El nombre no debe exceder los 100 caracteres',
            'Description.max' => 'La descripción no debe exceder los 150 caracteres'
        ]);

        try {
            $equipmentType = EquipmentType::findOrFail($id);
            $equipmentType->update($request->all());

            return redirect()->route('tipoequipo.index')
                ->with('success', 'El tipo de equipo fue actualizado correctamente.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('tipoequipo.index')
                ->with('error', 'El tipo de equipo no existe.');
        } catch (QueryException $e) {
            return redirect()->route('tipoequipo.index')
                ->with('error', 'Error en base de datos al actualizar el tipo de equipo.');
        }
    }

    public function destroy(string $id)
    {
        try {
            $equipmentType = EquipmentType::findOrFail($id);

            $newState = $equipmentType->Status == 1 ? 0 : 1;

            $equipmentType->update(['Status' => $newState]);

            $message = $newState == 1
                ? 'Tipo de equipo activado correctamente.'
                : 'Tipo de equipo desactivado correctamente.';

            return redirect()->route('tipoequipo.index')->with('success', $message);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('tipoequipo.index')->with('error', 'El tipo de equipo no existe.');
        } catch (QueryException $e) {
            return redirect()->route('tipoequipo.index')->with('error', 'Error en base de datos al cambiar el estado.');
        } catch (\Exception $e) {
            return redirect()->route('tipoequipo.index')->with('error', 'Ha ocurrido un error. Intenta nuevamente.');
        }
    }
}