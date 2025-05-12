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
    <style>

    </style>
</head>

<body>
    <nav>
        <ul>
            <li class="logo"><img src="{{ asset('Imagenes/Logo5.png') }}" alt="Logo"></li>
            <div class="Menu">
                <li><a href="{{ asset('home') }}"><i class="fa fa-home"></i>&nbsp;<img
                            src="{{ asset('Imagenes/Home 2.0.png') }}" alt="inicio"> Home</a></li>
                <li><a href="{{ asset('usuarios') }}"><i class="fa fa-users"></i>&nbsp;<img
                            src="{{ asset('Imagenes/Usuarios 2.0.png') }}" alt="user"> Usuarios</a></li>
                <li><a href="{{ asset('grupos') }}"><i class="fa fa-phone"></i>&nbsp; <img
                            src="{{ asset('Imagenes/Grupos 2.0.png') }}" alt="grupos"> Grupos</a></li>
                <li><a href="{{ asset('equipos') }}"><i class="fa fa-phone"></i>&nbsp;<img
                            src="{{ asset('Imagenes/Equipos 2.0.png') }}" alt="equipos"> Equipos</a></li>
                <li><a href="{{ asset('prestamos') }}"><i class="fa fa-users"></i>&nbsp;<img
                            src="{{ asset('Imagenes/Prestamos 2.0.png') }}" alt="prestamos"> Prestamos</a></li>
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

                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
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

                        <div class="form-columns">
                            <!-- Primera columna -->
                            <div class="form-section">
                                <h3>Información Básica</h3>
                                <label for="IdGrupo">ID Grupo:</label>
                                <input type="text" id="IdGrupo" name="IdGrupo" value="{{ old('IdGrupo') }}" required>

                                <label for="NombreProfesor">Nombre Profesor:</label>
                                <input type="text" id="NombreProfesor" name="NombreProfesor"
                                    value="{{ old('NombreProfesor') }}" required>

                                <label for="NombreCurso">Nombre del Curso:</label>
                                <input type="text" id="NombreCurso" name="NombreCurso" value="{{ old('NombreCurso') }}" required>
                            </div>

                            <!-- Segunda columna -->
                            <div class="form-section">
                                <h3>Horario</h3>
                                <label for="FechaInicial">Fecha Inicial:</label>
                                <input type="date" id="FechaInicial" name="FechaInicial" value="{{ old('FechaInicial') }}" required>

                                <label for="FechaFinal">Fecha Final:</label>
                                <input type="date" id="FechaFinal" name="FechaFinal" value="{{ old('FechaFinal') }}" required>

                                <label for="HoraInicial">Hora Inicial:</label>
                                <input type="time" id="HoraInicial" name="HoraInicial" value="{{ old('HoraInicial') }}" required>

                                <label for="HoraFinal">Hora Final:</label>
                                <input type="time" id="HoraFinal" name="HoraFinal" value="{{ old('HoraFinal') }}" required>
                            </div>

                            <!-- Tercera columna -->
                            <div class="form-section">
                                <h3>Detalles Adicionales</h3>
                                <label for="DiaSemana">Día de la semana:</label>
                                <select id="DiaSemana" name="DiaSemana" required>
                                    <option value="">Seleccione un día</option>
                                    <option value="Lunes" {{ old('DiaSemana') == 'Lunes' ? 'selected' : '' }}>Lunes</option>
                                    <option value="Martes" {{ old('DiaSemana') == 'Martes' ? 'selected' : '' }}>Martes</option>
                                    <option value="Miércoles" {{ old('DiaSemana') == 'Miércoles' ? 'selected' : '' }}>Miércoles</option>
                                    <option value="Jueves" {{ old('DiaSemana') == 'Jueves' ? 'selected' : '' }}>Jueves</option>
                                    <option value="Viernes" {{ old('DiaSemana') == 'Viernes' ? 'selected' : '' }}>Viernes</option>
                                    <option value="Sábado" {{ old('DiaSemana') == 'Sábado' ? 'selected' : '' }}>Sábado</option>
                                    <option value="Domingo" {{ old('DiaSemana') == 'Domingo' ? 'selected' : '' }}>Domingo</option>
                                </select>

                                <label for="SalaMovil">Sala Móvil:</label>
                                <input type="text" id="SalaMovil" name="SalaMovil" value="{{ old('SalaMovil') }}" required>

                                <label for="Duracion">Duracion:</label>
                                <input type="text" id="Duracion" name="Duracion" value="{{ old('Duracion') }}" required>
                            </div>
                        </div>

                        <div style="text-align: center; margin-top: 20px;">
                            <button type="submit" name="agregarGrupo" style="width: auto; padding: 10px 30px;">Registrar Grupo</button>
                        </div>
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

                <div class="pagination d-flex justify-content-center mt-3">
                    @if ($paginaActual > 1)
                    <a class="btn btn-sm btn-outline-primary mx-1"
                        href="?pagina={{ $paginaActual - 1 }}&per_page={{ $elementosPorPagina }}@if(request('search'))&search={{ request('search') }}@endif">&laquo; Anterior</a>
                    @endif

                    @for ($i = max(1, $paginaActual - 2); $i <= min($totalPaginas, $paginaActual + 2); $i++)
                        @if ($i==$paginaActual)
                        <a class="btn btn-sm btn-primary mx-1"
                        href="?pagina={{ $i }}&per_page={{ $elementosPorPagina }}@if(request('search'))&search={{ request('search') }}@endif">{{ $i }}</a>
                        @else
                        <a class="btn btn-sm btn-outline-primary mx-1"
                            href="?pagina={{ $i }}&per_page={{ $elementosPorPagina }}@if(request('search'))&search={{ request('search') }}@endif">{{ $i }}</a>
                        @endif
                        @endfor

                        @if ($paginaActual < $totalPaginas)
                            <a class="btn btn-sm btn-outline-primary mx-1"
                            href="?pagina={{ $paginaActual + 1 }}&per_page={{ $elementosPorPagina }}@if(request('search'))&search={{ request('search') }}@endif">Siguiente &raquo;</a>
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
                                <th>Día</th>
                                <th>Sala</th>
                                <th>Duracion</th>
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
                                <td>{{ $grupo->DiaSemana }}</td>
                                <td>{{ $grupo->SalaMovil }}</td>
                                <td>{{ $grupo->Duracion }}</td>
                                <td>{{ $grupo->usuarios_count }}</td>
                                <td>
                                    <a href="{{ route('grupos.miembros', $grupo->IdGrupo) }}" class="btn btn-sm btn-info" title="Ver miembros">
                                        <div class="Group"> <img src="{{ asset('Imagenes/Group.png') }}" alt="miembros"></div>
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