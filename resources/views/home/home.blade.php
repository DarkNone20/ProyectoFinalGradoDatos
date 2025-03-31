
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
    <link rel="stylesheet" href="{{ asset('assets/style-home.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Home</title>
</head>

<body>

    <nav>
        <ul>
 
            <li class="logo"><img  src="{{ asset('Imagenes/Logo5.png') }}" alt="Logo" ></li>
            <div class="Menu">
                <li><a href="{{ asset('home') }}"><i class="fa fa-home"></i>&nbsp;<img src="{{ asset('Imagenes/inicio.png') }}" alt="inicio"> Home</a></li>
                <li><a href="{{ asset('usuarios') }}"><i class="fa fa-users"></i>&nbsp;<img src="{{ asset('Imagenes/user.png') }}" alt="user"> Usuarios</a></li>
                <li><a href="{{ asset('grupos') }}"><i class="fa fa-phone"></i>&nbsp; <img src="{{ asset('Imagenes/lista.png') }}" alt="grupos"> Grupos</a></li>
                <li><a href="{{ asset('equipos') }}"><i class="fa fa-phone"></i>&nbsp;<img src="{{ asset('Imagenes/inventario.png') }}" alt="equipos"> Equipos</a></li>
                <li><a href="{{ asset('prestamos') }}"><i class="fa fa-users"></i>&nbsp;<img src="{{ asset('Imagenes/consecutivo.png') }}" alt="prestamos"> Prestamos</a></li>
            </div>

            <div class="Prueba">
                <li><a href="{{ asset('/') }}"><i class="fa fa-phone"></i>&nbsp; <img src="{{ asset('Imagenes/logout.png') }}" alt="login">
                        Logout</a></li>
            </div>

        </ul>
    </nav>

    <div class="wrapper">
        <div class="section">

            <div class="Encabezado">

                <div class="Titulo">
                    <h1>Sistema de Administrador de Préstamo de Portatiles </h1>
                </div>


                <div class="userLogo">
                    <img src="../../Imagenes/dos3.png">
                </div>
                <div class="Usuario">
                    <p>JJCASTILLO</p>
                </div>

                <br>
            </div>

            <div class="Group">

                <div class="Clase1">

                    <div class="Clase1-left">
                        <img src="../../Imagenes/Usuarios.png">
                    </div>
                    <div class="Clase1-Right">
                        <a href="{{ asset('usuarios') }}">
                            <h1>Usuarios</h1>
                        </a>
                    </div>
                </div>
                <div class="Clase2">

                    <div class="Clase2-left">
                        <img src="../../Imagenes/Intercambio.png">
                    </div>
                    <div class="Clase2-Right">
                        <a href="{{ asset('grupos') }}">
                            <h1>Grupos</h1>
                        </a>
                    </div>
                </div>
                <div class="Clase3">

                    <div class="Clase3-left">
                        <img src="../../Imagenes/List.png">
                    </div>
                    <div class="Clase3-Right">
                        <a href="{{ asset('equipos') }}">
                            <h1>Equipos</h1>
                        </a>
                    </div>
                </div>
                <div class="Clase4">

                    <div class="Clase4-left">
                        <img src="../../Imagenes/Historial.png">
                    </div>
                    <div class="Clase4-Right">
                        <a href="{{ asset('prestamos') }}">
                            <h1>Prestamos</h1>
                        </a>
                    </div>
                </div>

            </div>

            <div class="Principal">
                <div class="Principal-Left">
                    <h2>Grafico de Prestamos</h2>
                    <canvas id="graficaTortaPrestamos"></canvas>
                  
                </div>

                <div class="Principal-Right">

                    <div class="Principal-Arriba">
                        <h2>Grafico de Grupos</h2>
                        <canvas id="graficaBarrasGrupos"></canvas>
                        
                    </div>

                    <div class="Principal-Abajo">
                        <h2>Grafico de Equipos</h2>
                        <canvas id="graficaBarrasEquipos"></canvas>
                        
                    </div>

                </div>

                <footer>
                    <p> </p>
                </footer>
            </div>
        </div>

</body>

</html>
