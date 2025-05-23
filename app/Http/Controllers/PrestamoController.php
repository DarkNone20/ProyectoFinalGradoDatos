<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestamos;
use App\Models\Equipo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exports\PrestamosExport2;  

class PrestamoController extends Controller
{
    public function index(Request $request)
    {
        $paginaActual = $request->input('pagina', 1); 
        $elementosPorPagina = $request->input('per_page', 15);
    
        $query = Prestamos::with(['usuario', 'equipo', 'grupo'])
            ->orderBy('FechaI', 'desc')
            ->orderBy('HoraI', 'desc');
    
        // Filtros opcionales
        if ($request->has('estado')) {
            $query->where('Estado', $request->estado);
        }
        
        if ($request->has('documento_id')) {
            $query->where('DocumentoId', $request->documento_id);
        }
        
        if ($request->has('serial')) {
            $query->where('Serial', 'like', '%'.$request->serial.'%');
        }

        $totalElementos = $query->count();
        $totalPaginas = ceil($totalElementos / $elementosPorPagina);
    
        $prestamos = $query
            ->skip(($paginaActual - 1) * $elementosPorPagina)
            ->take($elementosPorPagina)
            ->get();
    
        $usuarioAutenticado = auth()->user();
    
        return view('prestamo.prestamos', compact(
            'prestamos', 
            'paginaActual', 
            'totalPaginas', 
            'elementosPorPagina', 
            'usuarioAutenticado'
        ));
    }

    public function create()
    {
        // Lógica para mostrar el formulario de creación
        return view('prestamo.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'IdPrestamo' => 'required|integer|unique:Prestamos,IdPrestamo',
            'Serial' => 'required|string|max:20|exists:Equipos,Serial',
            'ActivoFijo' => 'required|string|max:20|exists:Equipos,ActivoFijo',
            'GrupoId' => 'required|integer|exists:Grupos,IdGrupo',
            'DocumentoId' => 'required|string|max:20|exists:Usuarios,DocumentoId',
            'SalaMovil' => 'nullable|string|max:45',
            'FechaI' => 'required|date',
            'FechaF' => 'required|date|after_or_equal:FechaI',
            'HoraI' => 'required|date_format:H:i:s',
            'HoraF' => 'required|date_format:H:i:s|after:HoraI',
            'Duracion' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            $prestamo = Prestamos::create([
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
                'Duracion' => $validatedData['Duracion'],
                'Estado' => 'Activo'
            ]);

            Equipo::where('Serial', $validatedData['Serial'])
                ->update(['Disponibilidad' => 'En Prestamo']);

            DB::commit();

            return redirect()->route('prestamos.index')
                             ->with('success', 'Préstamo creado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear préstamo: '.$e->getMessage());
            return back()->with('error', 'Error al crear el préstamo: '.$e->getMessage());
        }
    }

    public function edit($IdPrestamo)
    {
        $prestamo = Prestamos::findOrFail($IdPrestamo);
        return view('prestamo.edit', compact('prestamo'));
    }

    public function update(Request $request, $IdPrestamo)
    {
        $validatedData = $request->validate([
            'Serial' => 'required|string|max:20|exists:Equipos,Serial',
            'ActivoFijo' => 'required|string|max:20|exists:Equipos,ActivoFijo',
            'GrupoId' => 'required|integer|exists:Grupos,IdGrupo',
            'DocumentoId' => 'required|string|max:20|exists:Usuarios,DocumentoId',
            'SalaMovil' => 'nullable|string|max:45',
            'FechaI' => 'required|date',
            'FechaF' => 'required|date|after_or_equal:FechaI',
            'HoraI' => 'required|date_format:H:i:s',
            'HoraF' => 'required|date_format:H:i:s|after:HoraI',
            'Duracion' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            $prestamo = Prestamos::findOrFail($IdPrestamo);
            
            if ($prestamo->Serial !== $validatedData['Serial']) {
                Equipo::where('Serial', $prestamo->Serial)
                    ->update(['Disponibilidad' => 'Disponible']);
                
                Equipo::where('Serial', $validatedData['Serial'])
                    ->update(['Disponibilidad' => 'En Prestamo']);
            }

            $prestamo->update($validatedData);
            
            DB::commit();

            return redirect()->route('prestamos.index')
                             ->with('success', 'Préstamo actualizado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar préstamo: '.$e->getMessage());
            return back()->with('error', 'Error al actualizar el préstamo: '.$e->getMessage());
        }
    }

    public function devolver(Request $request, $IdPrestamo)
    {
        DB::beginTransaction();
        try {
            Log::debug("Buscando préstamo con ID: $IdPrestamo");
            $prestamo = Prestamos::find($IdPrestamo);
            
            if (!$prestamo) {
                Log::error("Préstamo no encontrado - ID: $IdPrestamo");
                return back()->with('error', 'Préstamo no encontrado');
            }
            
            Log::debug("Estado actual del préstamo: ".$prestamo->Estado);
            if ($prestamo->Estado === 'Devuelto') {
                Log::warning('Intento de devolver préstamo ya devuelto', ['prestamo' => $prestamo]);
                return back()->with('warning', 'Este préstamo ya fue devuelto');
            }
    
            $now = Carbon::now('America/Bogota');
            Log::debug("Fecha y hora de devolución: ".$now);
            
            $updateData = [
                'FechaDevolucion' => $now->toDateString(),
                'HoraDevolucion' => $now->format('H:i:s'),
                'Estado' => 'Devuelto',
                'Observaciones' => $request->input('observaciones', '')
            ];
            
            Log::debug("Datos a actualizar:", $updateData);
            
            // Actualizar préstamo
            $updated = $prestamo->update($updateData);
            if (!$updated) {
                throw new \Exception("No se pudo actualizar el préstamo");
            }
            Log::info("Préstamo actualizado exitosamente");
    
            // Actualizar equipo
            $equipoUpdated = Equipo::where('Serial', $prestamo->Serial)
                ->update(['Disponibilidad' => 'Disponible']);
                
            if (!$equipoUpdated) {
                throw new \Exception("No se pudo actualizar el estado del equipo");
            }
            Log::info("Equipo actualizado a Disponible");
    
            DB::commit();
            Log::info("Devolución completada con éxito");
    
            return back()->with('success', 'Devolución registrada exitosamente');
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en devolución', [
                'IdPrestamo' => $IdPrestamo,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Error al registrar la devolución: '.$e->getMessage());
        }
    }

    public function destroy($IdPrestamo)
    {
        DB::beginTransaction();
        try {
            $prestamo = Prestamos::findOrFail($IdPrestamo);
            
            if ($prestamo->Estado === 'Activo') {
                Equipo::where('Serial', $prestamo->Serial)
                    ->update(['Disponibilidad' => 'Disponible']);
            }
            
            $prestamo->delete();
            
            DB::commit();
            
            return back()->with('success', 'Préstamo eliminado correctamente');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar préstamo ID: '.$IdPrestamo.' - Error: '.$e->getMessage());
            return back()->with('error', 'Error al eliminar el préstamo: '.$e->getMessage());
        }
    }
  /*
    public function export()
    {
        $fechaActual = Carbon::now()->format('Y-m-d_H-i-s');
        $fileName = 'prestamos_' . $fechaActual . '.xlsx'; // Puedes usar .csv si prefieres

        // Descarga el archivo usando la clase PrestamosExport
        return Excel::download(new PrestamosExport, $fileName);
    }*/
}