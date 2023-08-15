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
    <form action="{{ route('ModuloSeguridad.nueva')}}" method="post" class="needs-validation" novalidate>
        <!-- Aquí puedes agregar el token CSRF si estás utilizando un framework como Laravel -->
        @csrf
        <!-- Campo para ingresar la nueva contraseña -->
        <div class="form-group">
            <label for="nueva_contrasenia" class="font-weight-bold">Nueva Contraseña:</label>
            <input type="password" name="nueva_contrasenia" id="nueva_contrasenia" class="form-control" required placeholder="Ingrese la nueva contraseña">
            <div class="invalid-feedback">
                Este campo es requerido.
            </div>
        </div>

        <!-- Campo para confirmar la nueva contraseña -->
        <div class="form-group">
            <label for="confirmar_contrasenia" class="font-weight-bold">Confirmar Contraseña:</label>
            <input type="password" name="confirmar_contrasenia" id="confirmar_contrasenia" class="form-control" required placeholder="Confirme la nueva contraseña">
            <div class="invalid-feedback">
                Este campo es requerido.
            </div>
        </div>

        <!-- Botón para cambiar la contraseña -->
        <button type="submit" class="btn btn-primary btn-block">Cambiar Contraseña</button>
    </form>
</div>

<!-- Scripts de Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Validaciones de formulario con Bootstrap -->
<script>
    (function() {
        'use strict';
        // Deshabilitar el envío del formulario si hay campos inválidos
        window.addEventListener('load', function() {
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
