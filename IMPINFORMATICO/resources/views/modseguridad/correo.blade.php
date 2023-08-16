<!DOCTYPE html>
<html>
<head>
    <title>Enviar Contraseña por Correo</title>
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/correo.css') }}">
</head>
<body>
    <div class="container">
        <h1>Enviar Contraseña por Correo</h1>

        <form action="{{ route('ModuloSeguridad.emailEnviarCon') }}" method="get">
            @csrf
            <label for="usuario" class="label-left">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required>
            <button type="submit" class="btn-enviar">Enviar Contraseña por Correo</button>
        </form>
    </div>
</body>
</html>

