<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipo;

class EquiposController extends Controller
{
    public function index(Request $request)
    {
        $paginaActual = $request->input('pagina', 1); 
        $elementosPorPagina = $request->input('per_page', 10);
    
        $query = Equipo::query();
        $totalElementos = $query->count();
        $totalPaginas = ceil($totalElementos / $elementosPorPagina);
    
        $equipos = $query
            ->skip(($paginaActual - 1) * $elementosPorPagina)
            ->take($elementosPorPagina)
            ->get();
    
        // Obtener el usuario autenticado
        $usuarioAutenticado = auth()->user();
    
        return view('equipos.equipos', compact('equipos', 'paginaActual', 'totalPaginas', 'elementosPorPagina', 'usuarioAutenticado'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ActivoFijo' => 'required|string|max:20|unique:equipos,ActivoFijo',
            'Serial' => 'required|string|max:20|unique:equipos,Serial',
            'Marca' => 'nullable|string|max:45',
            'Modelo' => 'nullable|string|max:45',
            'SalaMovil' => 'nullable|string|max:45',
            'Estado' => 'required|string|max:20',
        ]);

        Equipo::create([
            'ActivoFijo' => $validatedData['ActivoFijo'],
            'Serial' => $validatedData['Serial'],
            'Marca' => $validatedData['Marca'],
            'Modelo' => $validatedData['Modelo'],
            'SalaMovil' => $validatedData['SalaMovil'],
            'Estado' => $validatedData['Estado'],
        ]);

        return redirect()->route('equipos.index')
                         ->with('success', 'Equipo creado exitosamente');
    }

    public function destroy($ActivoFijo, $Serial)
    {
        $equipo = Equipo::where('ActivoFijo', $ActivoFijo)
                       ->where('Serial', $Serial)
                       ->firstOrFail();
        
        $equipo->delete();
        
        return back()->with('success', 'Equipo eliminado correctamente');
    }
}