<!DOCTYPE html>
<html>
<head>
    <title>Recuperar Contraseña</title>
    <!-- Enlazar el CSS de AdminLTE -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/preguntas.css') }}">
</head>
<body class="hold-transition login-page">
<div class="contenedor">
    <h1 class="text-center">Recuperar Contraseña</h1>
    <form action="{{ route('ModuloSeguridad.recuperar')}}" method="get">
        <!-- Aquí puedes agregar el token CSRF si estás utilizando un framework como Laravel -->
        @csrf

        <!-- Pregunta de seguridad -->
        <label for="pregunta" class="font-weight-bold">Pregunta de Seguridad:</label>
        <select name="pregunta" id="pregunta" class="form-control" required>
            <option value="" disabled selected>Selecciona una pregunta</option>
            <option value="1">¿Cuál es el nombre de tu mascota?</option>
            <option value="2">¿Cuál es tu color favorito?</option>
            <option value="3">¿Cuál es el nombre de tu mejor amigo/a de la infancia?</option>
            <!-- Puedes agregar más opciones de preguntas aquí -->
        </select>
        <br>

        <!-- Campo para ingresar la respuesta a la pregunta de seguridad -->
        <label for="respuesta" class="font-weight-bold">Respuesta:</label>
        <input type="text" name="respuesta" id="respuesta" class="form-control" required placeholder="Ingrese su respuesta">
        <br>

        <!-- Botón para enviar el formulario -->
        <button type="submit" class="btn btn-primary btn-block">Recuperar Contraseña</button>
    </form>
</div>
</body>
</html>
