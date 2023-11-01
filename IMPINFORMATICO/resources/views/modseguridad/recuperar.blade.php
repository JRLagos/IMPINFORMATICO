<!DOCTYPE html>
<html>
<head>
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/menu-recuperar.css') }}">
    <!-- Agrega el enlace al archivo CSS de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <style>
        /* Agrega aquí tus estilos personalizados */

        /* Estilos para el cuerpo de la página */
        body {
            font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            background-color: #e9ecef;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Estilos para el contenedor principal */
        .container {
            width: 350px; /* Aumenta el ancho del contenedor */
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        /* Estilos para el título */
        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Estilos para los labels */
        label {
            display: block;
            margin-bottom: 10px;
        }

        /* Estilos para los campos de entrada */
        input[type="text"] {
            width: 100%;
            padding: 5px;
            margin-bottom: 15px;
            border: 1px solid #d2d6de;
            border-radius: 4px;
            color: #212529;
            font-size: 14px;
        }

        /* Estilos para los botones */
        .button-container {
            display: flex;
            flex-direction: column; /* Cambia la dirección a columna para separar los botones verticalmente */
            align-items: center; /* Centra los botones horizontalmente */
            margin-top: 15px;
        }

        /* Estilos para el botón de enviar */
        button {
            width: 100%; /* Ajusta el ancho al 100% */
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 10px; /* Agrega margen inferior para separar los botones */
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>

    <div class="container">
        <h1>Recuperar Contraseña</h1>

        <form action="{{ route('ModuloSeguridad.seCorreo') }}" method="get" class="needs-validation" novalidate>
            @csrf <!-- Agrega el token CSRF aquí -->

            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" id="usuario" name="usuario" class="form-control custom-input" required placeholder="Ingrese su usuario aquí">
                <div class="invalid-feedback">
                    Por favor, ingrese su usuario.
                </div>
            </div>

            <div class="button-container">
                <button type="submit" class="btn btn-primary btn-custom-width">Recuperar por Preguntas Secretas</button>
            </div>
        </form>

        <form action="{{ route('ModuloSeguridad.ConCorreo') }}" method="get" class="needs-validation" novalidate>
            @csrf <!-- Agrega el token CSRF aquí -->

            <div class="button-container">
                <button type="submit" class="btn btn-primary btn-custom-width">Recuperar por Envío al Email</button>
            </div>
        </form>
    </div>

    <!-- Agrega el script de Bootstrap al final del documento -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Agrega un script personalizado para la validación -->
    <script>
        (function () {
            'use strict';

            // Obtiene todos los formularios con la clase 'needs-validation'
            var forms = document.querySelectorAll('.needs-validation');

            // Recorre los formularios y evita el envío si no son válidos
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false);
            });
        })();

        document.addEventListener("DOMContentLoaded", function() {
            const contraseniaInput = document.getElementById("contrasenia");

            contraseniaInput.addEventListener("input", function() {
                const sanitizedValue = this.value.replace(/[^!@#$]/g, "");
                this.value = sanitizedValue;
            });
        });
    </script>
</body>
</html>
