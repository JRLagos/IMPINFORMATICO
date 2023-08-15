<!DOCTYPE html>
<html>
<head>
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/menu-recuperar.css') }}">
</head>
<body>
    <div class="container">
        <h1>Recuperar Contraseña</h1>

        <form action="{{ route('ModuloSeguridad.seCorreo') }}" method="get">
    @csrf <!-- Agrega el token CSRF aquí -->
    <label for="usuario">Usuario:</label>
    <input type="text" id="usuario" name="usuario" required placeholder="Ingrese su usuario aquí">
    <div class="button-container">
        <button type="submit">Recuperar por Preguntas Secretas</button>
    </div>
</form>

<form action="{{ route('ModuloSeguridad.ConCorreo') }}" method="get">
    @csrf <!-- Agrega el token CSRF aquí -->
    <div class="button-container">
        <button type="submit">Recuperar por Envío al Email</button>
    </div>
</form>

    </div>
</body>
</html>
