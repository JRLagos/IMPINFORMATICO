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
        <form id="registroForm" action="{{ route('ModuloSeguridad.enviar') }}" method="post">
            @csrf <!-- Token CSRF de Laravel para protección contra ataques Cross-Site Request Forgery -->
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" placeholder="Tu Nombre" oninput="this.value = this.value.toUpperCase()" maxlength="15">
            </div>
            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" name="apellido" id="apellido" placeholder="Tu Apellido" oninput="this.value = this.value.toUpperCase()" maxlength="15">
            </div>
            <!-- Agregar nuevas restricciones de longitud -->
            <div class="form-group">
                <label for="correo">Correo Electrónico:</label>
                <input type="email" name="correo" id="correo" required placeholder="Tu Correo Electrónico" maxlength="100">
                <p id="correoError" style="color: red;"></p>
            </div>
            <div class="form-group">
                <label for="contrasenia">Contraseña:</label>
                <input type="password" name="contrasenia" id="contrasenia" required placeholder="Tu Contraseña" maxlength="12">
            </div>
            <div class="form-group">
                <label for="usuario">Nombre de Usuario:</label>
                <input type="text" name="usuario" id="usuario" required placeholder="Tu Nombre de Usuario" oninput="this.value = this.value.toUpperCase()" maxlength="20">
            </div>
            <div class="form-group">
                <label for="dni">DNI:</label>
                <input type="text" name="dni" id="dni" required placeholder="Tu DNI" oninput="this.value = this.value.toUpperCase()" maxlength="20">
            </div>
            <div class="form-group">
                <label for="rtn">RTN:</label>
                <input type="text" name="rtn" id="rtn" placeholder="Tu RTN" oninput="this.value = this.value.toUpperCase()" maxlength="20">
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
                <input type="text" name="numero_telefono" id="numero_telefono" placeholder="Tu Número de Teléfono" maxlength="15">
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
                <input type="number" name="edad" id="edad" placeholder="Tu Edad" min="5" max="18">
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="Tu Fecha de Nacimiento">
            </div>
            <div class="form-group">
                <label for="lugar_nacimiento">Lugar de Nacimiento:</label>
                <input type="text" name="lugar_nacimiento" id="lugar_nacimiento" placeholder="Tu Lugar de Nacimiento" oninput="this.value = this.value.toUpperCase()" maxlength="50">
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
                <input type="number" step="0.01" name="peso" id="peso" placeholder="Tu Peso" min="0" max="999">
            </div>
            <div class="form-group">
                <label for="estatura">Estatura:</label>
                <input type="number" step="0.01" name="estatura" id="estatura" placeholder="Tu Estatura" min="0" max="999">
            </div>
            <br>
            <button type="submit">Guardar</button>
        </form>
    </div>

    <script>
    // Función para validar caracteres permitidos en un campo
    function validarCaracteres(campo, soloNumeros) {
        var regex;
        if (soloNumeros) {
            regex = /^[0-9]+$/;
        } else {
            regex = /^[A-Za-z\s]+$/;
        }
        return regex.test(campo);
    }

    // Validación de campos al enviar el formulario
    document.getElementById('registroForm').addEventListener('submit', function(event) {
        var campos = [
            { id: 'nombre', soloNumeros: false, limite: 15 },
            { id: 'apellido', soloNumeros: false, limite: 15 },
            { id: 'contrasenia', soloNumeros: false, limite: 12 },
            { id: 'usuario', soloNumeros: false, limite: 20 }
            // Agrega aquí más campos con su respectiva configuración
        ];

        var validacionCorrecta = true;

        campos.forEach(function(campo) {
            var inputCampo = document.getElementById(campo.id);
            var valorCampo = inputCampo.value;

            if (valorCampo.length > campo.limite) {
                alert('El campo ' + campo.id + ' no debe exceder los ' + campo.limite + ' caracteres.');
                event.preventDefault();
                validacionCorrecta = false;
                return;
            }

            if (!validarCaracteres(valorCampo, campo.soloNumeros)) {
                alert('El campo ' + campo.id + ' contiene caracteres no permitidos.');
                event.preventDefault();
                validacionCorrecta = false;
                return;
            }
        });

        if (validacionCorrecta) {
            // Si todas las validaciones pasan, el formulario se enviará normalmente
        }
    });

    // Validación de correo electrónico
    document.getElementById('registroForm').addEventListener('submit', function(event) {
        var correo = document.getElementById('correo').value;
        if (correo === '') {
            alert('Por favor ingresa tu correo electrónico');
            event.preventDefault();
            return;
        }

        if (!validarCorreo(correo)) {
            event.preventDefault();
            document.getElementById('correoError').textContent = 'Correo electrónico inválido';
            return;
        }
    });

    // Función para validar el formato del correo electrónico
    function validarCorreo(correo) {
        var regexCorreo = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        return regexCorreo.test(correo);
    }

    // Resto del script...
</script>



</body>
</html>
  