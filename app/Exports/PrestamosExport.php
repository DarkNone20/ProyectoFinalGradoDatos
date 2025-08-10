<?php

namespace App\Exports;

use App\Models\Prestamos;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PrestamosExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $filtros;

    public function __construct(array $filtros = [])
    {
        $this->filtros = $filtros;
    }

    public function collection()
    {
        $query = Prestamos::with(['grupo', 'usuario', 'equipo']);

        if (!empty($this->filtros['fecha_inicio'])) {
            $query->whereDate('FechaI', '>=', $this->filtros['fecha_inicio']);
        }

        if (!empty($this->filtros['fecha_fin'])) {
            $query->whereDate('FechaI', '<=', $this->filtros['fecha_fin']);
        }

        if (!empty($this->filtros['estado'])) {
            $query->where('Estado', $this->filtros['estado']);
        }

        if (!empty($this->filtros['grupo'])) {
            $query->where('GrupoId', $this->filtros['grupo']);
        }

        if (!empty($this->filtros['usuario'])) {
            $query->whereHas('usuario', function ($q) {
                $q->where('DocumentoId', 'like', '%' . $this->filtros['usuario'] . '%')
                  ->orWhere('Nombre', 'like', '%' . $this->filtros['usuario'] . '%');
            });
        }

        if (!empty($this->filtros['equipo'])) {
            $query->where(function ($q) {
                $q->where('Serial', 'like', '%' . $this->filtros['equipo'] . '%')
                  ->orWhere('ActivoFijo', 'like', '%' . $this->filtros['equipo'] . '%');
            });
        }

        return $query->orderBy('FechaI', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID Préstamo',
            'Serial Equipo',
            'Activo Fijo',
            'Grupo',
            'Usuario',
            'Documento Usuario',
            'Fecha Inicio',
            'Hora Inicio',
            'Fecha Fin',
            'Hora Fin',
            'Estado',
            'Fecha Devolución'
        ];
    }

    public function map($prestamo): array
    {
        return [
            $prestamo->IdPrestamo,
            $prestamo->Serial ?? 'N/A',
            $prestamo->ActivoFijo ?? 'N/A',
            $prestamo->grupo->irupo ?? ($prestamo->grupo->NombreCurso ?? 'N/A'),
            $prestamo->usuario->Nombre ?? 'N/A',
            $prestamo->usuario->DocumentoId ?? 'N/A',
            $prestamo->FechaI ? date('d/m/Y', strtotime($prestamo->FechaI)) : 'N/A',
            $prestamo->HoraI ?? 'N/A',
            $prestamo->FechaF ? date('d/m/Y', strtotime($prestamo->FechaF)) : 'N/A',
            $prestamo->HoraF ?? 'N/A',
            $prestamo->Estado,
            $prestamo->FechaDevolucion ? date('d/m/Y H:i', strtotime($prestamo->FechaDevolucion)) : '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Estilo para la fila de encabezados
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '1538AC']]
            ],
            
            // Estilo para las filas alternas
            'A2:Z' . ($sheet->getHighestRow()) => [
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => 'F8F9FA']
                ]
            ],
            
            // Ajustar ancho de columnas
            'A' => ['width' => 10],
            'B' => ['width' => 15],
            'C' => ['width' => 15],
            'D' => ['width' => 25],
            'E' => ['width' => 25],
            'F' => ['width' => 20],
            'G' => ['width' => 15],
            'H' => ['width' => 15],
            'I' => ['width' => 15],
            'J' => ['width' => 15],
            'K' => ['width' => 15],
            'L' => ['width' => 20]
        ];
    }
    

    
}