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
    <link rel="stylesheet" href="{{ asset('assets/style-prestamos.css') }}">
    <title>Préstamos</title>
</head>

<body>
    <!-- Botón del menú móvil -->
    <button class="menu-toggle" id="menuToggle">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <!-- Menú lateral -->
    <nav>
        <ul id="mainMenu">
            <li class="logo"><img src="{{ asset('Imagenes/Blue.png') }}" alt="Logo"></li>
            <div class="Menu">
                <li><a href="{{ asset('home') }}"><img src="{{ asset('Imagenes/Home 2.0.png') }}" alt="inicio"> Home</a></li>
                <li><a href="{{ asset('usuarios') }}"><img src="{{ asset('Imagenes/Usuarios 2.0.png') }}" alt="user"> Usuarios</a></li>
                <li><a href="{{ asset('grupos') }}"><img src="{{ asset('Imagenes/Grupos 2.0.png') }}" alt="grupos"> Grupos</a></li>
                <li><a href="{{ asset('equipos') }}"><img src="{{ asset('Imagenes/Equipos 2.0.png') }}" alt="equipos"> Equipos</a></li>
                <li><a href="{{ asset('prestamos') }}"><img src="{{ asset('Imagenes/Prestamos 2.0.png') }}" alt="prestamos"> Prestamos</a></li>
                 <li><a href="{{ route('reportes.index') }}"><img src="{{ asset('Imagenes/Reportes 2.0.png') }}" alt="prestamos"> Reportes</a></li>
            </div>

            <div class="Prueba">
                <li><a href="{{ asset('/') }}"><img src="{{ asset('Imagenes/logout.png') }}" alt="login"> Logout</a></li>
            </div>
        </ul>
    </nav>

    <div class="wrapper">
        <div class="section">
            <div class="Encabezado">
                <div class="Titulo">
                    <h1>Administrador de Préstamos</h1>
                </div>
                <div class="userLogo">
                    <img src="{{ asset('Imagenes/dos3.png') }}">
                </div>
                <div class="Usuario">
                    <p>{{ $usuarioAutenticado->Alias ?? 'Invitado' }}</p>
                </div>
            </div>
        </div>                                             

        <div class="Contenido">
            <div class="Contenido-Uno">
                

                <div class="Tabla-Contenido">
                    <div class="pagination d-flex justify-content-start mt-3">
                        @if ($paginaActual > 1)
                            <a class="btn btn-sm btn-outline-primary mx-1"
                                href="?pagina={{ $paginaActual - 1 }}&per_page={{ $elementosPorPagina }}">&laquo; Anterior</a>
                        @endif

                        @for ($i = max(1, $paginaActual - 2); $i <= min($totalPaginas, $paginaActual + 2); $i++)
                            @if ($i == $paginaActual)
                                <a class="btn btn-sm btn-primary mx-1"
                                    href="?pagina={{ $i }}&per_page={{ $elementosPorPagina }}">{{ $i }}</a>
                            @else
                                <a class="btn btn-sm btn-outline-primary mx-1"
                                    href="?pagina={{ $i }}&per_page={{ $elementosPorPagina }}">{{ $i }}</a>
                            @endif
                        @endfor

                        @if ($paginaActual < $totalPaginas)
                            <a class="btn btn-sm btn-outline-primary mx-1"
                                href="?pagina={{ $paginaActual + 1 }}&per_page={{ $elementosPorPagina }}">Siguiente &raquo;</a>
                        @endif
                    </div>

                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Serial</th>
                                <th>Activo Fijo</th>
                                <th>Grupo</th>
                                <th>Usuario</th>
                                <th>Sala Móvil</th>
                                <th>Fecha Inicio</th>
                                <th>Hora Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Hora Fin</th>
                                <th>Estado</th>
                                <th>Devolución</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prestamos as $prestamo)
                                <tr>
                                    <td>{{ $prestamo->Serial }}</td>
                                    <td>{{ $prestamo->ActivoFijo }}</td>
                                    <td>{{ $prestamo->grupo->IdGrupo ?? 'N/A' }}</td>
                                    <td>{{ $prestamo->usuario->DocumentoId ?? $prestamo->DocumentoId }}</td>
                                    <td>{{ $prestamo->SalaMovil ?? 'N/A' }}</td>
                                    <td>{{ date('d/m/Y', strtotime($prestamo->FechaI)) }}</td>
                                    <td>{{ date('H:i', strtotime($prestamo->HoraI)) }}</td>
                                    <td>{{ date('d/m/Y', strtotime($prestamo->FechaF)) }}</td>
                                    <td>{{ date('H:i', strtotime($prestamo->HoraF)) }}</td>
                                    <td>
                                        @if($prestamo->Estado === 'Devuelto')
                                            <span class="badge bg-success">Devuelto</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Activo</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($prestamo->FechaDevolucion)
                                            {{ date('d/m/Y ', strtotime($prestamo->FechaDevolucion)) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($prestamo->Estado === 'Activo')
                                        <form action="{{ route('prestamos.devolver', $prestamo->IdPrestamo) }}" 
                                            method="POST" 
                                            style="display: inline;"
                                            onsubmit="return confirm('¿Confirmas que deseas registrar la devolución?')">
                                          @csrf
                                          <input type="hidden" name="observaciones" id="observaciones" value="">
                                          <button type="submit" class="btn-devolver" title="Registrar devolución">
                                              <img src="{{ asset('Imagenes/Check.png') }}" alt="devolver">
                                          </button>
                                      </form>
                                        @endif
                                        
                                        <form action="{{ route('prestamos.destroy', $prestamo->IdPrestamo) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-eliminar"
                                                onclick="return confirm('¿Estás seguro de eliminar este préstamo?')">
                                                <img src="{{ asset('Imagenes/Drop.png') }}" alt="borrar">
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <footer>
         <p>Sistema de Préstamos de Portátiles © {{ date('Y') }}</p>
    </footer>
    
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const mainMenu = document.getElementById('mainMenu');
            const body = document.body;
            
            // Toggle del menú
            menuToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                this.classList.toggle('active');
                mainMenu.classList.toggle('active');
                body.classList.toggle('menu-open');
            });
            
            // Cerrar menú al hacer clic fuera
            document.addEventListener('click', function(e) {
                if (!mainMenu.contains(e.target) && e.target !== menuToggle) {
                    menuToggle.classList.remove('active');
                    mainMenu.classList.remove('active');
                    body.classList.remove('menu-open');
                }
            });
            
            // Prevenir que el clic en el menú se propague
            mainMenu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
            
            // Añadir clase loaded para animaciones
            setTimeout(function() {
                document.body.classList.add('loaded');
            }, 100);
        });
    </script>
</body>
</html>