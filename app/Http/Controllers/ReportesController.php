<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupos;
use App\Models\Prestamos;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PrestamosExport;
use Illuminate\Support\Facades\Auth; 

class ReportesController extends Controller
{
    public function index(Request $request)
    {
        $query = Prestamos::with(['grupo', 'usuario']);

        // Aplicar filtros
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('FechaI', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('FechaI', '<=', $request->fecha_fin);
        }

        if ($request->filled('estado')) {
            $query->where('Estado', $request->estado);
        }

      
        if ($request->filled('grupo')) {
            $query->where('GrupoId', $request->grupo);
        }

        if ($request->filled('usuario')) {
            $query->whereHas('usuario', function ($q) use ($request) {
                $q->where('DocumentoId', 'like', '%' . $request->usuario . '%')
                  ->orWhere('Nombre', 'like', '%' . $request->usuario . '%');
            });
        }

        if ($request->filled('equipo')) {
            $query->where(function ($q) use ($request) {
                $q->where('Serial', 'like', '%' . $request->equipo . '%')
                  ->orWhere('ActivoFijo', 'like', '%' . $request->equipo . '%');
            });
        }

        // Obtener estadísticas
        $totalPrestamos = Prestamos::count();
        $prestamosActivos = Prestamos::where('Estado', 'Activo')->count();
        $prestamosDevueltos = Prestamos::where('Estado', 'Devuelto')->count();

        // Obtener grupos
        // Asegúrate que 'NombreCurso' es la columna correcta para el nombre del grupo en tu modelo Grupos.
        // En tu vista usas $grupo->irupo, así que si esa es la columna, usa:
        // $grupos = Grupos::orderBy('irupo')->get();
        $grupos = Grupos::orderBy('NombreCurso')->get(); // O la columna que corresponda al nombre visible del grupo

        // Obtener préstamos por grupo
        // Usa la misma FK que en el filtro: GrupoId o IdGrupo
        $prestamosPorGrupo = Prestamos::selectRaw('GrupoId, count(*) as total')
            ->groupBy('GrupoId')
            ->pluck('total', 'GrupoId')
            ->toArray();

        // Paginar resultados
        $prestamos = $query->orderBy('FechaI', 'desc')
            ->paginate(10)
            ->appends($request->all());

        // Obtener el usuario autenticado
        $usuarioAutenticado = Auth::user();

        return view('reportes.reportes', compact(
            'prestamos',
            'totalPrestamos',
            'prestamosActivos',
            'prestamosDevueltos',
            'grupos',
            'prestamosPorGrupo',
            'usuarioAutenticado' // Pasar el usuario autenticado
            // 'meses',        // Eliminado porque no se define aquí
            // 'prestamosPorMes' // Eliminado porque no se define aquí
        ));
    }

    /**
     * Exporta los reportes en diferentes formatos
     */
    public function export(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:pdf,excel,csv',
        ]);

        $filtros = $request->except(['_token', 'tipo']);

        switch ($request->tipo) {
            case 'pdf':
                $prestamos = $this->getFilteredPrestamos($filtros);
                $pdf = Pdf::loadView('reportes.pdf', compact('prestamos', 'filtros'))
                    ->setPaper('a4', 'landscape');
                return $pdf->download('reporte_prestamos_' . date('YmdHis') . '.pdf');

            case 'excel':
                return Excel::download(
                    new PrestamosExport($filtros),
                    'reporte_prestamos_' . date('YmdHis') . '.xlsx'
                );

            case 'csv':
                return Excel::download(
                    new PrestamosExport($filtros),
                    'reporte_prestamos_' . date('YmdHis') . '.csv',
                    \Maatwebsite\Excel\Excel::CSV
                );
        }
    }

    /**
     * Obtiene estadísticas para gráficos via AJAX
     */
    public function estadisticas(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:grupos,estados,meses',
        ]);

        $data = []; // Inicializar data

        switch ($request->tipo) {
            case 'grupos':
                // Si en tu vista usas $grupo->irupo, usa esa columna para el nombre.
                // $gruposModel = Grupos::orderBy('irupo')->get();
                $gruposModel = Grupos::orderBy('NombreCurso')->get(); // O la columna correcta
                $data = [
                    'labels' => $gruposModel->pluck('irupo'), // Asumiendo que 'irupo' es el nombre del grupo
                    'data' => $gruposModel->map(function ($grupo) {
                        // Usa la misma FK que en el filtro: GrupoId o IdGrupo
                        return Prestamos::where('GrupoId', $grupo->IdGrupo)->count();
                    })
                ];
                break;

            case 'estados':
                $data = [
                    'labels' => ['Activos', 'Devueltos'],
                    'data' => [
                        Prestamos::where('Estado', 'Activo')->count(),
                        Prestamos::where('Estado', 'Devuelto')->count()
                    ]
                ];
                break;

            case 'meses':
                $mesesLabels = collect(); // Renombrado para claridad
                $prestamosData = collect(); // Renombrado para claridad

                for ($i = 5; $i >= 0; $i--) {
                    $fecha = now()->subMonths($i);
                    // $mesesLabels->push($fecha->format('M Y')); // Para formato 'Jan 2023'
                    $mesesLabels->push($fecha->translatedFormat('M Y')); // Para formato traducido 'Ene 2023', necesita locale configurado

                    $prestamosData->push(Prestamos::whereYear('FechaI', $fecha->year)
                        ->whereMonth('FechaI', $fecha->month)
                        ->count());
                }

                $data = [
                    'labels' => $mesesLabels,
                    'data' => $prestamosData
                ];
                break;
        }

        return response()->json($data);
    }

    /**
     * Filtra los préstamos según parámetros
     */
    private function getFilteredPrestamos(array $filtros)
    {
        $query = Prestamos::with(['grupo', 'usuario']);

        if (!empty($filtros['fecha_inicio'])) {
            $query->whereDate('FechaI', '>=', $filtros['fecha_inicio']);
        }

        if (!empty($filtros['fecha_fin'])) {
            $query->whereDate('FechaI', '<=', $filtros['fecha_fin']);
        }

        if (!empty($filtros['estado'])) {
            $query->where('Estado', $filtros['estado']);
        }

        if (!empty($filtros['grupo'])) {
            // Usa la misma FK que en el filtro: GrupoId o IdGrupo
            $query->where('GrupoId', $filtros['grupo']);
        }

        if (!empty($filtros['usuario'])) {
            $query->whereHas('usuario', function ($q) use ($filtros) {
                $q->where('DocumentoId', 'like', '%' . $filtros['usuario'] . '%')
                  ->orWhere('Nombre', 'like', '%' . $filtros['usuario'] . '%');
            });
        }

        if (!empty($filtros['equipo'])) {
            $query->where(function ($q) use ($filtros) {
                $q->where('Serial', 'like', '%' . $filtros['equipo'] . '%')
                  ->orWhere('ActivoFijo', 'like', '%' . $filtros['equipo'] . '%');
            });
        }

        return $query->orderBy('FechaI', 'desc')->get();
    }
}