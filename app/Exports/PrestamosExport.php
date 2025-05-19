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
    
    public function __construct($filtros)
    {
        $this->filtros = $filtros;
    }
    
    public function collection()
    {
        $query = Prestamos::with(['grupo', 'usuario']);
        
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
            $query->where('IdGrupo', $this->filtros['grupo']);
        }
        
        if (!empty($this->filtros['usuario'])) {
            $query->whereHas('usuario', function($q) {
                $q->where('DocumentoId', 'like', '%'.$this->filtros['usuario'].'%')
                  ->orWhere('Nombre', 'like', '%'.$this->filtros['usuario'].'%');
            });
        }
        
        if (!empty($this->filtros['equipo'])) {
            $query->where(function($q) {
                $q->where('Serial', 'like', '%'.$this->filtros['equipo'].'%')
                  ->orWhere('ActivoFijo', 'like', '%'.$this->filtros['equipo'].'%');
            });
        }
        
        return $query->orderBy('FechaI', 'desc')->get();
    }
    
    public function headings(): array
    {
        return [
            'ID',
            'Serial',
            'Activo Fijo',
            'Grupo',
            'Usuario',
            'Documento Usuario',
            'Fecha Inicio',
            'Hora Inicio',
            'Fecha Fin',
            'Hora Fin',
            'Estado',
            'Fecha Devolución',
            'Sala Móvil'
        ];
    }
    
    public function map($prestamo): array
    {
        return [
            $prestamo->IdPrestamo,
            $prestamo->Serial,
            $prestamo->ActivoFijo,
            $prestamo->grupo->irupo ?? 'N/A',
            $prestamo->usuario->Nombre ?? 'N/A',
            $prestamo->usuario->DocumentoId ?? $prestamo->DocumentoId,
            $prestamo->FechaI,
            $prestamo->HoraI,
            $prestamo->FechaF,
            $prestamo->HoraF,
            $prestamo->Estado,
            $prestamo->FechaDevolucion ?? 'N/A',
            $prestamo->SalaMovil ?? 'N/A'
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            // Estilo para la primera fila (encabezados)
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFD9D9D9']
                ]
            ],
            
            // Estilo para las filas alternas
            'A2:Z'.$sheet->getHighestRow() => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFFFFFFF']
                ]
            ]
        ];
    }
}