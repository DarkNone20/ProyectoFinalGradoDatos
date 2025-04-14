<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsuarioAdmin;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    public function index(Request $request)
    {
        $paginaActual = $request->input('pagina', 1); 
        $elementosPorPagina = $request->input('per_page', 10);
    
        $query = UsuarioAdmin::query();
        $totalElementos = $query->count();
        $totalPaginas = ceil($totalElementos / $elementosPorPagina);
    
        $usuarios = $query
            ->skip(($paginaActual - 1) * $elementosPorPagina)
            ->take($elementosPorPagina)
            ->get();
    
        // Obtener el usuario autenticado
        $usuarioAutenticado = auth()->user();
    
        return view('usuarios.usuarios', compact('usuarios', 'paginaActual', 'totalPaginas', 'elementosPorPagina', 'usuarioAutenticado'));
    }

    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Cedula' => 'required|string|max:20|unique:UsuariosAdmin,Cedula',
            'Alias' => 'nullable|string|max:50',
            'Nombre' => 'required|string|max:50',
            'Password' => 'required|string|min:6',
            'Cargo' => 'nullable|string|max:50',
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

    public function destroy($cedula)
    {
        $usuario = UsuarioAdmin::findOrFail($cedula);
        $usuario->delete();
        return back()->with('success', 'Usuario eliminado correctamente');
    }
}