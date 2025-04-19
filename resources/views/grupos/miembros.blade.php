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
    <title>Miembros del Grupo</title>
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
                    <h1>Miembros del Grupo {{ $grupo->IdGrupo }}</h1>
                    <p>{{ $grupo->NombreProfesor }} - {{ $grupo->NombreCurso }}</p>
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
                <h2>Agregar Miembro</h2>
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
                        <div class="row">
                            <div class="col-md-6">
                                <label for="DocumentoId">Usuario:</label>
                                <select id="DocumentoId" name="DocumentoId" class="form-select" required>
                                    <option value="">Usuario</option>
                                    @foreach($usuariosDisponibles as $usuario)
                                        <option value="{{ $usuario->DocumentoId }}">
                                            {{ $usuario->Nombre }} {{ $usuario->Apellido }} ({{ $usuario->DocumentoId }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="Rol">Rol:</label>
                                <select id="Rol" name="Rol" class="form-select" required>
                                    <option value="Estudiante">Estudiante</option>
                                    <option value="Profesor">Profesor</option>
                                    <option value="invitado">Invitado</option>
                                    <option value="egresado">Egresado</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary mt-4">Agregar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="Contenido-Dos">
                <div class="Botones-Contenido">
                    <div class="Boton-Uno">
                        <button type="button-Uno" onclick="window.location.href='{{ route('grupos.index') }}'">
                            <img src="{{ asset('Imagenes/volver.png') }}" alt="volver"> Volver a Grupos
                        </button>
                    </div>
                    <div class="Boton-Dos">
                        <button type="button-Dos">
                            <img src="{{ asset('Imagenes/Exportar.png') }}" alt="exportar"> Exportar
                        </button>
                    </div>
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
                            @foreach($miembros as $miembro)
                                <tr>
                                    <td>{{ $miembro->DocumentoId }}</td>
                                    <td>{{ $miembro->usuario->Nombre }} {{ $miembro->usuario->Apellido }}</td>
                                    <td>{{ $miembro->Rol }}</td>
                                    <td>{{ $miembro->FechaAsignacion }}</td>
                                    <td>
                                        <form action="{{ route('grupos.removerUsuario', [$grupo->IdGrupo, $miembro->DocumentoId]) }}" method="POST"
                                            style="display: inline;">
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
        </div>
    </div>

    <footer></footer>
</body>
</html>