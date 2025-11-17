<?php

namespace App\Http\Controllers;

use App\Models\Boss;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

class BossController extends Controller
{
    /**
     * Mostrar listado de jefes
     */
    public function index()
    {
        $bosses = Boss::with('area')->get();
        $areas = Area::where('Status', 1)->get();

        return view('jefes.index', compact('bosses', 'areas'));
    }

    /**
     * Guardar nuevo jefe
     */
    public function store(Request $request)
    {
        $request->validate([
            'Document' => 'required|string|size:8|unique:bosses,Document',
            'Name' => 'required|string|max:70',
            'Cargo' => 'required|string|max:70',
            'Area_id' => 'required|integer|exists:areas,idArea',
            'Phone' => 'required|string|max:9'
        ], [
            'Document.required' => 'El DNI es obligatorio',
            'Document.size' => 'El DNI debe tener 8 dígitos',
            'Document.unique' => 'Este DNI ya está registrado',
            'Name.required' => 'El nombre es obligatorio',
            'Name.max' => 'El nombre no debe exceder los 70 caracteres',
            'Cargo.required' => 'El cargo es obligatorio',
            'Cargo.max' => 'El cargo no debe exceder los 70 caracteres',
            'Area_id.required' => 'Debe seleccionar un área',
            'Phone.required' => 'El Telefono es obligatorio',
            'Area_id.exists' => 'El área seleccionada no existe',
            'Phone.max' => 'El teléfono no debe exceder los 20 caracteres'
        ]);

        try {
            Boss::create($request->all());

            return redirect()->route('jefes.index')
                ->with('success', 'El jefe se registró correctamente.');

        } catch (QueryException $e) {
            return redirect()->route('jefes.index')
                ->with('error', 'Error en base de datos al crear el jefe.');
        }
    }

    /**
     * Actualizar jefe
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Document' => [
                'required',
                'string',
                'size:8',
                Rule::unique('bosses', 'Document')->ignore($id, 'idBoss')
            ],
            'Name' => 'required|string|max:70',
            'Cargo' => 'required|string|max:70',
            'Area_id' => 'required|integer|exists:areas,idArea',
            'Phone' => 'nullable|string|max:20'
        ], [
            'Document.required' => 'El DNI es obligatorio',
            'Document.size' => 'El DNI debe tener 8 dígitos',
            'Document.unique' => 'Este DNI ya está registrado',
            'Name.required' => 'El nombre es obligatorio',
            'Cargo.required' => 'El cargo es obligatorio',
            'Area_id.required' => 'Debe seleccionar un área'
        ]);

        try {
            $boss = Boss::findOrFail($id);
            $boss->update($request->all());

            return redirect()->route('jefes.index')
                ->with('success', 'El jefe fue actualizado correctamente.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('jefes.index')
                ->with('error', 'El jefe no existe.');
        } catch (QueryException $e) {
            return redirect()->route('jefes.index')
                ->with('error', 'Error en base de datos al actualizar el jefe.');
        }
    }

    /**
     * Activar / Desactivar jefe
     */
    public function destroy(string $id)
    {
        try {
            $boss = Boss::findOrFail($id);

            $newState = $boss->Status == 1 ? 0 : 1;

            $boss->update(['Status' => $newState]);

            $message = $newState == 1
                ? 'Jefe activado correctamente.'
                : 'Jefe desactivado correctamente.';

            return redirect()->route('jefes.index')->with('success', $message);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('jefes.index')->with('error', 'El jefe no existe.');
        } catch (QueryException $e) {
            return redirect()->route('jefes.index')->with('error', 'Error en base de datos al cambiar el estado.');
        } catch (\Exception $e) {
            return redirect()->route('jefes.index')->with('error', 'Ha ocurrido un error. Intenta nuevamente.');
        }
    }
}