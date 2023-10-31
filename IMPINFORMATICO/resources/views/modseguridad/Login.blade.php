<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IMPINFORMATICO| Iniciar sesión</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
  <!-- Enlazar el CSS de Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">

<!-- Mensaje de credenciales inválidas -->
@if(session()->has('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
    {{ session()->forget('error') }} <!-- Elimina la sesión flash 'error' -->
  @endif

  <!-- Mensaje de usuario bloqueado -->
  @if(session()->has('blocked'))
    <div class="alert alert-danger">
      {{ session('blocked') }}
    </div>
    {{ session()->forget('blocked') }} <!-- Elimina la sesión flash 'blocked' -->
  @endif

  <div class="login-logo">
    <a href="../../index2.html"><b>IMPERIO </b>INFORMATICO </a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Inicio de Sesión</p>
      <div id="errorMessage" class="alert alert-danger" style="display: none;">
        Por favor, completa todos los campos.
      </div>
      <form action="{{ route('ModuloSeguridad.entrar') }}" method="post" class="needs-validation" novalidate onsubmit="return validateForm()">
        @csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Usuario" name="usuario" id="usuario" maxlength="20" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Contraseña" name="contrasena" id="contrasena" maxlength="12" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
              <i class="fa fa-eye-slash" aria-hidden="true"></i>
            </button>
          </div>
        </div>
        <p class="mb-1">
        <a href="{{route('ModuloSeguridad.reMenu')}}">¿Olvidaste tu contraseña?</a>
      </p>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <p class="mb-0">
        <a href="{{route('ModuloSeguridad.Registro')}}" class="text-center">Nuevo usuario</a>
      </p>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const togglePassword = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#contrasena');
    const usuarioInput = document.querySelector('input[name="usuario"]');
    const contrasenaInput = document.querySelector('input[name="contrasena"]');

    togglePassword.addEventListener('click', function () {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);

      // Cambiar el icono del botón
      togglePassword.innerHTML = type === 'password' ? '<i class="fa fa-eye-slash" aria-hidden="true"></i>' : '<i class="fa fa-eye" aria-hidden="true"></i>';
    });

    usuarioInput.addEventListener("input", function() {
      this.value = this.value.toUpperCase(); // Convertir a mayúsculas
      this.value = this.value.replace(/\s/g, ""); // Eliminar espacios en blanco
    });

    contrasenaInput.addEventListener("input", function() {
      this.value = this.value.replace(/\s/g, ""); // Eliminar espacios en blanco
    });
  });

  function validateForm() {
    const usuario = document.getElementById("usuario").value;
    const contrasena = document.getElementById("contrasena").value;
    const errorMessage = document.getElementById("errorMessage");

    if (usuario.trim() === "" || contrasena.trim() === "") {
      errorMessage.style.display = "block";
      return false;
    }

    errorMessage.style.display = "none";
    return true;
  }
</script>
</body>
</html>
