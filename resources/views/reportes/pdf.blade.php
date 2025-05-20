<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Préstamos</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { color: #1538ac; font-size: 24px; font-weight: bold; }
        .filters { margin-bottom: 20px; font-size: 12px; }
        .filters span { font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #1538ac; color: white; text-align: left; padding: 8px; }
        td { padding: 8px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .footer { text-align: center; font-size: 10px; margin-top: 30px; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Reporte de Préstamos</div>
        <div>Generado el: {{ date('d/m/Y H:i') }}</div>
    </div>

    @if(count($filtros) > 0)
    <div class="filters">
        <h4>Filtros aplicados:</h4>
        <ul>
            @if(!empty($filtros['fecha_inicio']))
                <li><span>Fecha inicio:</span> {{ $filtros['fecha_inicio'] }}</li>
            @endif
            @if(!empty($filtros['fecha_fin']))
                <li><span>Fecha fin:</span> {{ $filtros['fecha_fin'] }}</li>
            @endif
            @if(!empty($filtros['estado']))
                <li><span>Estado:</span> {{ $filtros['estado'] }}</li>
            @endif
            @if(!empty($filtros['grupo']))
                <li><span>Grupo:</span> {{ $grupos->firstWhere('IdGrupo', $filtros['grupo'])->irupo ?? $filtros['grupo'] }}</li>
            @endif
            @if(!empty($filtros['usuario']))
                <li><span>Usuario:</span> {{ $filtros['usuario'] }}</li>
            @endif
            @if(!empty($filtros['equipo']))
                <li><span>Equipo:</span> {{ $filtros['equipo'] }}</li>
            @endif
        </ul>
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Serial</th>
                <th>Activo Fijo</th>
                <th>Grupo</th>
                <th>Usuario</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Estado</th>
                <th>Fecha Devolución</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prestamos as $prestamo)
                <tr>
                    <td>{{ $prestamo->IdPrestamo }}</td>
                    <td>{{ $prestamo->Serial ?? 'N/A' }}</td>
                    <td>{{ $prestamo->ActivoFijo ?? 'N/A' }}</td>
                    <td>{{ $prestamo->grupo->irupo ?? ($prestamo->grupo->NombreCurso ?? 'N/A') }}</td>
                    <td>{{ $prestamo->usuario->Nombre ?? ($prestamo->DocumentoId ?? 'N/A') }}</td>
                    <td>{{ $prestamo->FechaI ? date('d/m/Y H:i', strtotime($prestamo->FechaI . ' ' . $prestamo->HoraI)) : 'N/A' }}</td>
                    <td>{{ $prestamo->FechaF ? date('d/m/Y H:i', strtotime($prestamo->FechaF . ' ' . $prestamo->HoraF)) : 'N/A' }}</td>
                    <td>{{ $prestamo->Estado }}</td>
                    <td>
                        @if($prestamo->FechaDevolucion)
                            {{ date('d/m/Y H:i', strtotime($prestamo->FechaDevolucion)) }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Página {{ $page }} de {{ $pageCount }} | Sistema de Préstamos © {{ date('Y') }}
    </div>
</body>
</html>