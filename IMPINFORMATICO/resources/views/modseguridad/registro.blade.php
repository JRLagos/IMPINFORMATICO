<!DOCTYPE html>
<html>
<head>
    <title>Crea una Cuenta</title>
    <!-- Enlazar el CSS proporcionado en la etiqueta <link> -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/registro.css') }}">
</head>
<body>
    <div class="contenedor">
        <h1>Crear Cuenta</h1>
        <form action=" {{ route('ModuloSeguridad.enviar') }}" method="post">
            @csrf <!-- Token CSRF de Laravel para protección contra ataques Cross-Site Request Forgery -->
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" placeholder="Tu Nombre">
            </div>
            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" name="apellido" id="apellido" placeholder="Tu Apellido">
            </div>
            <!-- Agregar nuevos campos -->
            <div class="form-group">
                <label for="correo">Correo Electrónico:</label>
                <input type="email" name="correo" id="correo" required placeholder="Tu Correo Electrónico">
            </div>
            <div class="form-group">
                <label for="contrasenia">Contraseña:</label>
                <input type="password" name="contrasenia" id="contrasenia" required placeholder="Tu Contraseña">
            </div>
            <div class="form-group">
                <label for="usuario">Nombre de Usuario:</label>
                <input type="text" name="usuario" id="usuario" required placeholder="Tu Nombre de Usuario">
            </div>
            <div class="form-group">
                <label for="dni">DNI:</label>
                <input type="text" name="dni" id="dni" required placeholder="Tu DNI">
            </div>
            <div class="form-group">
                <label for="rtn">RTN:</label>
                <input type="text" name="rtn" id="rtn" placeholder="Tu RTN">
            </div>
            <div class="form-group">
                <label for="tipo_telefono">Tipo de Teléfono:</label>
                <select name="tipo_telefono" id="tipo_telefono">
                    <option value="FIJO">FIJO</option>
                    <option value="CELULAR">CELULAR</option>
                </select>
            </div>
            <div class="form-group">
                <label for="numero_telefono">Número de Teléfono:</label>
                <input type="text" name="numero_telefono" id="numero_telefono" placeholder="Tu Número de Teléfono">
            </div>
            <div class="form-group">
                <label for="sexo">Sexo:</label>
                <select name="sexo" id="sexo">
                    <option value="MASCULINO">MASCULINO</option>
                    <option value="FEMENINO">FEMENINO</option>
                </select>
            </div>
            <div class="form-group">
                <label for="edad">Edad:</label>
                <input type="number" name="edad" id="edad" placeholder="Tu Edad">
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="Tu Fecha de Nacimiento">
            </div>
            <div class="form-group">
                <label for="lugar_nacimiento">Lugar de Nacimiento:</label>
                <input type="text" name="lugar_nacimiento" id="lugar_nacimiento" placeholder="Tu Lugar de Nacimiento">
            </div>
            <div class="form-group">
                <label for="estado_civil">Estado Civil:</label>
                <select name="estado_civil" id="estado_civil">
                    <option value="SOLTERO">SOLTERO</option>
                    <option value="CASADO">CASADO</option>
                    <option value="UNION LIBRE">UNION LIBRE</option>
                    <option value="DIVORCIADO">DIVORCIADO</option>
                    <option value="VIUDO">VIUDO</option>
                </select>
            </div>
            <div class="form-group">
                <label for="peso">Peso:</label>
                <input type="number" step="0.01" name="peso" id="peso" placeholder="Tu Peso">
            </div>
            <div class="form-group">
                <label for="estatura">Estatura:</label>
                <input type="number" step="0.01" name="estatura" id="estatura" placeholder="Tu Estatura">
            </div>
            <br>
            <button type="submit">Guardar</button>
        </form>
    </div>
</body>
</html>
