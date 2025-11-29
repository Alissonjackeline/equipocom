<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller  // ← Cambiado de 'roleController' a 'RoleController'
{
    function __construct()
    {
        $this->middleware('permission:Ver-Rol|Crear-Rol|Editar-Rol|Eliminar-Rol', ['only' => ['index']]);
        $this->middleware('permission:Crear-Rol', ['only' => ['create', 'store']]);
        $this->middleware('permission:Editar-Rol', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Eliminar-Rol', ['only' => ['destroy']]);
    }

    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('role.index', compact('roles', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('role.create', compact('permissions'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required|array',
            'permission.*' => 'exists:permissions,id',
        ]);

        try {
            $role = Role::create(['name' => $request->name]);
            $permissions = Permission::whereIn('id', $request->permission)->get();

            if ($permissions->isEmpty()) {
                throw new \Exception('No se encontraron permisos válidos para asignar al rol.');
            }

            $role->syncPermissions($permissions);

            return redirect()->route('roles.index')->with('success', 'Rol agregado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('roles.index')->with('error', 'Error al agregar el rol: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permission' => 'required|array',
            'permission.*' => 'exists:permissions,id',
        ]);

        try {
            DB::beginTransaction();

            $role->update(['name' => $request->name]);
            $permissions = Permission::whereIn('id', $request->permission)->get();
            $role->syncPermissions($permissions);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al actualizar el rol.');
        }

        return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Role::where('id', $id)->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado');
    }
}