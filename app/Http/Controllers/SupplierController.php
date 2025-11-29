<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    /**
     * Constructor con middlewares de permisos
     */
    public function __construct()
    {
        $this->middleware('permission:Ver-Proveedor', ['only' => ['index']]);
        $this->middleware('permission:Crear-Proveedor', ['only' => ['store']]);
        $this->middleware('permission:Editar-Proveedor', ['only' => ['update']]);
        $this->middleware('permission:Estado-Proveedor', ['only' => ['destroy']]);
    }

    /**
     * Mostrar listado de proveedores
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return view('proveedor.index', compact('suppliers'));
    }

    /**
     * Guardar nuevo proveedor
     */
    public function store(Request $request)
    {
        $request->validate([
            'Company_name' => 'required|string|max:100|unique:suppliers,Company_name',
            'Ruc' => 'required|string|size:11|unique:suppliers,Ruc',
            'Phone' => 'required|string|max:20',
            'Address' => 'required|string|max:70'
        ], [
            'Company_name.required' => 'El nombre de la empresa es obligatorio',
            'Company_name.unique' => 'Esta empresa ya está registrada',
            'Company_name.max' => 'El nombre no debe exceder los 100 caracteres',
            'Ruc.required' => 'El RUC es obligatorio',
            'Ruc.size' => 'El RUC debe tener 11 dígitos',
            'Ruc.unique' => 'Este RUC ya está registrado',
            'Phone.max' => 'El teléfono no debe exceder los 20 caracteres',
            'Phone.required' => 'El telefono es obligatorio',
            'Address.required' => 'La dirección es obligatoria',
            'Address.max' => 'La dirección no debe exceder los 70 caracteres'
        ]);

        try {
            Supplier::create($request->all());

            return redirect()->route('proveedor.index')
                ->with('success', 'El proveedor se registró correctamente.');

        } catch (QueryException $e) {
            return redirect()->route('proveedor.index')
                ->with('error', 'Error en base de datos al crear el proveedor.');
        }
    }

    /**
     * Actualizar proveedor
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Company_name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('suppliers', 'Company_name')->ignore($id, 'idSupplier')
            ],
            'Ruc' => [
                'required',
                'string',
                'size:11',
                Rule::unique('suppliers', 'Ruc')->ignore($id, 'idSupplier')
            ],
            'Phone' => 'required|string|max:20',
            'Address' => 'required|string|max:70'
        ], [
            'Company_name.required' => 'El nombre de la empresa es obligatorio',
            'Company_name.unique' => 'Esta empresa ya está registrada',
            'Ruc.required' => 'El RUC es obligatorio',
            'Ruc.size' => 'El RUC debe tener 11 dígitos',
            'Ruc.unique' => 'Este RUC ya está registrado',
            'Address.required' => 'La dirección es obligatoria'
        ]);

        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->update($request->all());

            return redirect()->route('proveedor.index')
                ->with('success', 'El proveedor fue actualizado correctamente.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('proveedor.index')
                ->with('error', 'El proveedor no existe.');
        } catch (QueryException $e) {
            return redirect()->route('proveedor.index')
                ->with('error', 'Error en base de datos al actualizar el proveedor.');
        }
    }

    public function destroy(string $id)
    {
        try {
            $supplier = Supplier::findOrFail($id);

            $newState = $supplier->Status == 1 ? 0 : 1;

            $supplier->update(['Status' => $newState]);

            $message = $newState == 1
                ? 'Proveedor activado correctamente.'
                : 'Proveedor desactivado correctamente.';

            return redirect()->route('proveedor.index')->with('success', $message);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('proveedor.index')->with('error', 'El proveedor no existe.');
        } catch (QueryException $e) {
            return redirect()->route('proveedor.index')->with('error', 'Error en base de datos al cambiar el estado.');
        } catch (\Exception $e) {
            return redirect()->route('proveedor.index')->with('error', 'Ha ocurrido un error. Intenta nuevamente.');
        }
    }
}