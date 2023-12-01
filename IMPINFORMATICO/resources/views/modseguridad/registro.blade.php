<!DOCTYPE html>
<html>
<head>
    <title>Crea una Cuenta</title>
    <!-- Link Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Enlazar el CSS proporcionado en la etiqueta <link> -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/registro.css') }}">
    <style>
        .is-valid {
            border-color: #28a745; /* Cambia el color del borde a verde */
        }
    </style>
</head>
<body>
<!-- Mensaje de credenciales inválidas -->
@if (isset($userExistsError) && $userExistsError)
    <div class="alert alert-danger">
        El usuario ya existe. Por favor, elige otro nombre de usuario.
    </div>
@endif
<div class="contenedor">
        <h1>Crear Cuenta</h1>
        <form id="registroForm" action="{{ route('ModuloSeguridad.enviar') }}" method="post">
            @csrf
            <!-- Token CSRF de Laravel para protección contra ataques Cross-Site Request Forgery -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control is-invalid" placeholder="Tu Nombre" maxlength="20" required pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+">
                        <div class="invalid-feedback">
                            Este campo es requerido.
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="apellido">Apellido:</label>
                        <input type="text" name="apellido" id="apellido" class="form-control is-invalid" placeholder="Tu Apellido" maxlength="20" required>
                        <div class="invalid-feedback">
                            Este campo es requerido.
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="correo">Correo Electrónico:</label>
                        <input type="email" name="correo" id="correo" class="form-control is-invalid" required placeholder="Tu Correo Electrónico" maxlength="30">
                        <div class="invalid-feedback">
                            Este campo es requerido.
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="usuario">Usuario:</label>
                        <input type="text" name="usuario" id="usuario" class="form-control is-invalid" required placeholder="Tu Nombre de Usuario" maxlength="20">
                        <div class="invalid-feedback">
                            Este campo es requerido.
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="contrasenia">Contraseña:</label>
                        <div class="input-group">
                            <input type="password" name="contrasenia" id="contrasenia" class="form-control is-invalid" required placeholder="Tu Contraseña" minlength="5" maxlength="12">
                            <div class="input-group-append">
                                <button type="button" id="verContraseniaBtn" class="btn btn-outline-secondary">Ver</button>
                            </div>
                        </div>
                        <span id="passwordRequirements" class="text-danger d-none">
                            La contraseña debe contener al menos una mayúscula, un número y un carácter especial.
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sexo">Sexo:</label>
                        <select name="sexo" id="sexo" class="form-control is-invalid">
                            <option value="MASCULINO">MASCULINO</option>
                            <option value="FEMENINO">FEMENINO</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="rol">Rol:</label>
                        <select name="rol" id="rol" class="form-control is-invalid">
                            <option value="3">SUPER_USUARIO</option>
                            <option value="2">USUARIO_REGULAR</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control is-invalid" placeholder="Tu Fecha de Nacimiento">
                    </div>
                </div>
            </div>
            <br>
            <div class="row justify-content-center">
                <button type="submit" id="submitButton" class="btn btn-primary is-invalid" disabled>Guardar</button>
            </div>
        </form>
    </div>

<!-- Add Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- ... tu código HTML ... -->

<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("registroForm");
    const submitButton = document.getElementById("submitButton");
    const nombreInput = document.getElementById("nombre");
    const apellidoInput = document.getElementById("apellido");
    const correoInput = document.getElementById("correo");
    const usuarioInput = document.getElementById("usuario");
    const dniInput = document.getElementById("dni");
    const rtnInput = document.getElementById("rtn");
    const telefonoInput = document.getElementById("numero_telefono");
    const edadInput = document.getElementById("edad");
    const fechaNacimientoInput = document.getElementById("fecha_nacimiento");
    const lugarNacimientoInput = document.getElementById("lugar_nacimiento");
    const pesoInput = document.getElementById("peso");
    const estaturaInput = document.getElementById("estatura");
    const contraseniaInput = document.getElementById("contrasenia");
    const verContraseniaBtn = document.getElementById("verContraseniaBtn");

    verContraseniaBtn.addEventListener("click", function () {
        if (contraseniaInput.type === "password") {
            contraseniaInput.type = "text";
            verContraseniaBtn.textContent = "Ocultar";
        } else {
            contraseniaInput.type = "password";
            verContraseniaBtn.textContent = "Ver";
        }
    });

    contraseniaInput.addEventListener("input", function () {
        const password = this.value;

        // Elimina espacios en blanco de la contraseña
        const passwordWithoutSpaces = password.replace(/\s/g, '');

        // Verifica si la contraseña cumple con los requisitos
        const isValidPassword = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$])[a-zA-Z0-9!@#\$]+$/.test(passwordWithoutSpaces);

        // Actualiza el valor del campo de contraseña sin espacios
        this.value = passwordWithoutSpaces;

        // Actualiza el estado de la contraseña y muestra/oculta el mensaje de requisitos
        this.classList.toggle("is-invalid", !isValidPassword);
        passwordRequirements.classList.toggle("d-none", isValidPassword);

        // Verifica si el formulario es válido
        const isValid = form.checkValidity();
        submitButton.disabled = !isValid;
    });

    contraseniaInput.addEventListener("input", function () {
        // Obtener el valor del campo de contraseña
        const password = this.value;

        // Expresiones regulares para verificar mayúsculas, minúsculas, números y caracteres especiales
        const upperCaseRegex = /[A-Z]/;
        const lowerCaseRegex = /[a-z]/;
        const numberRegex = /[0-9]/;
        const specialCharRegex = /[!@#\$]/;

        // Verificar si el campo de contraseña cumple con los requisitos
        const hasUpperCase = upperCaseRegex.test(password);
        const hasLowerCase = lowerCaseRegex.test(password);
        const hasNumber = numberRegex.test(password);
        const hasSpecialChar = specialCharRegex.test(password);

        let message = "La contraseña debe contener: ";

        if (!hasUpperCase) {
            message += "al menos una mayúscula, ";
        }
        if (!hasLowerCase) {
            message += "al menos una minúscula, ";
        }
        if (!hasNumber) {
            message += "al menos un número, ";
        }
        if (!hasSpecialChar) {
            message += "al menos un carácter especial, ";
        }

        if (!hasUpperCase || !hasLowerCase || !hasNumber || !hasSpecialChar) {
            message = message.slice(0, -2); // Elimina la última coma y espacio
            passwordRequirements.textContent = message;
            passwordRequirements.classList.remove("d-none");
        } else {
            passwordRequirements.classList.add("d-none");
        }

        // Verificar si el formulario es válido
        const isValid = form.checkValidity();
        submitButton.disabled = !isValid;
    });

    contraseniaInput.addEventListener("input", function () {
        // Obtener el valor del campo de contraseña
        const password = this.value;

        // Expresiones regulares para verificar mayúsculas, números y caracteres especiales
        const upperCaseRegex = /[A-Z]/;
        const numberRegex = /[0-9]/;
        const specialCharRegex = /[!@#\$]/;

        // Verificar si el campo de contraseña cumple con los requisitos
        const hasUpperCase = upperCaseRegex.test(password);
        const hasNumber = numberRegex.test(password);
        const hasSpecialChar = specialCharRegex.test(password);

        // Mostrar el mensaje de requisitos
        passwordRequirements.classList.toggle("d-none", hasUpperCase && hasNumber && hasSpecialChar);

        // Verificar si el formulario es válido
        const isValid = form.checkValidity();
        submitButton.disabled = !isValid;
    });

    contraseniaInput.addEventListener("input", function () {
    // Obtener el valor del campo de contraseña
    const password = this.value;

    // Expresiones regulares para verificar mayúsculas, números y caracteres especiales
    const upperCaseRegex = /[A-Z]/;
    const numberRegex = /[0-9]/;
    const specialCharRegex = /[!@#\$]/;

    // Verificar si el campo de contraseña cumple con los requisitos
    let isValid = true;
    let missingChars = [];

    if (!upperCaseRegex.test(password)) {
        isValid = false;
        missingChars.push("mayúscula");
    }
    if (!numberRegex.test(password)) {
        isValid = false;
        missingChars.push("número");
    }
    if (!specialCharRegex.test(password)) {
        isValid = false;
        missingChars.push("carácter especial");
    }

    // Mostrar un mensaje al usuario con lo que falta por agregar a la contraseña
    if (!isValid) {
        this.setCustomValidity("La contraseña debe contener al menos una " + missingChars.join(", ") + ".");
        this.classList.add("is-invalid");
    } else {
        this.setCustomValidity("");
        this.classList.remove("is-invalid");
    }
});

    fechaNacimientoInput.addEventListener("input", function () {
    const selectedDate = new Date(this.value);
    const currentDate = new Date();
    currentDate.setHours(0, 0, 0, 0);

    // Calcula la diferencia de años entre la fecha seleccionada y la fecha actual
    const ageDifference = currentDate.getFullYear() - selectedDate.getFullYear();

    // Imprime el valor de ageDifference en la consola
    

    // Comprueba si la fecha seleccionada hace que el usuario tenga menos de 18 años
    if (ageDifference < 18) {
        this.setCustomValidity("Debes ser mayor de 18 años.");
        this.classList.add("is-invalid");
    } else {
        this.setCustomValidity("");
        this.classList.remove("is-invalid");
    }
});


    form.addEventListener("input", function () {
        let isValid = true;
        form.querySelectorAll(".form-control").forEach(function (input) {
            if (!input.checkValidity() || input.value.trim() === "") {
                isValid = false;
                input.classList.add("is-invalid");
                input.classList.remove("is-valid");
            } else {
                input.classList.remove("is-invalid");
                input.classList.add("is-valid");
            }
        });

        if (isValid) {
            submitButton.removeAttribute("disabled");
            submitButton.classList.remove("btn-primary");
            submitButton.classList.add("btn-success");
        } else {
            submitButton.setAttribute("disabled", "disabled");
            submitButton.classList.remove("btn-success");
            submitButton.classList.add("btn-primary");
        }
    });

    nombreInput.addEventListener("input", function () {
        this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]/g, "");
        this.value = this.value.replace(/[0-9]/g, "");
        this.value = this.value.replace(/\s{2,}/g, " ");
    });

    apellidoInput.addEventListener("input", function () {
        this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]/g, "");
        this.value = this.value.replace(/[0-9]/g, "");
        this.value = this.value.replace(/\s{2,}/g, " ");
    });

    correoInput.addEventListener("input", function () {
    this.value = this.value.replace(/[^a-zA-Z0-9@._]/g, "");
    this.value = this.value.replace(/\s/g, "");
});

    usuarioInput.addEventListener("input", function () {
        this.value = this.value.replace(/[^a-zA-Z0-9]/g, "");
        this.value = this.value.replace(/\s/g, "");
    });

    dniInput.addEventListener("input", function () {
        this.value = this.value.replace(/[^0-9]/g, "");
    });

    rtnInput.addEventListener("input", function () {
        this.value = this.value.replace(/[^0-9]/g, "");
    });

    telefonoInput.addEventListener("input", function () {
        this.value = this.value.replace(/[^0-9]/g, "");
    });

    edadInput.addEventListener("input", function () {
        this.value = this.value.replace(/[^0-9]/g, "");
    });

    fechaNacimientoInput.addEventListener("input", function () {
        const selectedDate = new Date(this.value);
        const currentDate = new Date();

        currentDate.setHours(0, 0, 0, 0);

        if (selectedDate > currentDate) {
            this.value = currentDate.toISOString().split("T")[0];
        }
    });

    lugarNacimientoInput.addEventListener("input", function () {
        this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]/g, "");
        this.value = this.value.replace(/\s{2,}/g, " ");
    });

    pesoInput.addEventListener("input", function () {
        this.value = this.value.replace(/[^0-9]/g, "");
    });

    estaturaInput.addEventListener("input", function () {
        this.value = this.value.replace(/[^0-9.]/g, "");
        this.value = this.value.replace(/^\./, "");
        this.value = this.value.replace(/\.{2,}/g, ".");
        this.value = this.value.replace(/^0{2,}/g, "0");
        this.value = this.value.replace(/^0+(\d)/, "$1");
    });

    contraseniaInput.addEventListener("input", function () {
        this.value = this.value.replace(/[^a-zA-Z0-9!@#\$]/g, "");
        this.value = this.value.replace(/\s/g, "");
    });

    fechaNacimientoInput.addEventListener("input", function () {
    const selectedDate = new Date(this.value);
    const currentDate = new Date();

    currentDate.setHours(0, 0, 0, 0);

    if (selectedDate > currentDate) {
        this.value = currentDate.toISOString().split("T")[0];
    }
 
});
});
</script>



</body>
</html>

