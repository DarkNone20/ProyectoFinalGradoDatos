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
    <link rel="stylesheet" href="{{ asset('assets/style-mienbros.css') }}">
    <title>Miembros del Grupo</title>
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
                <li><a href="{{ route('reportes.index') }}"><img src="{{ asset('Imagenes/Reportes 2.0.png') }}" alt="prestamos"> Reportes</a></li>
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
                    <h1>Miembros del Grupo {{ $grupo->IdGrupo }}</h1>
                </div>
                <div class="userLogo">
                    <img src="{{ asset('Imagenes/dos3.png') }}">
                </div>
                <div class="Usuario">
                    <p>{{ auth()->user()->Nombre ?? 'Invitado' }}</p>
                </div>
                <br>
            </div>
        </div>

        <div class="Contenido">

          
            <div class="Contenido-Uno">
                <div class="Botones-Contenido">
                    <div class="Boton-Uno">
                        <button type="button-Uno" onclick="window.location.href='{{ route('grupos.index') }}'">
                            <img src="{{ asset('Imagenes/Volver2.png') }}" alt="volver"> Volver
                        </button>
                    </div>
                    <!--  
                    <div class="Boton-Dos">
                        <button type="button-Dos">
                            <img src="{{ asset('Imagenes/Exportar.png') }}" alt="exportar"> Exportar
                        </button>
                    </div>-->
                </div> 


                <div class="Tabla-Contenido mt-4">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Documento ID</th>
                                <th>Nombre</th>
                                <th>Rol</th>
                                <th>Fecha Asignación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($miembros as $miembro)
                                <tr>
                                    <td>{{ $miembro->DocumentoId }}</td>
                                    <td>{{ $miembro->Nombre }} {{ $miembro->Apellido }}</td>
                                    <td>{{ $miembro->pivot->Rol }}</td>
                                    <td>{{ $miembro->pivot->FechaAsignacion }}</td>
                                    <td>
                                        <form
                                            action="{{ route('grupos.removerUsuario', [$grupo->IdGrupo, $miembro->DocumentoId]) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-eliminar"
                                                onclick="return confirm('¿Estás seguro de remover este usuario del grupo?')">
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
                <h2>Grupo <p>{{ $grupo->NombreProfesor }} - {{ $grupo->NombreCurso }}</p>
                </h2>
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

                    <form action="{{ route('grupos.asignarUsuario', $grupo->IdGrupo) }}" method="POST">
                        @csrf
                        <div class="row justify-content-center">
                            <div>
                                <label for="DocumentoId">Usuario:</label>
                                <select id="DocumentoId" name="DocumentoId" class="form-select" required>
                                    <option value="">Seleccione un usuario</option>
                                    @foreach ($usuariosDisponibles as $usuario)
                                        <option value="{{ $usuario->DocumentoId }}">
                                            {{ $usuario->Nombre }} {{ $usuario->Apellido }}
                                            ({{ $usuario->DocumentoId }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="Rol">Rol:</label>
                                <select id="Rol" name="Rol" class="form-select" required>
                                    <option value="Estudiante">Estudiante</option>
                                    <option value="Profesor">Profesor</option>
                                    <option value="invitado">Invitado</option>
                                    <option value="egresado">Egresado</option>
                                </select>
                            </div>

                            <div>
                                <label for="FechaAsignacion">Fecha de Asignación:</label>
                                <input type="date" id="FechaAsignacion" name="FechaAsignacion" class="form-control"
                                    required>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-primary">Agregar</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>



        </div>
    </div>

    <footer></footer>
</body>

</html>
