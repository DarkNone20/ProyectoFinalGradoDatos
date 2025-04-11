<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\UsuarioAdmin;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'Cedula' => 'required|string',
            'Password' => 'required|string'
        ]);

        $usuario = UsuarioAdmin::where('Cedula', $credentials['Cedula'])->first();

        // Verifica si el usuario existe y si la contraseña coincide
        if ($usuario && Hash::check($credentials['Password'], $usuario->Password)) {
            Auth::login($usuario);
            return redirect()->intended('/home');
        }

        return back()->withErrors([
            'loginError' => 'Las credenciales proporcionadas no coinciden con nuestros registros.'
        ])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}