<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Administradores</title>
    <link rel="stylesheet" href="{{ asset('assets/prueba.css') }}">
</head>
<body>
    <div class="Formulario">
        <div class="group">
            @if ($errors->has('loginError'))
                <p style="color: red;">{{ $errors->first('loginError') }}</p>
            @endif
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="LogoI"><img src="{{ asset('Imagenes/Logo.jpg') }}" alt="Logo"></div>
                <label for="Cedula"></label>
                <input type="text" name="Cedula" class="control" placeholder="Cédula" required>
                <br>
                <label for="Password"></label>
                <input type="password" name="Password" class="control" placeholder="Contraseña" required>
                <br>
                <button type="submit">Iniciar sesión</button>
            </form>
        </div>
    </div>
</body>
</html>