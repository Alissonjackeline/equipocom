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
        // Mapeo porque tu BD usa Email y Password
        $credentials = [
            'Email'    => $request->Email,
            'password' => $request->Password // el provider usa password automáticamente
        ];

        // Validar credenciales
        if (!Auth::validate($credentials)) {
            return back()->withErrors('Credenciales incorrectas');
        }

        // Obtener usuario real
        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        // Validar estado
        if ($user->Status != 1) {
            return back()->withErrors('Usuario no activo, contacta al administrador');
        }

        // Iniciar sesión
        if (Auth::attempt($credentials)) {
            return redirect()->route('panel')->with('success', $user->Name);
        }

        return back()->withErrors('Credenciales incorrectas');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}