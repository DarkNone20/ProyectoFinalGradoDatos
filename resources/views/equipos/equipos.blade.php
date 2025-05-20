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
    <link rel="stylesheet" href="{{ asset('assets/style-equipos.css') }}">
    <title>Equipos</title>
</head>

<body>
    <!-- Botón del menú móvil -->
    <button class="menu-toggle" id="menuToggle">
        <span></span>
        <span></span>
        <span></span>
    </button>

   
    <nav>
        <ul id="mainMenu">
            <li class="logo"><img src="{{ asset('Imagenes/Logo5.png') }}" alt="Logo"></li>
            <div class="Menu">
                <li ><a href="{{ route('home') }}"><img src="{{ asset('Imagenes/Home 2.0.png') }}" alt="inicio"> Home</a></li>
                <li ><a href="{{ route('usuarios.index') }}"><img src="{{ asset('Imagenes/Usuarios 2.0.png') }}" alt="user"> Usuarios</a></li>
                <li ><a href="{{ route('grupos.index') }}"><img src="{{ asset('Imagenes/Grupos 2.0.png') }}" alt="grupos"> Grupos</a></li>
                <li class="active"><a href="{{ route('equipos.index') }}"><img src="{{ asset('Imagenes/Equipos 2.0.png') }}" alt="equipos"> Equipos</a></li>
                <li ><a href="{{ route('prestamos.index') }}"><img src="{{ asset('Imagenes/Prestamos 2.0.png') }}" alt="prestamos"> Préstamos</a></li>
                <li ><a href="{{ route('reportes.index') }}"><img src="{{ asset('Imagenes/Reportes 2.0.png') }}" alt="reportes"> Reportes</a></li>
            </div>

            <div class="Prueba">
                 <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <img src="{{ asset('Imagenes/logout.png') }}" alt="logout"> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </div>
        </ul>
    </nav>

    <div class="wrapper">
        <div class="section">
            <div class="Encabezado">
                <div class="Titulo">
                    <h1>Administrador de Equipos</h1>
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
                <div class="Botones-Contenido">
                    <div class="Boton-Uno">
                        <button type="button" onclick="document.getElementById('file-import').click()">
                            <img src="{{ asset('Imagenes/agregar.png') }}" alt="importar">

                            Importar Equipos
                        </button>
                        <form id="import-form" action="{{ route('equipos.import') }}" method="POST"
                            enctype="multipart/form-data" style="display:none;">
                            @csrf
                            <input type="file" id="file-import" name="file" accept=".xlsx,.xls,.csv"
                                onchange="document.getElementById('import-form').submit()">
                        </form>
                    </div>
                    
                    <div class="Boton-Dos">
                        <button type="button" onclick="location.href='{{ route('equipos.export') }}'">
                            <img src="{{ asset('Imagenes/Exportar.png') }}" alt="exportar">
                            Exportar
                        </button>
                    </div>
                </div>

                <div class="pagination d-flex justify-content-start mt-3">
                    @if ($paginaActual > 1)
                        <a class="btn btn-sm btn-outline-primary mx-1"
                            href="?pagina={{ $paginaActual - 1 }}&per_page={{ $elementosPorPagina }}">&laquo;
                            Anterior</a>
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
                            href="?pagina={{ $paginaActual + 1 }}&per_page={{ $elementosPorPagina }}">Siguiente
                            &raquo;</a>
                    @endif
                </div>

                <div class="Tabla-Contenido mt-3">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Activo Fijo</th>
                                <th>Serial</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Sala/Móvil</th>
                                <th>Estado</th>
                                <th>Disponibilidad</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($equipos as $equipo)
                                <tr>
                                    <td>{{ $equipo->ActivoFijo }}</td>
                                    <td>{{ $equipo->Serial }}</td>
                                    <td>{{ $equipo->Marca }}</td>
                                    <td>{{ $equipo->Modelo }}</td>
                                    <td>{{ $equipo->SalaMovil }}</td>
                                    <td>
                                        <span
                                            class="badge 
                                            @if ($equipo->Estado === 'Activo') bg-success
                                            @elseif($equipo->Estado === 'Inactivo') bg-secondary
                                            @elseif($equipo->Estado === 'En reparación') bg-warning text-dark
                                            @elseif($equipo->Estado === 'Dado de baja') bg-danger @endif">
                                            {{ $equipo->Estado }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge 
                                            @if ($equipo->Disponibilidad === 'Disponible') bg-success
                                            @elseif($equipo->Disponibilidad === 'No Disponible') bg-danger
                                            @elseif($equipo->Disponibilidad === 'En Prestamo') bg-primary @endif">
                                            {{ $equipo->Disponibilidad }}
                                        </span>
                                    </td>
                                    <td>
                                        <form
                                            action="{{ route('equipos.destroy', ['ActivoFijo' => $equipo->ActivoFijo, 'Serial' => $equipo->Serial]) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-eliminar"
                                                onclick="return confirm('¿Estás seguro de eliminar este equipo?')">
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

            <div class="Contenido-Dos">
                <h2>Equipo</h2>
                <div class="Contenedor">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('equipos.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="ActivoFijo">Activo Fijo:</label>
                            <input type="text" id="ActivoFijo" name="ActivoFijo" value="{{ old('ActivoFijo') }}"
                                required class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="Serial">Serial:</label>
                            <input type="text" id="Serial" name="Serial" value="{{ old('Serial') }}"
                                required class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="Marca">Marca:</label>
                            <input type="text" id="Marca" name="Marca" value="{{ old('Marca') }}"
                                class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="Modelo">Modelo:</label>
                            <input type="text" id="Modelo" name="Modelo" value="{{ old('Modelo') }}"
                                class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="SalaMovil">Sala/Móvil:</label>
                            <input type="text" id="SalaMovil" name="SalaMovil" value="{{ old('SalaMovil') }}"
                                class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="Estado">Estado:</label>
                            <select id="Estado" name="Estado" required class="form-control">
                                <option value="Activo" {{ old('Estado') == 'Activo' ? 'selected' : '' }}>Activo
                                </option>
                                <option value="Inactivo" {{ old('Estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo
                                </option>
                                <option value="En reparación"
                                    {{ old('Estado') == 'En reparación' ? 'selected' : '' }}>En reparación</option>
                                <option value="Dado de baja" {{ old('Estado') == 'Dado de baja' ? 'selected' : '' }}>
                                    Dado de baja</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="Disponibilidad">Disponibilidad:</label>
                            <select id="Disponibilidad" name="Disponibilidad" required class="form-control">
                                <option value="">Seleccione</option>
                                <option value="Disponible"
                                    {{ old('Disponibilidad') == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                                <option value="No Disponible"
                                    {{ old('Disponibilidad') == 'No Disponible' ? 'selected' : '' }}>No Disponible
                                </option>
                                <option value="En Prestamo"
                                    {{ old('Disponibilidad') == 'En Prestamo' ? 'selected' : '' }}>En Préstamo</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Registrar Equipo</button>
                    </form>
                </div>
            </div>
        </div>


    </div>

    <!-- Scripts -->
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
                if (!mainMenu.contains(e.target)) {
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

        // Función para mostrar el formulario de registro
        function mostrarFormulario() {
            const formulario = document.getElementById('formularioEquipo');
            formulario.style.display = 'block';
        }
        document.getElementById('import-button').addEventListener('click', function() {
            document.getElementById('file-import').click();
        });

        document.getElementById('file-import').addEventListener('change', function() {
            if (this.files.length > 0) {
                // Muestra feedback visual (opcional)
                const btn = document.getElementById('import-button');
                btn.disabled = true;
                const originalHTML = btn.innerHTML;
                btn.innerHTML = originalHTML.replace('Importar', 'Importando...');

                document.getElementById('import-form').submit();

                // Restaura después de 5 segundos (solo como fallback)
                setTimeout(() => {
                    btn.disabled = false;
                    btn.innerHTML = originalHTML;
                }, 5000);
            }
        });
    </script>

    <footer>
        <p>Sistema de Gestión de Equipos &copy; {{ date('Y') }}</p>
    </footer>
</body>

</html>
