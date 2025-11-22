<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->get();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $user = User::create([
                'Document' => $request->document,
                'Name' => $request->name,
                'Phone' => $request->phone,
                'Email' => $request->email,
                'Password' => Hash::make($request->password),
                'Status' => 1, // Activo por defecto
            ]);

            return redirect()
                ->route('user.create')
                ->with('success', 'Usuario creado exitosamente.');

        } catch (QueryException $e) {
            return redirect()
                ->route('user.create')
                ->with('error', 'Error en base de datos al crear el usuario.')
                ->withInput();
        } catch (\Exception $e) {
            return redirect()
                ->route('user.create')
                ->with('error', 'Error al crear el usuario: ' . $e->getMessage())
                ->withInput();
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
            return view('user.edit', compact('user'));
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

            return redirect()
                ->route('user.index')
                ->with('success', 'Usuario actualizado exitosamente.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route('user.index')
                ->with('error', 'El usuario no existe.');
        } catch (QueryException $e) {
            return redirect()
                ->route('user.index')
                ->with('error', 'Error en base de datos al actualizar el usuario.');
        } catch (\Exception $e) {
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