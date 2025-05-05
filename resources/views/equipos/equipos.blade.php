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
                    <h1>Administrador de Equipos</h1>
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
                <div class="Botones-Contenido">
                    <div class="Boton-Uno">
                        <button type="button-Uno"><img src="{{ asset('Imagenes/agregar.png') }}" alt="agregar">
                            Agregar Equipo</button>
                    </div>
                    <!-- Botón exportar usuarios -->
                    <div class="Boton-Dos">
                        <a href="{{ route('equipos.export') }}" class="btn-export">
                            <img src="{{ asset('Imagenes/Exportar.png') }}" alt="exportar">
                            Exportar Usuarios
                        </a>
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
                                    <td>{{ $equipo->Estado }}</td>
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
                <h2>Equipos</h2>
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

                        <label for="ActivoFijo">Activo Fijo:</label>
                        <input type="text" id="ActivoFijo" name="ActivoFijo" value="{{ old('ActivoFijo') }}" required>

                        <label for="Serial">Serial:</label>
                        <input type="text" id="Serial" name="Serial" value="{{ old('Serial') }}" required>

                        <label for="Marca">Marca:</label>
                        <input type="text" id="Marca" name="Marca" value="{{ old('Marca') }}">

                        <label for="Modelo">Modelo:</label>
                        <input type="text" id="Modelo" name="Modelo" value="{{ old('Modelo') }}">

                        <label for="SalaMovil">Sala/Móvil:</label>
                        <input type="text" id="SalaMovil" name="SalaMovil" value="{{ old('SalaMovil') }}">

                        <label for="Estado">Estado:</label>
                        <select id="Estado" name="Estado" required>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                            <option value="En reparación">En reparación</option>
                            <option value="Dado de baja">Dado de baja</option>
                        </select>

                        <button type="submit" name="agregarEquipo">Registrar Equipo</button>
                    </form>
                </div>
            </div>
        </div>
        <footer></footer>
    </div>

    
</body>

</html>
