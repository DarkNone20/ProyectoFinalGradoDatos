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
    <link rel="stylesheet" href="{{ asset('assets/style-usuarios.css') }}">
    <title>Usuarios</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
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
                <li ><a href="{{ route('home') }}"><img src="{{ asset('Imagenes/Home 2.0.png') }}" alt="inicio"> Home</a></li>
                <li ><a href="{{ route('usuarios.index') }}"><img src="{{ asset('Imagenes/Usuarios 2.0.png') }}" alt="user"> Usuarios</a></li>
                <li ><a href="{{ route('grupos.index') }}"><img src="{{ asset('Imagenes/Grupos 2.0.png') }}" alt="grupos"> Grupos</a></li>
                <li ><a href="{{ route('equipos.index') }}"><img src="{{ asset('Imagenes/Equipos 2.0.png') }}" alt="equipos"> Equipos</a></li>
                <li ><a href="{{ route('prestamos.index') }}"><img src="{{ asset('Imagenes/Prestamos 2.0.png') }}" alt="prestamos"> Préstamos</a></li>
                <li ><a href="{{ route('reportes.index') }}"><img src="{{ asset('Imagenes/Reportes 2.0.png') }}" alt="reportes"> Reportes</a></li>
            </div>

            <div class="Prueba">
                 <li >
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

    <div class="main-container-with-sidebar">
        <div class="Encabezado"> 
            <div class="Titulo">
                <h1>Administrador de Usuarios</h1>
            </div>
            <div class="userLogo">
                <img src="{{ asset('Imagenes/dos3.png') }}" alt="User logo">
            </div>
            <div class="Usuario">
                 <p>{{ Auth::user()->Alias ?? (isset($usuarioAutenticado) && $usuarioAutenticado->Alias ? $usuarioAutenticado->Alias : 'Invitado') }}</p>
            </div>
        </div>

        <div class="page-content-original">
            <div class="Principal">
                <div class="Principal-Uno">
                    <div class="Uno-lef">
                        <img src="{{ asset('Imagenes/Usuarios 2.png') }}" alt="Admin">
                    </div>
                    <div class="Uno-right">
                        <a href="{{ route('usuarios.index') }}">
                            <h2>Administradores</h2>
                        </a>
                    </div>
                </div>

                <div class="Principal-Dos">
                    <div class="Uno-lef">
                        <img src="{{ asset('Imagenes/Usuarios 4.png') }}" alt="Users">
                    </div>
                    <div class="Uno-right">
                        <a href="{{ route('users.index') }}">
                            <h2>Usuarios</h2>
                        </a>
                    </div>
                </div>
            </div>

            <div class="Contenido">
                <div class="Contenido-Uno">
                    <div Class="Botones-Contenido">
                        <div class="Boton-Uno">
                            <button type="button" onclick="document.getElementById('Cedula').focus();"><img src="{{ asset('Imagenes/agregar.png') }}" alt="agregar">
                                Agregar Usuarios</button>
                        </div>
                        <div class="Boton-Dos">
                            <button type="button"><img src="{{ asset('Imagenes/Exportar.png') }}" alt="exportar">
                                Exportar</button>
                        </div>
                    </div>

                    <div class="Tabla-Contenido">
                        @if (isset($usuarios) && $usuarios instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $usuarios->total() > 0)
                        <div class="pagination justify-content-start mt-0 mb-3">
                            {{ $usuarios->appends(request()->except('page'))->links() }}
                        </div>
                        @endif

                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Cédula</th>
                                    <th>Alias</th>
                                    <th>Nombre</th>
                                    <th>Cargo</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($usuarios) && $usuarios->count() > 0)
                                    @foreach ($usuarios as $usuario)
                                        <tr>
                                            <td>{{ $usuario->Cedula }}</td>
                                            <td>{{ $usuario->Alias }}</td>
                                            <td>{{ $usuario->Nombre }}</td>
                                            <td>{{ $usuario->Cargo }}</td>
                                            <td>
                                                <form action="{{ route('usuarios.destroy', $usuario->Cedula) }}" method="POST"
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
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">No hay usuarios para mostrar.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="Contenido-Dos">
                    <h2>Administradores</h2>
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

                        <form action="{{ route('usuarios.store') }}" method="POST">
                            @csrf

                            <label for="Cedula">Cédula:</label>
                            <input type="text" id="Cedula" name="Cedula" value="{{ old('Cedula') }}" required>

                            <label for="Alias">Alias:</label>
                            <input type="text" id="Alias" name="Alias" value="{{ old('Alias') }}">

                            <label for="Nombre">Nombre completo:</label>
                            <input type="text" id="Nombre" name="Nombre" value="{{ old('Nombre') }}" required>

                            <label for="Password">Contraseña:</label>
                            <input type="password" id="Password" name="Password" required>

                            <label for="Cargo">Cargo:</label>
                            <input type="text" id="Cargo" name="Cargo" value="{{ old('Cargo') }}">

                            <button type="submit" name="agregarUsuario">Registrar Usuario</button>
                        </form>
                    </div>
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