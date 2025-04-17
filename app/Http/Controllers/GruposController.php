<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupos;

class GruposController extends Controller
{
    public function index(Request $request)
    {
        $paginaActual = $request->input('pagina', 1); 
        $elementosPorPagina = $request->input('per_page', 10);
    
        $query = Grupos::query();
        $totalElementos = $query->count();
        $totalPaginas = ceil($totalElementos / $elementosPorPagina);
    
        $grupos = $query
            ->skip(($paginaActual - 1) * $elementosPorPagina)
            ->take($elementosPorPagina)
            ->get();
    
        $usuarioAutenticado = auth()->user();
    
        return view('grupos.grupos', compact('grupos', 'paginaActual', 'totalPaginas', 'elementosPorPagina', 'usuarioAutenticado'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'IdGrupo' => 'required|integer|unique:grupos,IdGrupo',
            'NombreProfesor' => 'required|string|max:45',
            'NombreCurso' => 'nullable|string|max:45',
            'FechaInicial' => 'nullable|date',
            'FechaFinal' => 'nullable|date|after_or_equal:FechaInicial',
            'HoraInicial' => 'nullable|date_format:H:i',
            'HoraFinal' => 'nullable|date_format:H:i|after:HoraInicial'
        ]);

        Grupos::create($validatedData);

        return redirect()->route('grupos.index')
                         ->with('success', 'Grupo creado exitosamente');
    }

    public function destroy($IdGrupo)
    {
        $grupo = Grupos::findOrFail($IdGrupo);
        $grupo->delete();
        
        return back()->with('success', 'Grupo eliminado correctamente');
    }
}