<!DOCTYPE html>
<html>
<head>
    <title>Cambiar Contraseña</title>
    <!-- Enlazar el CSS de AdminLTE -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/recuperar.css') }}">
    <!-- Enlazar el CSS de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="hold-transition login-page">
<div class="contenedor">
    <h1 class="text-center">Cambiar Contraseña</h1>
    <form action="{{ route('ModuloSeguridad.nueva')}}" method="get" class="needs-validation" novalidate>
        <!-- Aquí puedes agregar el token CSRF si estás utilizando un framework como Laravel -->
        @csrf
        <!-- Campo para ingresar la nueva contraseña -->
        <div class="form-group">
            <label for="nueva_contrasenia" class="font-weight-bold">Nueva Contraseña:</label>
            <div class="input-group">
                <input type="password" name="nueva_contrasenia" id="nueva_contrasenia" class="form-control" required placeholder="Ingrese la nueva contraseña" maxlength="12">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="verNuevaContrasenia">Ver</button>
                </div>
            </div>
            <div class="invalid-feedback">
                Este campo es requerido.
            </div>
        </div>

        <!-- Campo para confirmar la nueva contraseña -->
        <div class="form-group">
            <label for="confirmar_contrasenia" class="font-weight-bold">Confirmar Contraseña:</label>
            <div class="input-group">
                <input type="password" name="confirmar_contrasenia" id="confirmar_contrasenia" class="form-control" required placeholder="Confirme la nueva contraseña" maxlength="12">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="verConfirmarContrasenia">Ver</button>
                </div>
            </div>
            <div class="invalid-feedback">
                Este campo es requerido.
            </div>
        </div>

        <!-- Mensaje de error para restricciones de contraseña -->
        <p id="contraseniaError" style="color: red;"></p>

        <!-- Botón para cambiar la contraseña -->
        <button type="submit" class="btn btn-primary btn-block">Cambiar Contraseña</button>
    </form>
</div>

<!-- Scripts de Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Habilitar botones de ver contraseña y bloquear espacios -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var inputNuevaContrasenia = document.getElementById('nueva_contrasenia');
        var inputConfirmarContrasenia = document.getElementById('confirmar_contrasenia');
        
        // Función para bloquear entrada de espacios en campos de contraseña
        function bloquearEspacios(input) {
            input.value = input.value.replace(/\s/g, '');
        }

        // Habilitar botón de ver contraseña en el campo Nueva Contraseña
        var verNuevaContrasenia = document.getElementById('verNuevaContrasenia');
        verNuevaContrasenia.addEventListener('click', function() {
            if (inputNuevaContrasenia.type === 'password') {
                inputNuevaContrasenia.type = 'text';
            } else {
                inputNuevaContrasenia.type = 'password';
            }
        });

        // Habilitar botón de ver contraseña en el campo Confirmar Contraseña
        var verConfirmarContrasenia = document.getElementById('verConfirmarContrasenia');
        verConfirmarContrasenia.addEventListener('click', function() {
            if (inputConfirmarContrasenia.type === 'password') {
                inputConfirmarContrasenia.type = 'text';
            } else {
                inputConfirmarContrasenia.type = 'password';
            }
        });

        // Validaciones de formulario
        var form = document.querySelector('.needs-validation');
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                var nuevaContrasenia = inputNuevaContrasenia.value;
                var confirmarContrasenia = inputConfirmarContrasenia.value;
                var minLength = 5; // Longitud mínima de la contraseña
                var maxLength = 12; // Longitud máxima de la contraseña
                
                // Validar longitud mínima y máxima de contraseña
                if (nuevaContrasenia.length < minLength || nuevaContrasenia.length > maxLength) {
                    event.preventDefault();
                    inputNuevaContrasenia.classList.add('is-invalid');
                    inputConfirmarContrasenia.classList.add('is-invalid');
                    document.getElementById('contraseniaError').textContent = 'La contraseña debe tener entre ' + minLength + ' y ' + maxLength + ' caracteres.';
                }
            }
            form.classList.add('was-validated');
        }, false);

        // Bloquear entrada de espacios en campos de contraseña
        inputNuevaContrasenia.addEventListener('input', function() {
            bloquearEspacios(this);
        });

        inputConfirmarContrasenia.addEventListener('input', function() {
            bloquearEspacios(this);
        });
    });
</script>

</body>
</html>
