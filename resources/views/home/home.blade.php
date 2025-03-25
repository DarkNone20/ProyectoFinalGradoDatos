
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

            <li class="logo"><img src="../../Imagenes/Logo4.png"></li>
            <div class="Menu">
                <li><a href="index.php"><i class="fa fa-home"></i>&nbsp;<img src="../../Imagenes/Inicio.png"> Home</a>
                </li>
                <li><a href="../Usuarios/crear_usuarios.php"><i class="fa fa-users"></i>&nbsp;<img src="{{ asset('Imagenes/user.png') }}" alt="user"> Usuarios</a></li>
                <li><a href="../Prestamos/prestamos.php"><i class="fa fa-phone"></i>&nbsp; <img
                            src="../../Imagenes/lista.png"> Grupos</a></li>
                <li><a href="../Insumos/insumos-Index.php"><i class="fa fa-phone"></i>&nbsp;<img
                            src="../../Imagenes/inventario.png"> Equipos</a></li>
                <li><a href="../Incidentes/incidentes.php"><i class="fa fa-users"></i>&nbsp;<img
                            src="../../Imagenes/consecutivo.png"> Prestamos</a></li>
            </div>

            <div class="Prueba">
                <li><a href="?logout=1"><i class="fa fa-phone"></i>&nbsp; <img src="../../Imagenes/logout.png">
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
                    <p>Jhon Jairo Castillo Valencia</p>
                </div>

                <br>
            </div>

            <div class="Group">

                <div class="Clase1">

                    <div class="Clase1-left">
                        <img src="../../Imagenes/Usuarios.png">
                    </div>
                    <div class="Clase1-Right">
                        <a href="../Usuarios/crear_usuarios.php">
                            <h1>Usuarios</h1>
                        </a>
                    </div>
                </div>
                <div class="Clase2">

                    <div class="Clase2-left">
                        <img src="../../Imagenes/Intercambio.png">
                    </div>
                    <div class="Clase2-Right">
                        <a href="../Prestamos/prestamos.php">
                            <h1>Grupos</h1>
                        </a>
                    </div>
                </div>
                <div class="Clase3">

                    <div class="Clase3-left">
                        <img src="../../Imagenes/List.png">
                    </div>
                    <div class="Clase3-Right">
                        <a href="../Insumos/insumos-Index.php">
                            <h1>Equipos</h1>
                        </a>
                    </div>
                </div>
                <div class="Clase4">

                    <div class="Clase4-left">
                        <img src="../../Imagenes/Historial.png">
                    </div>
                    <div class="Clase4-Right">
                        <a href="../Incidentes/incidentes.php">
                            <h1>Prestamos</h1>
                        </a>
                    </div>
                </div>

            </div>

            <div class="Principal">
                <div class="Principal-Left">
                    <h2>Grafico de Insumos</h2>
                    <canvas id="graficaTortaInsumos"></canvas>
                  
                </div>

                <div class="Principal-Right">

                    <div class="Principal-Arriba">
                        <h2>Grafico de Prestamos</h2>
                        <canvas id="graficaBarrasPrestamos"></canvas>
                        
                    </div>

                    <div class="Principal-Abajo">
                        <h2>Grafico de Incidentes</h2>
                        <canvas id="graficaBarrasIncidentes"></canvas>
                        
                    </div>

                </div>

                <footer>
                    <p> </p>
                </footer>
            </div>
        </div>

</body>

</html>
