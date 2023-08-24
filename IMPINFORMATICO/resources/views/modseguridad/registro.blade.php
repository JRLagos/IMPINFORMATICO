<!DOCTYPE html>
<html>
<head>
    <title>Crea una Cuenta</title>
    <!-- Link Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Enlazar el CSS proporcionado en la etiqueta <link> -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/registro.css') }}">
</head>
<body>
<div class="contenedor">
    <h1>Crear Cuenta</h1>
    <form id="registroForm" action="{{ route('ModuloSeguridad.enviar') }}" method="post">
        @csrf <!-- Token CSRF de Laravel para protección contra ataques Cross-Site Request Forgery -->
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-control is-invalid" placeholder="Tu Nombre" maxlength="20" required>
            <div class="invalid-feedback">
                Este campo es requerido.
            </div>
        </div>
        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" id="apellido" class="form-control is-invalid" placeholder="Tu Apellido" maxlength="20" required>
            <div class="invalid-feedback">
                Este campo es requerido.
            </div>
        </div>
        <div class="form-group">
            <label for="correo">Correo Electrónico:</label>
            <input type="email" name="correo" id="correo" class="form-control is-invalid" required placeholder="Tu Correo Electrónico" maxlength="20">
            <div class="invalid-feedback">
                Este campo es requerido.
            </div>
        </div>
        <div class="form-group">
            <label for="contrasenia">Contraseña:</label>
            <input type="password" name="contrasenia" id="contrasenia" class="form-control is-invalid" required placeholder="Tu Contraseña" maxlength="20">
            <div class="invalid-feedback">
                Este campo es requerido.
            </div>
        </div>
        <div class="form-group">
            <label for="usuario">Nombre de Usuario:</label>
            <input type="text" name="usuario" id="usuario" class="form-control is-invalid" required placeholder="Tu Nombre de Usuario" maxlength="20">
            <div class="invalid-feedback">
                Este campo es requerido.
            </div>
        </div>
        <div class="form-group">
            <label for="dni">DNI:</label>
            <input type="text" name="dni" id="dni" class="form-control is-invalid" required placeholder="Tu DNI" maxlength="13">
            <div class="invalid-feedback">
                Este campo es requerido.
            </div>
        </div>
        <div class="form-group">
            <label for="rtn">RTN:</label>
            <input type="text" name="rtn" id="rtn" class="form-control" placeholder="Tu RTN" maxlength="14">
        </div>
        <div class="form-group">
            <label for="tipo_telefono">Tipo de Teléfono:</label>
            <select name="tipo_telefono" id="tipo_telefono" class="form-control">
                <option value="FIJO">FIJO</option>
                <option value="CELULAR">CELULAR</option>
            </select>
        </div>
        <div class="form-group">
            <label for="numero_telefono">Número de Teléfono:</label>
            <input type="text" name="numero_telefono" id="numero_telefono" class="form-control" placeholder="Tu Número de Teléfono" maxlength="8">
        </div>
        <div class="form-group">
            <label for="sexo">Sexo:</label>
            <select name="sexo" id="sexo" class="form-control">
                <option value="MASCULINO">MASCULINO</option>
                <option value="FEMENINO">FEMENINO</option>
            </select>
        </div>
        <div class="form-group">
           <label for="edad">Edad:</label>
           <input type="number" name="edad" id="edad" class="form-control" placeholder="Tu Edad" min="0" max="99">
        </div>
        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" placeholder="Tu Fecha de Nacimiento">
        </div>
        <div class="form-group">
            <label for="lugar_nacimiento">Lugar de Nacimiento:</label>
            <input type="text" name="lugar_nacimiento" id="lugar_nacimiento" class="form-control" placeholder="Tu Lugar de Nacimiento"  maxlength="20">
        </div>
        <div class="form-group">
            <label for="estado_civil">Estado Civil:</label>
            <select name="estado_civil" id="estado_civil" class="form-control">
                <option value="SOLTERO">SOLTERO</option>
                <option value="CASADO">CASADO</option>
                <option value="UNION LIBRE">UNION LIBRE</option>
                <option value="DIVORCIADO">DIVORCIADO</option>
                <option value="VIUDO">VIUDO</option>
            </select>
        </div>
        <div class="form-group">
            <label for="peso">Peso:</label>
            <input type="number" step="0.01" name="peso" id="peso" class="form-control" placeholder="Tu Peso" min="0" max="999">
        </div>
        <div class="form-group">
            <label for="estatura">Estatura:</label>
            <input type="number" step="0.01" name="estatura" id="estatura" class="form-control" placeholder="Tu Estatura" min="0" max="999">
        </div>
        <br>
        <button type="submit" id="submitButton" class="btn btn-primary" disabled>Guardar</button>
    </form>
</div>

<!-- Add Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
