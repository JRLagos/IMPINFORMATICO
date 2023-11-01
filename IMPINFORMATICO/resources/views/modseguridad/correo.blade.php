<!DOCTYPE html>
<html>
<head>
    <title>Enviar Contraseña por Correo</title>
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/correo.css') }}">
    <style>
        .input-uppercase {
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Enviar Contraseña por Correo</h1>

        <!-- Mensaje de éxito -->
        @if (Session::has('info'))
            <div class="alert alert-custom">
                <p class="text-center">{{ Session::get('info') }}</p>
            </div>
            {{ session()->forget('info') }} <!-- Elimina la sesión flash 'info' -->
        @endif

        <!-- Mensaje de error -->
        @if(session()->has('error'))
            <div class="alert alert-custom">
                <p class="text-center">
                    {{ session('error') }}
                </p>
            </div>
            {{ session()->forget('error') }} <!-- Elimina la sesión flash 'error' -->
        @endif

        <form action="{{ route('ModuloSeguridad.emailEnviarCon') }}" method="get">
            @csrf
            <label for="usuario" class="label-left">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required class="input-uppercase" maxlength="20" minlength="3">
            <button type="submit" class="btn-enviar">Enviar Contraseña por Correo</button>
        </form>
    </div>
</body>
</html>
