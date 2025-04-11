<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsuarioAdmin;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    public function index()
    {
        $usuarios = UsuarioAdmin::all();
        return view("usuarios.usuarios", compact('usuarios'));
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Cedula' => 'required|string|max:20|unique:UsuariosAdmin,Cedula',
            'Alias' => 'nullable|string|max:20',
            'Nombre' => 'required|string|max:45',
            'Password' => 'required|string|min:6',
            'Cargo' => 'nullable|string|max:20',
        ]);

        UsuarioAdmin::create([
            'Cedula' => $validatedData['Cedula'],
            'Alias' => $validatedData['Alias'],
            'Nombre' => $validatedData['Nombre'],
            'Password' => Hash::make($validatedData['Password']),
            'Cargo' => $validatedData['Cargo'],
        ]);

        return redirect()->route('usuarios.index')
                         ->with('success', 'Usuario creado exitosamente');
    }
}