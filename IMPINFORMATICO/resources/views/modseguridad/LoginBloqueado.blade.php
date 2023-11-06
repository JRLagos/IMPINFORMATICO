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
      max-width: 400px;
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
  </style>
</head>
<body>
  <div class="container">
    <h2>Cambio de contraseña</h2>
    <form action="{{ route('ModuloSeguridad.contra') }}" method="get" class="needs-validation" novalidate>
      @csrf
      <div class="form-group">
        <label for="nueva_contrasenia">Nueva Contraseña</label>
        <div class="input-group">
        <input type="password" id="nueva_contrasenia" name="nueva_contrasenia" class="form-control" minlength="5" maxlength="12" required pattern="^[a-zA-Z0-9@#$%]+$">

          <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
              <i class="fa fa-eye-slash" aria-hidden="true"></i>
            </button>
          </div>
        </div>
        <div class="invalid-feedback">
          La contraseña debe contener al menos 5 caracteres, incluyendo al menos una letra mayúscula, una letra minúscula, un número y un carácter especial (!@#$%).
        </div>
      </div>

      <!-- Mensaje de formato de contraseña -->
      <p class="password-instructions"><b>La contraseña debe contener al menos 5 caracteres, incluyendo al menos una letra mayúscula, una letra minúscula, un número y un carácter especial (!@#$%).</b></p>

      <!-- Agrega margen inferior al botón "Guardar y Continuar" -->
      <button type="submit" class="btn btn-primary mt-3">Guardar y Continuar</button>
    </form>
  </div>
  
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>

document.addEventListener("DOMContentLoaded", function() {
    const nuevaContraseniaInput = document.getElementById("nueva_contrasenia");

    nuevaContraseniaInput.addEventListener("input", function() {
      validarContrasenia(this);
    });

    function validarContrasenia(input) {
      const contrasenia = input.value;

      // Expresión regular para validar la contraseña
      const contraseniaRegex = /^[a-zA-Z0-9@#$%]+$/;

      if (contraseniaRegex.test(contrasenia)) {
        input.setCustomValidity("");
      } else {
        input.setCustomValidity("La contraseña debe contener solo letras mayúsculas, minúsculas, números y los caracteres especiales '@', '#', o '$'.");
      }
    }
  });

    document.addEventListener("DOMContentLoaded", function() {
    const nuevaContraseniaInput = document.getElementById("nueva_contrasenia");

    nuevaContraseniaInput.addEventListener("input", function() {
      validarContrasenia(this);
    });

    nuevaContraseniaInput.addEventListener("keydown", function(event) {
      if (event.key === " ") {
        event.preventDefault(); // Evita la entrada de espacios en blanco
      }
    });

    function validarContrasenia(input) {
      const contrasenia = input.value;

      // Expresión regular para validar la contraseña
      const contraseniaRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%])[A-Za-z\d!@#$%]*$/;

      if (contraseniaRegex.test(contrasenia)) {
        input.setCustomValidity("");
      } else {
        input.setCustomValidity("La contraseña debe contener al menos una mayúscula, una letra minúscula, un número y un carácter especial (!@#$%).");
      }
    }
  });
    document.addEventListener("DOMContentLoaded", function() {
      const form = document.querySelector("form");
      const nuevaContraseniaInput = document.getElementById("nueva_contrasenia");
      const togglePasswordBtn = document.getElementById("togglePassword");
  
      nuevaContraseniaInput.addEventListener("input", function() {
        validarContrasenia(this);
      });
  
      togglePasswordBtn.addEventListener('click', function () {
        const type = nuevaContraseniaInput.getAttribute('type') === 'password' ? 'text' : 'password';
        nuevaContraseniaInput.setAttribute('type', type);
        togglePasswordBtn.innerHTML = type === 'password' ? '<i class="fa fa-eye-slash" aria-hidden="true"></i>' : '<i class="fa fa-eye" aria-hidden="true"></i>';
      });
  
      form.addEventListener("submit", function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add("was-validated");
      });
  
      function validarContrasenia(input) {
        const contrasenia = input.value;
  
        // Expresión regular para validar la contraseña
        const contraseniaRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%])[A-Za-z\d!@#$%]*$/;
  
        if (contraseniaRegex.test(contrasenia)) {
          input.setCustomValidity("");
        } else {
          input.setCustomValidity("La contraseña debe contener al menos una mayúscula, una letra minúscula, un número y un carácter especial (!@#$%).");
        }
      }
    });
  </script>
</body>
</html>
