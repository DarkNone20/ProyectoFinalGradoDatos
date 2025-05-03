<?php

namespace App\Exports;

use App\Models\Users;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Users::select('DocumentoId', 'Nombre', 'Apellido', 'Email', 'Telefono', 'Direccion')->get();
    }

    public function headings(): array
    {
        return [
            'Documento',
            'Nombre',
            'Apellido',
            'Email',
            'Teléfono',
            'Dirección'
        ];
    }
}