<?php

namespace App\Imports;

use App\Models\Equipo;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EquiposImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Equipo([
            'ActivoFijo' => $row['activo_fijo'],
            'Serial' => $row['serial'],
            'Marca' => $row['marca'] ?? null,
            'Modelo' => $row['modelo'] ?? null,
            'SalaMovil' => $row['sala_movil'] ?? null,
            'Estado' => $row['estado'],
            'Disponibilidad' => $row['disponibilidad'],
        ]);
    }

    public function rules(): array
    {
        return [
            'activo_fijo' => 'required|string|max:20|unique:equipos,ActivoFijo',
            'serial' => 'required|string|max:20|unique:equipos,Serial',
            'estado' => 'required|string|in:Activo,Inactivo,En reparación,Dado de baja',
            'disponibilidad' => 'required|string|in:Disponible,No Disponible,En Prestamo',
            'marca' => 'nullable|string|max:45',
            'modelo' => 'nullable|string|max:45',
            'sala_movil' => 'nullable|string|max:45',
        ];
    }
}