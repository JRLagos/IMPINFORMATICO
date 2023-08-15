<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/preguntas_usuario.css') }}">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <title>Configuración de Preguntas Secretas</title>
</head>
<body>
  <div class="container">
    <h2>Configuración de Preguntas Secretas</h2>
    <form action="{{ route('ModuloSeguridad.preguntasSeg') }}" method="get" class="needs-validation" novalidate>
      @csrf
      <label for="pregunta1">Pregunta</label>
      <select id="pregunta1" name="pregunta" class="form-control" required>
        <option value="1">Pregunta 1: ¿CUÁL ES EL NOMBRE DE TU MASCOTA?</option>
        <option value="2">Pregunta 2: ¿CUÁL ES TU COLOR FAVORITO?</option>
        <option value="3">Pregunta 2: ¿CUÁL ES EL NOMBRE DE TU MEJOR AMIGO DE LA INFANCIA?</option>
        <!-- Agregar más opciones según sea necesario -->
      </select>
      
      <label for="respuesta2">Respuesta</label>
      <input type="text" id="respuesta2" name="respuesta" class="form-control" maxlength="255" required>
      <div class="invalid-feedback">
        Por favor, ingresa una respuesta válida.
      </div>
      
      <label for="nueva_contrasenia">Nueva Contraseña</label>
      <input type="password" id="nueva_contrasenia" name="nueva_contrasenia" class="form-control" maxlength="255" required>
      <div class="invalid-feedback">
        Por favor, ingresa una contraseña válida.
      </div>

      <button type="submit" class="btn btn-primary">Guardar y Continuar</button>
    </form>
  </div>
  
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    // Agrega aquí el script para las validaciones de Bootstrap
    (function() {
      'use strict';

      window.addEventListener('load', function() {
        // Valida los formularios de Bootstrap
        var forms = document.getElementsByClassName('needs-validation');

        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
  </script>
</body>
</html>
