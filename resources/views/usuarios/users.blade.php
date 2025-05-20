<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="https://static.vecteezy.com/system/resources/thumbnails/000/595/791/small/20012019-26.jpg">
    <link rel="stylesheet" href="{{ asset('assets/style-users.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <title>Usuarios</title>
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
                <li><a href="{{ asset('home') }}"><img src="{{ asset('Imagenes/Home 2.0.png') }}" alt="inicio"> Home</a></li>
                <li ><a href="{{ asset('usuarios') }}"><img src="{{ asset('Imagenes/Usuarios 2.0.png') }}" alt="user"> Usuarios</a></li>
                <li><a href="{{ asset('grupos') }}"><img src="{{ asset('Imagenes/Grupos 2.0.png') }}" alt="grupos"> Grupos</a></li>
                <li><a href="{{ asset('equipos') }}"><img src="{{ asset('Imagenes/Equipos 2.0.png') }}" alt="equipos"> Equipos</a></li>
                <li><a href="{{ asset('prestamos') }}"><img src="{{ asset('Imagenes/Prestamos 2.0.png') }}" alt="prestamos"> Prestamos</a></li>
                <li><a href="{{ route('reportes.index') }}"><img src="{{ asset('Imagenes/Reportes 2.0.png') }}" alt="reportes"> Reportes</a></li>
            </div>

            <div class="Prueba">
                <li>
                    <a href="{{ asset('/') }}"><img src="{{ asset('Imagenes/logout.png') }}" alt="login"> Logout</a>
                </li>
            </div>
        </ul>
    </nav>

    <div class="main-container-with-sidebar">
        <div class="Encabezado">
            <div class="Titulo">
                <h1>Administrador de Usuarios</h1>
            </div>
            <div class="userLogo">
                <img src="{{ asset('Imagenes/dos3.png') }}" alt="User logo">
            </div>
            <div class="Usuario">
                <p>{{ $usuarioAutenticado->Alias ?? 'Invitado' }}</p>
            </div>
        </div>

        <div class="page-content-original">
            <div class="Principal">
                <div class="Principal-Uno">
                    <div class="Uno-lef">
                        <img src="{{ asset('Imagenes/Usuarios 2.png') }}" alt="Admin">
                    </div>
                    <div class="Uno-right">
                        <a href="{{ asset('usuarios') }}">
                            <h2>Administradores</h2>
                        </a>
                    </div>
                </div>

                <div class="Principal-Dos">
                    <div class="Uno-lef">
                        <img src="{{ asset('Imagenes/Usuarios 4.png') }}" alt="Users">
                    </div>
                    <div class="Uno-right">
                        <a href="{{ asset('users') }}">
                            <h2>Usuarios</h2>
                        </a>
                    </div>
                </div>
            </div>

            <div class="Contenido">
                <div class="Contenido-Uno">
                    <h2>Usuarios</h2>
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

                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf
                            <label for="DocumentoId">Documento:</label>
                            <input type="text" id="DocumentoId" name="DocumentoId" value="{{ old('DocumentoId') }}" required>

                            <label for="Nombre">Nombre:</label>
                            <input type="text" id="Nombre" name="Nombre" value="{{ old('Nombre') }}" required>

                            <label for="Apellido">Apellido:</label>
                            <input type="text" id="Apellido" name="Apellido" value="{{ old('Apellido') }}">

                            <label for="Direccion">Dirección:</label>
                            <input type="text" id="Direccion" name="Direccion" value="{{ old('Direccion') }}">

                            <label for="Telefono">Teléfono:</label>
                            <input type="text" id="Telefono" name="Telefono" value="{{ old('Telefono') }}">

                            <label for="Email">Email:</label>
                            <input type="email" id="Email" name="Email" value="{{ old('Email') }}" required>

                            <label for="password">Contraseña:</label>
                            <input type="password" id="password" name="password" required>

                            <button type="submit" name="agregarUsuario">Registrar Usuario</button>
                        </form>
                    </div>
                </div>

                <div class="Contenido-Dos">
                    <div Class="Botones-Contenido">
                       
                        <div class="Boton-Uno">
                            <form id="importForm" action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="file" id="fileInput" class="d-none" accept=".xlsx,.xls,.csv" required>
                                <button type="button" id="importButton" class="btn-import">
                                    <img src="{{ asset('Imagenes/agregar.png') }}" alt="agregar">
                                    <span id="importText">Importar Usuarios</span>
                                    <div id="importSpinner" class="import-spinner d-none"></div>
                                </button>
                            </form>
                        </div>
                        
                       
                        <div class="Boton-Dos">
                            <a href="{{ route('users.export') }}" class="btn-export">
                                <img src="{{ asset('Imagenes/Exportar.png') }}" alt="exportar">
                                Exportar Usuarios
                            </a>
                        </div>
                    </div>

                    <div class="Tabla-Contenido">
                        <div class="pagination d-flex justify-content-start mt-3">
                            @if ($paginaActual > 1)
                                <a class="btn btn-sm btn-outline-primary mx-1" href="?pagina={{ $paginaActual - 1 }}&per_page={{ $elementosPorPagina }}">&laquo; Anterior</a>
                            @endif
                        
                            @for ($i = max(1, $paginaActual - 2); $i <= min($totalPaginas, $paginaActual + 2); $i++)
                                @if ($i == $paginaActual)
                                    <a class="btn btn-sm btn-primary mx-1" href="?pagina={{ $i }}&per_page={{ $elementosPorPagina }}">{{ $i }}</a>
                                @else
                                    <a class="btn btn-sm btn-outline-primary mx-1" href="?pagina={{ $i }}&per_page={{ $elementosPorPagina }}">{{ $i }}</a>
                                @endif
                            @endfor
                        
                            @if ($paginaActual < $totalPaginas)
                                <a class="btn btn-sm btn-outline-primary mx-1" href="?pagina={{ $paginaActual + 1 }}&per_page={{ $elementosPorPagina }}">Siguiente &raquo;</a>
                            @endif
                        </div>

                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Documento</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $usuario)
                                    <tr>
                                        <td>{{ $usuario->DocumentoId }}</td>
                                        <td>{{ $usuario->Nombre }}</td>
                                        <td>{{ $usuario->Apellido }}</td>
                                        <td>{{ $usuario->Email }}</td>
                                        <td>{{ $usuario->Telefono }}</td>
                                        <td>
                                            <form action="{{ route('users.destroy', $usuario->DocumentoId) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-eliminar"
                                                    onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
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

        
    </div>
    <footer>
            <p>Sistema de Préstamos de Portátiles © {{ date('Y') }}</p>
        </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/importUsers.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const mainMenu = document.getElementById('mainMenu');
            const body = document.body;
            const mainContainer = document.querySelector('.main-container-with-sidebar'); 

            if (menuToggle && mainMenu && mainContainer) { 
                menuToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    this.classList.toggle('active');
                    mainMenu.classList.toggle('active');
                    body.classList.toggle('menu-open');
                    mainContainer.classList.toggle('sidebar-active');
                });

                document.addEventListener('click', function(e) {
                    if (mainMenu.classList.contains('active') &&
                        !mainMenu.contains(e.target) &&
                        !menuToggle.contains(e.target)) {
                        menuToggle.classList.remove('active');
                        mainMenu.classList.remove('active');
                        body.classList.remove('menu-open');
                        mainContainer.classList.remove('sidebar-active');
                    }
                });
            }

            setTimeout(function() {
                document.body.classList.add('loaded');
            }, 100);
        });
    </script>
</body>
</html>