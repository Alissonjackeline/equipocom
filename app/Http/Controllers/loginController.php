<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('panel');
        }
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        // Validar credenciales (usa Auth::validate como en el ejemplo)
        if (!Auth::validate($request->only('Email', 'Password'))) {
            return redirect()->route('login')->withErrors('Credenciales incorrectas');
        }

        // Obtener usuario por correo electrónico
        $user = Auth::getProvider()->retrieveByCredentials($request->only('Email'));

        // Verificar si el usuario está activo (Status 1)
        if ($user && $user->Status != 1) {
            return redirect()->route('login')->withErrors('Usuario no activo, contacta al administrador');
        }

        // Iniciar sesión
        if (Auth::attempt($request->only('Email', 'Password'))) {
            return redirect()->route('panel')->with('success', $user->Name);
        }

        return redirect()->route('login')->withErrors('Credenciales incorrectas');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }
}