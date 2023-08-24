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
                <input type="text" name="nombre" id="nombre" placeholder="Tu Nombre" maxlength="15" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" name="apellido" id="apellido" placeholder="Tu Apellido" maxlength="15" required>
            </div>
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
                <input type="text" name="usuario" id="usuario" required placeholder="Tu Nombre de Usuario" maxlength="20">
            </div>
            <div class="form-group">
                <label for="dni">DNI:</label>
                <input type="text" name="dni" id="dni" required placeholder="Tu DNI" maxlength="20">
            </div>
            <div class="form-group">
                <label for="rtn">RTN:</label>
                <input type="text" name="rtn" id="rtn" placeholder="Tu RTN" maxlength="20">
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
                <input type="text" name="lugar_nacimiento" id="lugar_nacimiento" placeholder="Tu Lugar de Nacimiento"  maxlength="50">
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
            <button type="submit" id="submitButton" disabled>Guardar</button>
        </form>
    </div>


    <!-- Scripts de Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    document.getElementById('usuario').addEventListener('input', function(event) {
        var input = event.target;
        input.value = input.value.toUpperCase();
    });


    document.addEventListener('DOMContentLoaded', function() {
        var fechaNacimientoInput = document.getElementById('fecha_nacimiento');
        
        // Obtener la fecha actual en formato yyyy-mm-dd
        var today = new Date().toISOString().split('T')[0];
        
        // Establecer el atributo max del campo de fecha
        fechaNacimientoInput.setAttribute('max', today);

        // Agregar un listener para el evento "input"
        fechaNacimientoInput.addEventListener('input', function() {
            // Obtener el valor seleccionado en el campo de fecha
            var selectedDate = new Date(this.value);
            
            // Comparar la fecha seleccionada con la fecha actual
            if (selectedDate > new Date()) {
                this.setCustomValidity('La fecha no puede ser en el futuro');
            } else {
                this.setCustomValidity('');
            }
        });
    });

    document.getElementById('usuario').addEventListener('input', function(event) {
    var input = event.target;
    input.value = input.value.toUpperCase();
});

document.addEventListener('DOMContentLoaded', function() {
    var fechaNacimientoInput = document.getElementById('fecha_nacimiento');
    
    // Obtener la fecha actual en formato yyyy-mm-dd
    var today = new Date().toISOString().split('T')[0];
    
    // Establecer el atributo max del campo de fecha
    fechaNacimientoInput.setAttribute('max', today);

    // Agregar un listener para el evento "input"
    fechaNacimientoInput.addEventListener('input', function() {
        // Obtener el valor seleccionado en el campo de fecha
        var selectedDate = new Date(this.value);
        
        // Comparar la fecha seleccionada con la fecha actual
        if (selectedDate > new Date()) {
            this.setCustomValidity('La fecha no puede ser en el futuro');
        } else {
            this.setCustomValidity('');
        }
    });
    
    // Validación de correo electrónico en tiempo real
    var correoInput = document.getElementById('correo');
    var correoError = document.getElementById('correoError');
    
    correoInput.addEventListener('input', function() {
        var correoValue = correoInput.value;
        if (!isValidEmail(correoValue)) {
            correoError.textContent = 'El formato del correo electrónico no es válido.';
        } else {
            correoError.textContent = '';
        }
    });
    
    // Validación de número de teléfono en tiempo real
    var numeroTelefonoInput = document.getElementById('numero_telefono');
    
    numeroTelefonoInput.addEventListener('input', function() {
        var numeroTelefonoValue = numeroTelefonoInput.value;
        if (!isValidPhoneNumber(numeroTelefonoValue)) {
            numeroTelefonoInput.setCustomValidity('El número de teléfono no es válido.');
        } else {
            numeroTelefonoInput.setCustomValidity('');
        }
    });
    
    function isValidEmail(email) {
        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        return emailPattern.test(email);
    }
    
    function isValidPhoneNumber(phoneNumber) {
        var phonePattern = /^\d{7,15}$/;
        return phonePattern.test(phoneNumber);
    }
});


   // Habilitar el botón de enviar cuando todos los campos obligatorios estén llenos
   document.addEventListener('input', function() {
            var allFieldsFilled = areAllFieldsFilled();
            var submitButton = document.getElementById('submitButton');
            submitButton.disabled = !allFieldsFilled;
        });
        
        function areAllFieldsFilled() {
            var requiredFields = document.querySelectorAll('[required]');
            for (var i = 0; i < requiredFields.length; i++) {
                if (!requiredFields[i].value) {
                    return false;
                }
            }
            return true;
        }

        


    </script>

</body>
</html>
