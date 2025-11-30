<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Perfil', ['only' => ['index', 'update']]);
    }
    
    public function index()
    {
        $user = User::find(Auth::user()->idUser);
        
        if (!$user) {
            return redirect()->route('panel')->with('error', 'Usuario no encontrado.');
        }
        
        return view('profile.index', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        if (Auth::user()->idUser != $id) {
            return redirect()->route('profile.index')
                ->with('error', 'No tiene permisos para modificar este perfil.');
        }

        $request->validate([
            'Document' => 'required|max:8|regex:/^[0-9]+$/',
            'Name' => 'required|max:100',
            'Phone' => 'required|max:9|regex:/^[0-9]+$/',
            'Email' => 'required|email|max:50|unique:users,Email,' . $id . ',idUser',
            'Password' => 'nullable|min:6',
        ], [
            'Document.required' => 'El DNI es obligatorio',
            'Document.max' => 'El DNI debe tener máximo 8 caracteres',
            'Document.regex' => 'El DNI solo debe contener números',
            'Name.required' => 'El nombre es obligatorio',
            'Name.max' => 'El nombre debe tener máximo 100 caracteres',
            'Phone.required' => 'El teléfono es obligatorio',
            'Phone.max' => 'El teléfono debe tener máximo 9 caracteres',
            'Phone.regex' => 'El teléfono solo debe contener números',
            'Email.required' => 'El email es obligatorio',
            'Email.email' => 'Debe ser un email válido',
            'Email.unique' => 'Este email ya está registrado',
            'Password.min' => 'La contraseña debe tener al menos 6 caracteres',
        ]);

        $data = [
            'Document' => $request->Document,
            'Name' => $request->Name,
            'Phone' => $request->Phone,
            'Email' => $request->Email,
        ];

        if (!empty($request->Password)) {
            $data['Password'] = Hash::make($request->Password);
        }

        $user->update($data);

        return redirect()->route('profile.index')
            ->with('success', 'Perfil actualizado exitosamente.');
    }
}