<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Consulta para préstamos mensuales
        $prestamosPorMes = DB::table('Prestamos')
            ->select(
                DB::raw('MONTH(FechaI) as mes'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('FechaI', date('Y')) 
            ->groupBy(DB::raw('MONTH(FechaI)'))
            ->orderBy('mes')
            ->get();

        // Consulta para uso de salas móviles
        $usoSalasMoviles = DB::table('Prestamos')
            ->select(
                'SalaMovil',
                DB::raw('COUNT(*) as total')
            )
            ->whereNotNull('SalaMovil')
            ->where('SalaMovil', '<>', '')
            ->groupBy('SalaMovil')
            ->orderBy('total', 'desc')
            ->get();

        // Preparar datos para gráfico mensual
        $todosMeses = [];
        $datosGrafico = [];

        for ($i = 1; $i <= 12; $i++) {
            $todosMeses[] = $this->nombreMes($i);
            $mesData = $prestamosPorMes->firstWhere('mes', $i);
            $datosGrafico[] = $mesData ? $mesData->total : 0;
        }

        $usuarioAutenticado = auth()->user();

        return view("home/home", [
            'meses' => $todosMeses,
            'prestamosPorMes' => $datosGrafico,
            'usoSalasMoviles' => $usoSalasMoviles,
            'usuarioAutenticado' => $usuarioAutenticado
        ]);
    }

    private function nombreMes($numeroMes)
    {
        $meses = [
            1 => 'Ene',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Abr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Ago',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dic'
        ];
        return $meses[$numeroMes] ?? '';
    }
}