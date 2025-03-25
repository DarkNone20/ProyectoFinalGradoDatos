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
    <title>Reporte de Insumos</title>

</head>

<body>
    <nav>
        <ul>
            <li class="logo"><img src="../../Imagenes/Logo4.png"></li>
            <div class="Menu">
                <li><a href="../Indice/index.php"><i class="fa fa-home"></i>&nbsp;<img src="../../Imagenes/Inicio.png">
                        Home</a></li>
                <li><a href="../Usuarios/crear_usuarios.php"><i class="fa fa-users"></i>&nbsp;<img
                            src="../../Imagenes/User.png"> Usuarios</a></li>
                <li><a href="../Prestamos/prestamos.php"><i class="fa fa-phone"></i>&nbsp; <img
                            src="../../Imagenes/lista.png"> Prestamos</a></li>
                <li><a href="insumos-Index.php"><i class="fa fa-phone"></i>&nbsp;<img
                            src="../../Imagenes/inventario.png"> Insumos</a></li>
                <li><a href="../Incidentes/incidentes.php"><i class="fa fa-users"></i>&nbsp;<img
                            src="../../Imagenes/consecutivo.png"> Incidentes</a></li>
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
                    <h1>Sistema de Insumos</h1>
                </div>
                <div class="userLogo">
                    <img src="../../Imagenes/dos3.png">
                </div>
                <div class="Usuario">
                    <p>Jhon Jairo Castillo Valencia </p>
                </div>
                <br>
            </div>
        </div>

        <div class="Principal">
            <div class="Principal-Uno">
                <div class="Uno-lef">
                    <img src="../../Imagenes/List.png">
                </div>
                <div class="Uno-right">
                    <a href="Insumos/insumos.php">
                        <h2>Administradores</h2>
                    </a>
                </div>
            </div>

            <div class="Principal-Dos">
                <div class="Uno-lef">
                    <img src="../../Imagenes/cajas.png">
                </div>
                <div class="Uno-right">
                    <a href="Articulos/articulos.php">
                        <h2>Usuarios</h2>
                    </a>
                </div>
            </div>
           
        </div>



    </div>
    </div>
</body>

</html>
