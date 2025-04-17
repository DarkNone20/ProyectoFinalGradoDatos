<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $paginaActual = $request->input('pagina', 1); 
        $elementosPorPagina = $request->input('per_page', 10);
    
        $query = Users::query();
        $totalElementos = $query->count();
        $totalPaginas = ceil($totalElementos / $elementosPorPagina);
    
        $usuarios = $query
            ->skip(($paginaActual - 1) * $elementosPorPagina)
            ->take($elementosPorPagina)
            ->get();
    
        // Obtener el usuario autenticado
        $usuarioAutenticado = auth()->user();
    
        return view('usuarios.users', compact('usuarios', 'paginaActual', 'totalPaginas', 'elementosPorPagina', 'usuarioAutenticado'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'DocumentoId' => 'required|string|max:20|unique:Usuarios,DocumentoId',
            'Nombre' => 'required|string|max:45',
            'Apellido' => 'nullable|string|max:45',
            'Direccion' => 'nullable|string|max:100',
            'Telefono' => 'nullable|string|max:15',
            'Email' => 'required|string|email|max:100|unique:Usuarios,Email',
            'password' => 'required|string|min:6',
        ]);

        Users::create([
            'DocumentoId' => $validatedData['DocumentoId'],
            'Nombre' => $validatedData['Nombre'],
            'Apellido' => $validatedData['Apellido'],
            'Direccion' => $validatedData['Direccion'],
            'Telefono' => $validatedData['Telefono'],
            'Email' => $validatedData['Email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect()->route('users.index')
                         ->with('success', 'Usuario creado exitosamente');
    }

    public function destroy($documentoId)
    {
        $usuario = Users::findOrFail($documentoId);
        $usuario->delete();
        return back()->with('success', 'Usuario eliminado correctamente');
    }
}