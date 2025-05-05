<?php

namespace App\Exports;

use App\Models\Equipo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EquiposExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Equipo::select(
            'ActivoFijo',
            'Serial',
            'Marca',
            'Modelo',
            'SalaMovil',
            'Estado'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Activo Fijo',
            'Serial',
            'Marca',
            'Modelo',
            'Sala Móvil',
            'Estado'
        ];
    }
}