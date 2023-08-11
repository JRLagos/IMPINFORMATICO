<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/preguntas_usuario.css') }}">
  <title>Configuración de Preguntas Secretas</title>
</head>
<body>
  <div class="container">
    <h2>Configuración de Preguntas Secretas</h2>
    <form action="{{ route('ModuloSeguridad.preguntasSeg') }}" method="get">
      @csrf
      <label for="pregunta1">Pregunta</label>
      <select id="pregunta1" name="pregunta">
        <option value="1">Pregunta 1: ¿CUÁL ES EL NOMBRE DE TU MASCOTA?</option>
        <option value="2">Pregunta 2: ¿CUÁL ES TU COLOR FAVORITO?</option>
        <option value="3">Pregunta 2: ¿CUÁL ES EL NOMBRE DE TU MEJOR AMIGO DE LA INFANCIA?</option>
        <!-- Agregar más opciones según sea necesario -->
      </select>
      
      <label for="respuesta2">Respuesta</label>
      <input type="text" id="respuesta2" name="respuesta" maxlength="255">
      
      <label for="nueva_contrasenia">Nueva Contraseña</label>
      <input type="password" id="nueva_contrasenia" name="nueva_contrasenia" maxlength="255">

      <button type="submit">Guardar y Continuar</button>
    </form>
  </div>
</body>
</html>
