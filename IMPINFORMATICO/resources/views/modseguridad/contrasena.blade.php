<!DOCTYPE html>
<html>
<head>
    <title>Cambiar Contraseña</title>
    <!-- Enlazar el CSS de AdminLTE -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/recuperar.css') }}">
</head>
<body class="hold-transition login-page">
<div class="contenedor">
    <h1 class="text-center">Cambiar Contraseña</h1>
    <form action="{{ route('ModuloSeguridad.nueva')}}" method="get">
        <!-- Aquí puedes agregar el token CSRF si estás utilizando un framework como Laravel -->
        @csrf
        <!-- Campo para ingresar la nueva contraseña -->
        <label for="nueva_contrasenia" class="font-weight-bold">Nueva Contraseña:</label>
        <input type="password" name="nueva_contrasenia" id="nueva_contrasenia" class="form-control" required placeholder="Ingrese la nueva contraseña">
        <br>

        <!-- Campo para confirmar la nueva contraseña -->
        <label for="confirmar_contrasenia" class="font-weight-bold">Confirmar Contraseña:</label>
        <input type="password" name="confirmar_contrasenia" id="confirmar_contrasenia" class="form-control" required placeholder="Confirme la nueva contraseña">
        <br>

        <!-- Botón para cambiar la contraseña -->
        <button type="submit" class="btn btn-primary btn-block">Cambiar Contraseña</button>
    </form>
</div>
</body>
</html>
