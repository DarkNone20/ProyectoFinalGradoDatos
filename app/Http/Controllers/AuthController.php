<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UsuarioAdmin;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Vista para el login
    }

    public function login(Request $request)
    {
        $credentials = $request->only('Cedula', 'Password');

        $usuarioAdmin = UsuarioAdmin::where('Cedula', $credentials['Cedula'])->first();

        if ($usuarioAdmin && $credentials['Password'] === $usuarioAdmin->Password) {
            // Autenticación exitosa
            Auth::login($usuarioAdmin);
            return redirect()->intended('/home'); // Redirige al dashboard
        }

        // Autenticación fallida
        return back()->withErrors(['loginError' => 'Credenciales incorrectas'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}