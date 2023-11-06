<!DOCTYPE html>
<html>
<head>
    <title>Enviar Contraseña por Correo</title>
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/correo.css') }}">
    <style>
        .input-uppercase {
            text-transform: uppercase;
        }
        /* Estilos para el modal */
        .modal-container {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            text-align: center; /* Centrar el contenido */
        }
        .modal-title {
            font-size: 24px; /* Tamaño del título */
        }
        .modal-message {
            font-size: 18px; /* Tamaño del mensaje */
            margin-top: 20px; /* Espacio superior entre el título y el mensaje */
        }
        .modal-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px; /* Espacio superior entre el mensaje y el botón */
        }
        .modal-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Enviar Contraseña por Correo</h1>

        <!-- Mensaje de error -->
        @if (session()->has('error'))
            <div class="alert alert-custom">
                <p class="text-center">
                    {{ session('error') }}
                </p>
            </div>
            {{ session()->forget('error') }} <!-- Elimina la sesión flash 'error' -->
        @endif

        <form id="correo-form" action="{{ route('ModuloSeguridad.emailEnviarCon') }}" method="get">
            @csrf
            <label for="usuario" class="label-left">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required class="input-uppercase" minlength="3" maxlength="20">
            <!-- Cambia el tipo del botón a "submit" y agrega la clase "show-modal" -->
            <button type="submit" class="btn-enviar" id="enviar-correo-button">Enviar Contraseña por Correo</button>
        </form>
    </div>

    <!-- Modal simple -->
    <div id="success-modal" class="modal-container">
        <div class="modal-content">
            <h2 class="modal-title">Correo enviado con éxito</h2>
            <p class="modal-message">El correo se ha enviado exitosamente.</p>
            <button id="modal-close-button" class="modal-button" onclick="closeModal()">Cerrar</button>
        </div>
    </div>

    <script>
        // Mostrar el modal al hacer clic en el botón
        document.getElementById('enviar-correo-button').addEventListener('click', function () {
            document.getElementById('success-modal').style.display = 'flex';
        });

        // Cerrar el modal al hacer clic en el botón "Cerrar"
        function closeModal() {
            document.getElementById('success-modal').style.display = 'none';
        }

        document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");
  const respuestaInput = document.getElementById("respuesta2");
  const nuevaContraseniaInput = document.getElementById("nueva_contrasenia");
  const togglePasswordBtn = document.getElementById("togglePassword");

  respuestaInput.addEventListener("input", function () {
    const value = this.value.trim();
    this.value = value.toUpperCase();
  });

  nuevaContraseniaInput.addEventListener("input", function () {
    const value = this.value.trim();
    this.value = value;

    // Llamar a la función para validar la contraseña
    validarContrasenia(this);
  });

  togglePasswordBtn.addEventListener("click", function () {
    const type =
      nuevaContraseniaInput.getAttribute("type") === "password"
        ? "text"
        : "password";
    nuevaContraseniaInput.setAttribute("type", type);
    togglePasswordBtn.innerHTML =
      type === "password"
        ? '<i class="fa fa-eye-slash" aria-hidden="true"></i> Ver'
        : '<i class="fa fa-eye" aria-hidden="true"></i> Ocultar';
  });

  form.addEventListener("submit", function (event) {
    if (form.checkValidity() === false) {
      event.preventDefault();
      event.stopPropagation();
    }
    form.classList.add("was-validated");
  });

  function validarContrasenia(input) {
    const contrasenia = input.value;

    // Expresión regular para validar la contraseña
    const contraseniaRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{5,12}$/;

    if (contraseniaRegex.test(contrasenia)) {
      input.setCustomValidity("");
      input.classList.remove("is-invalid");
      input.classList.add("is-valid");
    } else {
      input.setCustomValidity(
        "La contraseña debe contener al menos una mayúscula, una minúscula, un número y un carácter especial."
      );
      input.classList.remove("is-valid");
      input.classList.add("is-invalid");
    }
  }
});


    </script>
</body>
</html>
