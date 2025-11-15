<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Headquarters;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class AreaController extends Controller
{
    /**
     * Mostrar listado de áreas
     */
    public function index()
    {
        $areas = Area::with('headquarters')->get();
        $headquarters = Headquarters::where('Status', 1)->get();

        return view('area.index', compact('areas', 'headquarters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Name' => 'required|string|max:70|unique:areas,Name',
            'Headquarters_id' => 'required|integer|exists:headquarters,idHeadquarters'
        ], [
            'Name.required' => 'El nombre del área es obligatorio',
            'Name.unique' => 'Esta área ya está registrada',
            'Name.max' => 'El nombre no debe exceder los 70 caracteres',
            'Headquarters_id.required' => 'Debe seleccionar una sede',
            'Headquarters_id.exists' => 'La sede seleccionada no existe'
        ]);

        try {
            Area::create($request->all());

            return redirect()->route('area.index')
                ->with('success', 'El área se registró correctamente.');
        } catch (QueryException $e) {
            return redirect()->route('area.index')
                ->with('error', 'Error en base de datos al crear el área.');
        }
    }

    /**
     * Actualizar área
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Name' => 'required|string|max:70',
            'Headquarters_id' => 'required|integer|exists:headquarters,idHeadquarters'
        ], [
            'Name.required' => 'El nombre del área es obligatorio',
            'Headquarters_id.required' => 'Debe seleccionar una sede'
        ]);

        try {
            $area = Area::findOrFail($id);
            $area->update($request->all());

            return redirect()->route('area.index')
                ->with('success', 'El área fue actualizada correctamente.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('area.index')
                ->with('error', 'El área no existe.');
        } catch (QueryException $e) {
            return redirect()->route('area.index')
                ->with('error', 'Error en base de datos al actualizar el área.');
        }
    }

    /**
     * Activar / Desactivar área
     */
    public function destroy(string $id)
    {
        try {
            $area = Area::findOrFail($id);

            $newState = $area->Status == 1 ? 0 : 1;

            $area->update(['Status' => $newState]);

            $message = $newState == 1
                ? 'Área activada correctamente.'
                : 'Área desactivada correctamente.';

            return redirect()->route('area.index')->with('success', $message);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('area.index')->with('error', 'El área no existe.');
        } catch (QueryException $e) {
            return redirect()->route('area.index')->with('error', 'Error en base de datos al cambiar el estado.');
        } catch (\Exception $e) {
            return redirect()->route('area.index')->with('error', 'Ha ocurrido un error. Intenta nuevamente.');
        }
    }
}