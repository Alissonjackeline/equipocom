<?php

namespace App\Http\Controllers;

use App\Models\Headquarters;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class HeadquartersController extends Controller
{
    /**
     * Mostrar listado
     */
    public function index()
    {
        $headquarters = Headquarters::with('entity')->get();

        return view('sede.index', compact('headquarters'));
    }

    /**
     * Guardar nueva sede
     */
    public function store(Request $request)
    {
        $request->validate([
            'Name'      => 'required|string|max:70|unique:headquarters,Name',
            'Address'   => 'required|string|max:70',
            'Phone'     => 'nullable|string|max:20',
            'Entity_id' => 'required|integer'
        ], [
            'Name.required' => 'El nombre de la sede es obligatorio',
            'Name.unique' => 'Esta sede ya está registrada',
            'Name.max' => 'El nombre no debe exceder los 70 caracteres',
            'Address.required' => 'La dirección es obligatoria',
            'Entity_id.required' => 'La entidad es obligatoria'
        ]);

        Headquarters::create($request->all());

        return redirect()->route('sede.index')
            ->with('success', 'La sede se registró correctamente.');
    }

    /**
     * Actualizar sede
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Name'      => 'required|string|max:70',
            'Address'   => 'required|string|max:70',
            'Phone'     => 'nullable|string|max:20',
            'Entity_id' => 'required|integer'
        ]);

        $hq = Headquarters::findOrFail($id);
        $hq->update($request->all());

        return redirect()->route('sede.index')
            ->with('success', 'La sede fue actualizada correctamente.');
    }

    /**
     * Activar / Desactivar sede
     */
    public function destroy(string $id)
    {
        try {
            $hq = Headquarters::findOrFail($id);

            $newState = $hq->Status == 1 ? 0 : 1;

            $hq->update(['Status' => $newState]);

            $message = $newState == 1
                ? 'Sede activada correctamente.'
                : 'Sede desactivada correctamente.';

            return redirect()->route('sede.index')->with('success', $message);
        } catch (QueryException $e) {
            return redirect()->route('sede.index')->with('error', 'Error en base de datos al cambiar el estado.');
        } catch (\Exception $e) {
            return redirect()->route('sede.index')->with('error', 'Ha ocurrido un error. Intenta nuevamente.');
        }
    }
}