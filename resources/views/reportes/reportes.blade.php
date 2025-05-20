<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="shortcut icon"
        href="https://static.vecteezy.com/system/resources/thumbnails/000/595/791/small/20012019-26.jpg">
    
    <link rel="stylesheet" href="{{ asset('assets/style-reportes.css') }}">
    <title>Reportes de Préstamos</title>
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
   
    <button class="menu-toggle" id="menuToggle">
        <span></span>
        <span></span>
        <span></span>
    </button>

   
    <nav>
        <ul id="mainMenu">
            <li class="logo"><img src="{{ asset('Imagenes/Logo5.png') }}" alt="Logo"></li>
            <div class="Menu">
                <li><a href="{{ route('home') }}"><img src="{{ asset('Imagenes/Home 2.0.png') }}" alt="inicio">
                        Home</a></li>
                <li><a href="{{ route('usuarios.index') }}"><img src="{{ asset('Imagenes/Usuarios 2.0.png') }}"
                            alt="user"> Usuarios</a></li>
                <li><a href="{{ route('grupos.index') }}"><img src="{{ asset('Imagenes/Grupos 2.0.png') }}"
                            alt="grupos"> Grupos</a></li>
                <li><a href="{{ route('equipos.index') }}"><img src="{{ asset('Imagenes/Equipos 2.0.png') }}"
                            alt="equipos"> Equipos</a></li>
                <li><a href="{{ route('prestamos.index') }}"><img src="{{ asset('Imagenes/Prestamos 2.0.png') }}"
                            alt="prestamos"> Préstamos</a></li>
                <li><a href="{{ route('reportes.index') }}"><img src="{{ asset('Imagenes/Reportes 2.0.png') }}"
                            alt="prestamos"> Reportes</a></li>
            </div>

            <div class="Prueba">
                <li><a href="{{ route('login') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><img
                            src="{{ asset('Imagenes/logout.png') }}" alt="login"> Logout</a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </ul>
    </nav>

    <div class="wrapper">
        <div class="section">
            <div class="Encabezado">
                <div class="Titulo">
                    <h1>Reportes de Préstamos</h1>
                </div>
                <div class="userLogo">
                    <img src="{{ asset('Imagenes/dos3.png') }}">
                </div>
                <div class="Usuario">

                    <p>{{ $usuarioAutenticado->Alias ?? (Auth::user()->Alias ?? 'Invitado') }}</p>
                </div>
            </div>
        </div>

        <div class="Contenido">
            <div class="Contenido-Uno">
                <!-- Formulario de filtros -->
                <div class="Filtros-Reporte">
                    <form id="filtrosForm" method="GET" action="{{ route('reportes.index') }}">
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio"
                                    value="{{ request('fecha_inicio') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="fecha_fin" class="form-label">Fecha Fin</label>
                                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin"
                                    value="{{ request('fecha_fin') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" id="estado" name="estado">
                                    <option value="">Todos</option>
                                    <option value="Activo" {{ request('estado') == 'Activo' ? 'selected' : '' }}>Activo
                                    </option>
                                    <option value="Devuelto" {{ request('estado') == 'Devuelto' ? 'selected' : '' }}>
                                        Devuelto</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="grupo" class="form-label">Grupo</label>
                                <select class="form-select" id="grupo" name="grupo">
                                    <option value="">Todos</option>
                                    @foreach($grupos as $grupo)
                                      
                                        <option value="{{ $grupo->IdGrupo }}" {{ request('grupo') == $grupo->IdGrupo ? 'selected' : '' }}>
                                            {{ $grupo->irupo ?? $grupo->NombreCurso }} 
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="usuario" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="usuario" name="usuario"
                                    placeholder="Documento o nombre" value="{{ request('usuario') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="equipo" class="form-label">Equipo</label>
                                <input type="text" class="form-control" id="equipo" name="equipo"
                                    placeholder="Serial o activo fijo" value="{{ request('equipo') }}">
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-filter"></i> Filtrar
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="resetForm()">
                                    <i class="fas fa-undo"></i> Limpiar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

             
                <div class="Estadisticas mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total Préstamos</h5>
                                    <p class="card-text display-4">{{ $totalPrestamos }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Préstamos Activos</h5>
                                    <p class="card-text display-4">{{ $prestamosActivos }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Préstamos Devueltos</h5>
                                    <p class="card-text display-4">{{ $prestamosDevueltos }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

              
                <div class="Botones-Exportacion mb-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="button" class="btn btn-success me-2" onclick="exportarReporte('pdf')">
                                <img src="{{ asset('Imagenes/PDF.png') }}" alt="PDF" width="20"> Exportar
                                PDF
                            </button>
                            <button type="button" class="btn btn-warning me-2" onclick="exportarReporte('excel')">
                                <img src="{{ asset('Imagenes/Excel.png') }}" alt="Excel" width="20"> Exportar
                                Excel
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="exportarReporte('csv')">
                                <img src="{{ asset('Imagenes/CSV.png') }}" alt="CSV" width="20"> Exportar
                                CSV
                            </button>
                        </div>
                        <div>
                            <button type="button" class="btn btn-dark" data-bs-toggle="modal"
                                data-bs-target="#graficosModal">
                                <img src="{{ asset('Imagenes/Grafic.png') }}" alt="Gráficos" width="20"> Ver
                                Gráficos
                            </button>
                        </div>
                    </div>
                </div>

                <div class="Tabla-Contenido">
                    <table class="table table-striped table-hover"> 
                        <thead class="table-dark">
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
                            @forelse ($prestamos as $prestamo)
                                <tr>
                                    <td>{{ $prestamo->IdPrestamo }}</td>
                                    <td>{{ $prestamo->Serial ?? 'N/A' }}</td>
                                    <td>{{ $prestamo->ActivoFijo ?? 'N/A' }}</td>
                                    <td>{{ $prestamo->grupo->irupo ?? ($prestamo->grupo->NombreCurso ?? 'N/A') }}</td>
                                    <td>{{ $prestamo->usuario->Nombre ?? ($prestamo->DocumentoId ?? 'N/A') }}</td>
                                    <td>{{ $prestamo->FechaI ? date('d/m/Y H:i', strtotime($prestamo->FechaI . ' ' . $prestamo->HoraI)) : 'N/A' }}
                                    </td>
                                    <td>{{ $prestamo->FechaF ? date('d/m/Y H:i', strtotime($prestamo->FechaF . ' ' . $prestamo->HoraF)) : 'N/A' }}
                                    </td>
                                    <td>
                                        @if ($prestamo->Estado === 'Devuelto')
                                            <span class="badge bg-success">Devuelto</span>
                                        @elseif($prestamo->Estado === 'Activo')
                                            <span class="badge bg-warning text-dark">Activo</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $prestamo->Estado ?? 'N/A' }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($prestamo->FechaDevolucion)
                                            {{ date('d/m/Y H:i', strtotime($prestamo->FechaDevolucion)) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No se encontraron préstamos con los filtros
                                        aplicados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                   
                    <div class="d-flex justify-content-center mt-3">
                        {{ $prestamos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para gráficos -->
    <div class="modal fade" id="graficosModal" tabindex="-1" aria-labelledby="graficosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl"> <!-- Cambiado a modal-xl para más espacio -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="graficosModalLabel">Estadísticas de Préstamos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
               <div class="modal-body">
    <div class="row mb-3">
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="chart-card">
                <h6 class="text-center">Distribución por Estado</h6>
                <div class="chart-container">
                    <canvas id="estadosChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="chart-card">
                <h6 class="text-center">Préstamos por Grupo</h6>
                <div class="chart-container">
                    <canvas id="gruposChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <div class="chart-card">
                <h6 class="text-center">Tendencia Mensual de Préstamos (Últimos 6 meses)</h6>
                <div class="chart-container">
                    <canvas id="mensualChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p>Sistema de Préstamos de Portátiles © {{ date('Y') }}</p>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const mainMenu = document.getElementById('mainMenu');
            const body = document.body;

            menuToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                this.classList.toggle('active');
                mainMenu.classList.toggle('active');
                body.classList.toggle('menu-open');
            });

            document.addEventListener('click', function(e) {
                if (mainMenu.classList.contains('active') && !mainMenu.contains(e.target) && !menuToggle
                    .contains(e.target)) {
                    menuToggle.classList.remove('active');
                    mainMenu.classList.remove('active');
                    body.classList.remove('menu-open');
                }
            });

            mainMenu.addEventListener('click', function(e) {
                // e.stopPropagation(); // Descomentar si es necesario para evitar que se cierre el menú al hacer clic dentro
            });

            setTimeout(function() {
                document.body.classList.add('loaded');
            }, 100);

            const graficosModal = document.getElementById('graficosModal');
            if (graficosModal) {
                graficosModal.addEventListener('shown.bs.modal', function() {
                    // Solo inicializa los gráficos si no han sido inicializados antes en esta sesión del modal
                    if (!this.dataset.chartsInitialized) {
                        initCharts();
                        this.dataset.chartsInitialized = true;
                    }
                });
                // Opcional: resetear el flag si quieres que los gráficos se recarguen cada vez que se abre el modalac
                graficosModal.addEventListener('hidden.bs.modal', function() {
                    // this.dataset.chartsInitialized = false; // Descomentar para recargar gráficos siempre
                });
            }
        });

        function resetForm() {
            const form = document.getElementById('filtrosForm');
            // Limpiar campos manualmente porque form.reset() no siempre limpia los select con valor ""
            form.querySelectorAll('input[type="date"], input[type="text"]').forEach(input => input.value = '');
            form.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
            form.submit();
        }

        function exportarReporte(tipo) {
            // Mostrar loader
            const loader = document.createElement('div');
            loader.style.position = 'fixed';
            loader.style.top = '0';
            loader.style.left = '0';
            loader.style.width = '100%';
            loader.style.height = '100%';
            loader.style.backgroundColor = 'rgba(0,0,0,0.5)';
            loader.style.display = 'flex';
            loader.style.justifyContent = 'center';
            loader.style.alignItems = 'center';
            loader.style.zIndex = '9999';
            loader.innerHTML = '<div style="color:white;font-size:24px;">Generando reporte, por favor espere...</div>';
            document.body.appendChild(loader);

            // Obtener datos del formulario
            const formData = new FormData(document.getElementById('filtrosForm'));
            formData.append('tipo', tipo);
            formData.append('_token', '{{ csrf_token() }}');

            // Configurar fetch
            fetch('{{ route('reportes.export') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.blob();
                })
                .then(blob => {
                    // Crear enlace de descarga
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `reporte_prestamos_${new Date().toISOString().slice(0,10)}.${tipo}`;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(url);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al exportar: ' + error.message);
                })
                .finally(() => {
                    // Ocultar loader
                    document.body.removeChild(loader);
                });
        }
        // Variables para almacenar las instancias de los gráficos para poder destruirlas
        let estadosChartInstance = null;
        let gruposChartInstance = null;
        let mensualChartInstance = null;

        function destroyChart(chartInstance) {
            if (chartInstance) {
                chartInstance.destroy();
            }
        }

        function initCharts() {
            // Destruir gráficos anteriores si existen
            destroyChart(estadosChartInstance);
            destroyChart(gruposChartInstance);
            destroyChart(mensualChartInstance);

            // Gráfico de estados
            const estadosCtx = document.getElementById('estadosChart').getContext('2d');
            estadosChartInstance = new Chart(estadosCtx, {
                type: 'pie',
                data: {
                    labels: ['Activos', 'Devueltos'],
                    datasets: [{
                        label: 'Estado de Préstamos',
                        data: [{{ $prestamosActivos }}, {{ $prestamosDevueltos }}],
                        backgroundColor: [
                            'rgba(255, 193, 7, 0.7)', // Amarillo para Activos
                            'rgba(40, 167, 69, 0.7)' // Verde para Devueltos
                        ],
                        borderColor: [
                            'rgba(255, 193, 7, 1)',
                            'rgba(40, 167, 69, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: false, // Ya tenemos un h6
                            // text: 'Distribución por Estado'
                        }
                    }
                }
            });

            // Gráfico de grupos
            const gruposCtx = document.getElementById('gruposChart').getContext('2d');
            gruposChartInstance = new Chart(gruposCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($grupos->pluck('irupo')) !!}, // Asegúrate que 'irupo' es la columna correcta
                    datasets: [{
                        label: 'Préstamos por Grupo',
                        data: {!! json_encode(
                            $grupos->map(function ($g) use ($prestamosPorGrupo) {
                                return $prestamosPorGrupo[$g->IdGrupo] ?? 0;
                            }),
                        ) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                        },
                        title: {
                            display: false, // Ya tenemos un h6
                            // text: 'Préstamos por Grupo'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1 // Para que no muestre decimales si todos son enteros bajos
                            }
                        }
                    }
                }
            });

            // Gráfico mensual (con datos de ejemplo como antes, o puedes usar AJAX)
            // Para usar AJAX, tendrías que hacer una petición fetch aquí
            // fetch("{{ route('reportes.estadisticas') }}?tipo=meses")
            //   .then(response => response.json())
            //   .then(data => { /* ... actualizar gráfico con data.labels y data.data ... */ });

            const mensualCtx = document.getElementById('mensualChart').getContext('2d');
            mensualChartInstance = new Chart(mensualCtx, {
                type: 'line',
                data: {
                    // Estos son datos de ejemplo, deberías reemplazarlos con datos dinámicos
                    // pasados desde el controlador o cargados vía AJAX como se comenta arriba.
                    labels: ['Mes 1', 'Mes 2', 'Mes 3', 'Mes 4', 'Mes 5', 'Mes 6'], // Ejemplo
                    datasets: [{
                        label: 'Préstamos por Mes',
                        data: [10, 15, 8, 12, 18, 14], // Ejemplo
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 2,
                        tension: 0.1,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                        },
                        title: {
                            display: false, // Ya tenemos un h6
                            // text: 'Tendencia Mensual de Préstamos'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }
    </script>
</body>

</html>
