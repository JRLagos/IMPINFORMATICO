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
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>IMPERIO </b>INFORMATICO® </a>
  </div>
        <div class="alert alert-danger" role="alert">
            <strong>Error en el inicio de sesión. Usuario Bloqueado</strong>
        </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Inicia sesión para comenzar tu sesión</p>
      <form action="{{ route('ModuloSeguridad.entrar') }}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Usuario" name="usuario" maxlength="20">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Contraseña" name="contrasena" id="contrasena" maxlength="12">
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
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
          </div>
          <!-- /.col -->
        </div>
        
      </form>
      <p class="mb-1">
        <a href="{{route('ModuloSeguridad.Preguntas')}}">¿Olvidaste tu contraseña?</a>
      </p>
      <p class="mb-0">
        <a href="{{route('ModuloSeguridad.Registro')}}" class="text-center">Registrarme como nuevo usuario</a>
      </p>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
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
</script>
</body>
</html>