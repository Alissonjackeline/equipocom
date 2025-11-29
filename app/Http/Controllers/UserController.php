<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Exception;

class UserController extends Controller
{
    /**
     * Constructor con middlewares de permisos
     */
    public function __construct()
    {
        $this->middleware('permission:Ver-Usuario', ['only' => ['index', 'show']]);
        $this->middleware('permission:Crear-Usuario', ['only' => ['create', 'store']]);
        $this->middleware('permission:Editar-Usuario', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Estado-Usuario', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->latest()->get();
        $roles = Role::all();
        return view('user.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $fieldHash = Hash::make($request->Password);
            $request->merge(['Password' => $fieldHash]);

            $user = User::create($request->all());
            $user->assignRole($request->role);

            DB::commit();

            return redirect() 
                ->route('user.index')
                ->with('success', 'Usuario creado exitosamente.');

        } catch (Exception $e) {
            DB::rollBack();
            
            return redirect() 
                ->back()
                ->withInput()
                ->with('error', 'Error al crear el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return view('user.show', compact('user'));
        } catch (\Exception $e) {
            return redirect()
                ->route('user.index')
                ->with('error', 'Usuario no encontrado.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $roles = Role::all(); // Agregar esto para pasar los roles a la vista
            return view('user.edit', compact('user', 'roles'));
        } catch (\Exception $e) {
            return redirect()
                ->route('user.index')
                ->with('error', 'Usuario no encontrado.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        try {
            DB::beginTransaction(); // Agregar transacción

            $user = User::findOrFail($id);

            $data = [
                'Document' => $request->document,
                'Name' => $request->name,
                'Phone' => $request->phone,
                'Email' => $request->email,
            ];

            // Actualizar contraseña solo si se proporciona
            if ($request->filled('password')) {
                $data['Password'] = Hash::make($request->password);
            }

            $user->update($data);

            // Actualizar el rol del usuario
            if ($request->has('role')) {
                $user->syncRoles([$request->role]);
            }

            DB::commit();

            return redirect()
                ->route('user.index')
                ->with('success', 'Usuario actualizado exitosamente.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()
                ->route('user.index')
                ->with('error', 'El usuario no existe.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()
                ->route('user.index')
                ->with('error', 'Error en base de datos al actualizar el usuario.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('user.index')
                ->with('error', 'Error al actualizar el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Activar / Desactivar usuario
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);

            $newState = $user->Status == 1 ? 0 : 1;

            $user->update(['Status' => $newState]);

            $message = $newState == 1
                ? 'Usuario activado correctamente.'
                : 'Usuario desactivado correctamente.';

            return redirect()->route('user.index')->with('success', $message);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('user.index')->with('error', 'El usuario no existe.');
        } catch (QueryException $e) {
            return redirect()->route('user.index')->with('error', 'Error en base de datos al cambiar el estado.');
        } catch (\Exception $e) {
            return redirect()->route('user.index')->with('error', 'Ha ocurrido un error. Intenta nuevamente.');
        }
    }
}