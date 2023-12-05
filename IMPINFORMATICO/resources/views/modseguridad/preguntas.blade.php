<!DOCTYPE html>
<html>
<head>
    <title>Recuperar Contraseña</title>
    <!-- Enlazar el CSS de AdminLTE -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/preguntas.css') }}">
    <!-- Agrega el enlace al archivo CSS de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="hold-transition login-page">

<style>
          /* Agrega aquí tus estilos personalizados */

        /* Estilos para el contenedor del formulario */
        .contenedor {
    width: 60%; /* Ajusta el ancho del contenedor según tus necesidades */
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    text-align: left;
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
        input[type="email"],
        input[type="text"],
        select {
            width: 100%;
            padding: 5px; /* Ajustar el padding */
            margin-bottom: 15px;
            border: 1px solid #d2d6de;
            border-radius: 4px;
            color: #212529; /* Agregamos el color de letra */
            font-size: 14px; /* Ajustar el tamaño de fuente */
        }

        /* Estilos para el botón de enviar */
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff; /* Color primario de AdminLTE */
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3; /* Color secundario de AdminLTE */
        }

        /* Estilos para centrar el contenedor */
        body {
            display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: #e9ecef; /* Color de fondo para todo el cuerpo */
        }
    </style>

    <div class="contenedor">
        <h1 class="text-center">Recuperar Contraseña</h1>
        <form action="{{ route('ModuloSeguridad.recuperar')}}" method="get" id="recuperarForm" class="needs-validation" novalidate>
            <!-- Aquí puedes agregar el token CSRF si estás utilizando un framework como Laravel -->
            @csrf

            <!-- Pregunta de seguridad -->
            <div class="mb-3">
                <label for="pregunta" class="font-weight-bold">Pregunta de Seguridad:</label>
                <select name="pregunta" id="pregunta" class="form-control" required>
                    <option value="" disabled selected>Selecciona una pregunta</option>
                    <option value="1">¿Cuál es el nombre de tu mascota?</option>
                    <option value="2">¿Cuál es tu color favorito?</option>
                    <option value="3">¿Cuál es el nombre de tu mejor amigo/a de la infancia?</option>
                    <!-- Puedes agregar más opciones de preguntas aquí -->
                </select>
                <div class="invalid-feedback">
                    Por favor, selecciona una pregunta.
                </div>
            </div>
            <br>

            <!-- Campo para ingresar la respuesta a la pregunta de seguridad -->
            <div class="mb-3">
                <label for="respuesta" class="font-weight-bold">Respuesta:</label>
                <div class="input-group">
                    <input type="text" name="respuesta" id="respuesta" class="form-control" required placeholder="Ingrese su respuesta"  maxlength="16">
                    <div class="invalid-feedback">
                        Por favor, ingrese su respuesta.
                    </div>
                    
                </div>
            </div>
            <br>

            <!-- Botón para enviar el formulario -->
            <button type="submit" class="btn btn-primary btn-block">Recuperar Contraseña</button>
        </form>
    </div>

    <script>
        // ... Script de validación anterior ...

        // Agrega aquí el código para la validación de respuesta
        document.getElementById('recuperarForm').addEventListener('submit', function(event) {
            var respuestaInput = document.getElementById('respuesta');
            var respuestaValue = respuestaInput.value.trim();
            var respuestaError = document.getElementById('respuestaError');
            
            if (respuestaValue === '') {
                event.preventDefault();
                respuestaInput.classList.add('is-invalid');
                respuestaError.style.display = 'inline';
            } else {
                respuestaInput.classList.remove('is-invalid');
                respuestaError.style.display = 'none';
            }
        });
    </script>

    <!-- Agrega el script de Bootstrap al final del documento -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>






































