<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/preguntas_usuario.css') }}">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <title>Configuración de Preguntas Secretas</title>
  <style>
    /* Estilos para el cuerpo de la página */
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: "Source Sans Pro",-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"; 
      background-color: #f4f4f4;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0;
      padding: 0;
    }

    /* Estilos para el contenedor principal */
    .container {
      max-width: 600px; /* Ajusta el máximo ancho del contenedor */
      padding: 20px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    /* Estilos para el encabezado */
    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }

    /* Estilos para etiquetas de formulario */
    label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
      color: #666;
    }

    /* Estilos para los campos de entrada */
    select, input[type="text"], input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px; /* Ajustado para mayor redondez */
      box-sizing: border-box;
    }

    /* Estilos específicos para la caja de texto de respuesta */
    input[type="text"].form-control {
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 10px;
      width: 100%;
      box-sizing: border-box;
    }

    /* Estilos para el botón de envío */
    button[type="submit"] {
      width: 100%;
      padding: 10px;
      background-color: #ffc107; /* Amarillo */
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    button[type="submit"]:hover {
      background-color: #ffad00; /* Amarillo más oscuro al pasar el mouse */
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Configuración de Preguntas Secretas</h2>
    <form action="{{ route('ModuloSeguridad.preguntasSeg') }}" method="get" class="needs-validation" novalidate>
      @csrf
      <label for="pregunta1">Pregunta</label>
      <select id="pregunta1" name="pregunta" class="custom-select" required>
        <option value="1">Pregunta 1: ¿CUÁL ES EL NOMBRE DE TU MASCOTA?</option>
        <option value="2">Pregunta 2: ¿CUÁL ES TU COLOR FAVORITO?</option>
        <option value="3">Pregunta 3: ¿CUÁL ES EL NOMBRE DE TU MEJOR AMIGO DE LA INFANCIA?</option>
        <!-- Agregar más opciones según sea necesario -->
      </select>
      
      <label for="respuesta2">Respuesta</label>
      <input type="text" id="respuesta2" name="respuesta" class="form-control" maxlength="16" required pattern="^(\S*\s){0,1}\S*$">
      
      <!-- Agrega margen inferior al botón "Guardar y Continuar" -->
      <button type="submit" class="btn btn-warning mt-3">Guardar y Continuar</button>
    </form>
  </div>
</body>
</html>
  
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const form = document.querySelector("form");
      const respuestaInput = document.getElementById("respuesta2");
      const nuevaContraseniaInput = document.getElementById("nueva_contrasenia");
      const togglePasswordBtn = document.getElementById("togglePassword");
  
      respuestaInput.addEventListener("input", function() {
        // Convertir la respuesta a mayúsculas
        const value = this.value.trim();
        this.value = value.toUpperCase();
      });
  
      nuevaContraseniaInput.addEventListener("input", function() {
        const value = this.value.trim();
        this.value = value;
      });
  
      togglePasswordBtn.addEventListener('click', function () {
        const type = nuevaContraseniaInput.getAttribute('type') === 'password' ? 'text' : 'password';
        nuevaContraseniaInput.setAttribute('type', type);
        togglePasswordBtn.innerHTML = type === 'password' ? '<i class="fa fa-eye-slash" aria-hidden="true"></i> Ver' : '<i class="fa fa-eye" aria-hidden="true"></i> Ocultar';
      });
  
      form.addEventListener("submit", function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add("was-validated");
      });
    });
  </script>
</body>
</html>
