<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){
        // Obtener datos de préstamos por mes del año actual
        $prestamosPorMes = DB::table('Prestamos')
            ->select(
                DB::raw('MONTH(FechaI) as mes'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('FechaI', date('Y')) // Solo del año actual
            ->groupBy(DB::raw('MONTH(FechaI)'))
            ->orderBy('mes')
            ->get();
        
        // Preparar datos para todos los meses (incluso los sin préstamos)
        $todosMeses = [];
        $datosGrafico = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $todosMeses[] = $this->nombreMes($i);
            $mesData = $prestamosPorMes->firstWhere('mes', $i);
            $datosGrafico[] = $mesData ? $mesData->total : 0;
        }
        
        return view("home/home", [
            'meses' => $todosMeses,
            'prestamosPorMes' => $datosGrafico
        ]);
    }
    
    private function nombreMes($numeroMes) {
        $meses = [
            1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr',
            5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago',
            9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'
        ];
        return $meses[$numeroMes] ?? '';
    }
}