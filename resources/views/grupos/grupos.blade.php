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
    <link rel="stylesheet" href="{{ asset('assets/style-grupos.css') }}">
    <title>Grupos</title>
</head>

<body>
    <nav>
        <ul>
            <li class="logo"><img src="{{ asset('Imagenes/Logo5.png') }}" alt="Logo"></li>
            <div class="Menu">
                <li><a href="{{ asset('home') }}"><img src="{{ asset('Imagenes/inicio.png') }}" alt="inicio"> Home</a>
                </li>
                <li><a href="{{ asset('usuarios') }}"><img src="{{ asset('Imagenes/user.png') }}" alt="user">
                        Usuarios</a></li>
                <li><a href="{{ asset('grupos') }}"><img src="{{ asset('Imagenes/lista.png') }}" alt="grupos">
                        Grupos</a></li>
                <li><a href="{{ asset('equipos') }}"><img src="{{ asset('Imagenes/inventario.png') }}" alt="equipos">
                        Equipos</a></li>
                <li><a href="{{ asset('prestamos') }}"><img src="{{ asset('Imagenes/consecutivo.png') }}"
                            alt="prestamos"> Prestamos</a></li>
            </div>
            <div class="Prueba">
                <li><a href="{{ asset('/') }}"><img src="{{ asset('Imagenes/logout.png') }}" alt="login">
                        Logout</a></li>
            </div>
        </ul>
    </nav>

    <div class="wrapper">
        <div class="section">
            <div class="Encabezado">
                <div class="Titulo">
                    <h1>Administrador de Grupos</h1>
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


        <div class="Contenido">
            <div class="Contenido-Uno">
                <h2> Grupos</h2>
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

                    <form action="{{ route('grupos.store') }}" method="POST">
                        @csrf

                        <label for="IdGrupo">ID Grupo:</label>
                        <input type="text" id="IdGrupo" name="IdGrupo" value="{{ old('IdGrupo') }}" required>

                        <label for="NombreProfesor">Nombre Profesor:</label>
                        <input type="text" id="NombreProfesor" name="NombreProfesor"
                            value="{{ old('NombreProfesor') }}" required>

                        <label for="NombreCurso">Nombre del Curso:</label>
                        <input type="text" id="NombreCurso" name="NombreCurso" value="{{ old('NombreCurso') }}">

                        <label for="FechaInicial">Fecha Inicial:</label>
                        <input type="date" id="FechaInicial" name="FechaInicial" value="{{ old('FechaInicial') }}">

                        <label for="FechaFinal">Fecha Final:</label>
                        <input type="date" id="FechaFinal" name="FechaFinal" value="{{ old('FechaFinal') }}">

                        <label for="HoraInicial">Hora Inicial:</label>
                        <input type="time" id="HoraInicial" name="HoraInicial" value="{{ old('HoraInicial') }}">

                        <label for="HoraFinal">Hora Final:</label>
                        <input type="time" id="HoraFinal" name="HoraFinal" value="{{ old('HoraFinal') }}">

                        <button type="submit" name="agregarGrupo">Registrar Grupo</button>
                    </form>
                </div>
            </div>

            <div class="Contenido-Dos">
                <div class="Botones-Contenido">
                    <div class="Boton-Uno">
                        <button type="button-Uno"><img src="{{ asset('Imagenes/agregar.png') }}" alt="agregar">
                            Agregar Grupo</button>
                    </div>
                    <div class="Boton-Dos">
                        <button type="button-Dos"><img src="{{ asset('Imagenes/Exportar.png') }}" alt="exportar">
                            Exportar</button>
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

                <div class="Tabla-Contenido mt-4">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>ID Grupo</th>
                                <th>Nombre Profesor</th>
                                <th>Nombre Curso</th>
                                <th>Fecha Inicial</th>
                                <th>Fecha Final</th>
                                <th>Hora Inicial</th>
                                <th>Hora Final</th>
                                <th>Miembros</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grupos as $grupo)
                                <tr>
                                    <td>{{ $grupo->IdGrupo }}</td>
                                    <td>{{ $grupo->NombreProfesor }}</td>
                                    <td>{{ $grupo->NombreCurso }}</td>
                                    <td>{{ $grupo->FechaInicial }}</td>
                                    <td>{{ $grupo->FechaFinal }}</td>
                                    <td>{{ $grupo->HoraInicial }}</td>
                                    <td>{{ $grupo->HoraFinal }}</td>
                                    <td>{{ $grupo->usuarios_count }}</td>
                                    <td>
                                        <a href="{{ route('grupos.miembros', $grupo->IdGrupo) }}" class="btn btn-sm btn-info" title="Ver miembros">
                                            <img src="{{ asset('Imagenes/users.png') }}" alt="miembros">
                                        </a>
                                        <form action="{{ route('grupos.destroy', $grupo->IdGrupo) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-eliminar"
                                                onclick="return confirm('¿Estás seguro de eliminar este grupo?')">
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

    <footer></footer>
</body>
</html>