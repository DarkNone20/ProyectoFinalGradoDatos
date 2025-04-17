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
    <title>Usuarioss</title>

</head>

<body>
    <nav>
        <ul>
            <li class="logo"><img src="{{ asset('Imagenes/Logo5.png') }}" alt="Logo"></li>
            <div class="Menu">
                <li><a href="{{ asset('home') }}"><i class="fa fa-home"></i>&nbsp;<img simg
                            src="{{ asset('Imagenes/inicio.png') }}" alt="inicio">
                        Home</a></li>
                <li><a href="{{ asset('usuarios') }}"><i class="fa fa-users"></i>&nbsp;<img
                            src="{{ asset('Imagenes/user.png') }}" alt="user"> Usuarios</a></li>
                <li><a href="{{ asset('grupos') }}"><i class="fa fa-phone"></i>&nbsp; <img
                            src="{{ asset('Imagenes/lista.png') }}" alt="grupos"> Grupos</a></li>
                <li><a href="{{ asset('equipos') }}"><i class="fa fa-phone"></i>&nbsp;<img
                            src="{{ asset('Imagenes/inventario.png') }}" alt="equipos"> Equipos</a></li>
                <li><a href="{{ asset('prestamos') }}"><i class="fa fa-users"></i>&nbsp;<img
                            src="{{ asset('Imagenes/consecutivo.png') }}" alt="prestamos"> Prestamos</a></li>
            </div>
            <div class="Prueba">
                <li><a href="{{ asset('/') }}"><i class="fa fa-phone"></i>&nbsp; <img
                            src="{{ asset('Imagenes/logout.png') }}" alt="login">
                        Logout</a></li>
            </div>

        </ul>
    </nav>

    <div class="wrapper">
        <div class="section">
            <div class="Encabezado">
                <div class="Titulo">
                    <h1>Administrador de Usuarios</h1>
                </div>
                <div class="userLogo">
                    <img src="{{ asset('Imagenes/dos3.png') }}">
                </div>
                <div class="Usuario">
                    <p>{{ $usuarioAutenticado->Alias ?? 'Invitado' }}</p>
                </div>
                <br>
            </div>
        </div>

        <div class="Principal">
            <div class="Principal-Uno">
                <div class="Uno-lef">
                    <img src="{{ asset('Imagenes/Usuarios 2.png') }}">
                </div>
                <div class="Uno-right">
                    <a href="{{ asset('usuarios') }}">
                        <h2>Administradores</h2>
                    </a>
                </div>
            </div>

            <div class="Principal-Dos">
                <div class="Uno-lef">
                    <img src="{{ asset('Imagenes/Usuarios 4.png') }}">
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
                <div Class="Botones-Contenido">
                    <div class="Boton-Uno">
                        <button type="button-Uno"><img src="{{ asset('Imagenes/agregar.png') }}" alt="agregar">
                            Agregar Usuarios</button>
                    </div>
                    <div class="Boton-Dos" action="#" method="GET">
                        <button type="button-Dos"><img src="{{ asset('Imagenes/Exportar.png') }}" alt="exportar">
                            Exportar</button>
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
                    
                    


                    <table class="table table-striped">
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
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="Contenido-Dos">
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

    <footer></footer>
</body>

</html>
