<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestamos;
use App\Models\Documento;

class PrestamoController extends Controller
{
    public function index(Request $request)
    {
        $paginaActual = $request->input('pagina', 1); 
        $elementosPorPagina = $request->input('per_page', 15);
    
        $query = Prestamos::query();
        $totalElementos = $query->count();
        $totalPaginas = ceil($totalElementos / $elementosPorPagina);
    
        $prestamos = $query
            ->skip(($paginaActual - 1) * $elementosPorPagina)
            ->take($elementosPorPagina)
            ->get();
    
        
        $usuarioAutenticado = auth()->user();
    
        return view('prestamo.prestamos', compact('prestamos', 'paginaActual', 'totalPaginas', 'elementosPorPagina', 'usuarioAutenticado'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'IdPrestamo' => 'required|integer|unique:prestamos,IdPrestamo',
            'Serial' => 'required|string|max:20',
            'ActivoFijo' => 'required|string|max:20',
            'GrupoId' => 'required|integer|exists:grupos,IdGrupo',
            'DocumentoId' => 'required|string|max:20|exists:documentos,IdDocumento',
            'SalaMovil' => 'nullable|string|max:45',
            'FechaI' => 'required|date',
            'FechaF' => 'required|date|after_or_equal:FechaI',
            'HoraI' => 'required|date_format:H:i:s',
            'HoraF' => 'required|date_format:H:i:s',
            'Duracion' => 'required|integer|min:1'
        ]);

        Prestamos::create([
            'IdPrestamo' => $validatedData['IdPrestamo'],
            'Serial' => $validatedData['Serial'],
            'ActivoFijo' => $validatedData['ActivoFijo'],
            'GrupoId' => $validatedData['GrupoId'],
            'DocumentoId' => $validatedData['DocumentoId'],
            'SalaMovil' => $validatedData['SalaMovil'],
            'FechaI' => $validatedData['FechaI'],
            'FechaF' => $validatedData['FechaF'],
            'HoraI' => $validatedData['HoraI'],
            'HoraF' => $validatedData['HoraF'],
            'Duracion' => $validatedData['Duracion']
        ]);

        return redirect()->route('prestamos.index')
                         ->with('success', 'Préstamo creado exitosamente');
    }

    public function destroy($IdPrestamo)
    {
        $prestamo = Prestamos::where('IdPrestamo', $IdPrestamo)
                       ->firstOrFail();
        
        $prestamo->delete();
        
        return back()->with('success', 'Préstamo eliminado correctamente');
    }
}