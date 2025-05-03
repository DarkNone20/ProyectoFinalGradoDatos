<?php

namespace App\Imports;

use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Users([
            'DocumentoId' => $row['documento'] ?? $row['Documento'] ?? $row['documento_id'] ?? '',
            'Nombre' => $row['nombre'] ?? $row['Nombre'] ?? '',
            'Apellido' => $row['apellido'] ?? $row['Apellido'] ?? null,
            'Email' => $row['email'] ?? $row['Email'] ?? $row['correo'] ?? '',
            'Telefono' => $row['telefono'] ?? $row['Teléfono'] ?? $row['phone'] ?? null,
            'Direccion' => $row['direccion'] ?? $row['Dirección'] ?? $row['address'] ?? null,
            'password' => Hash::make($row['password'] ?? 'password123'),
        ]);
    }

    public function headingRow(): int
    {
        return 1; // La fila 1 contiene los encabezados
    }
}