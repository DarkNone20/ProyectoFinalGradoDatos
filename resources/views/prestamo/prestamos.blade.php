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
    <title>Prestamos</title>

</head>

<body>
    <nav>
        <ul>
           <li class="logo"><img  src="{{ asset('Imagenes/Logo5.png') }}" alt="Logo" ></li>
            <div class="Menu">
                <li><a href="{{ asset('home') }}"><i class="fa fa-home"></i>&nbsp;<img simg src="{{ asset('Imagenes/inicio.png') }}" alt="inicio">
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
                <li><a href="?logout=1"><i class="fa fa-phone"></i>&nbsp; <img src="../../Imagenes/logout.png">
                        Logout</a></li>
            </div>
        </ul>
    </nav>

    <div class="wrapper">
        <div class="section">
            <div class="Encabezado">
                <div class="Titulo">
                    <h1>Administrador de Prestamos</h1>
                </div>
                <div class="userLogo">
                    <img src="../../Imagenes/dos3.png">
                </div>
                <div class="Usuario">
                    <p>JJCASTILLO </p>
                </div>
                <br>
            </div>
        </div>

        <div class="Principal">
            
           
        </div>



    </div>
    </div>
</body>

</html>
