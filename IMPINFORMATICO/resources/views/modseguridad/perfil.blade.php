@extends('adminlte::page')

@section('title', 'Perfil')

@section('content_header')
    <h1><b>Editar Perfil</h1></b>
@stop

@php
    $usuario = session('credenciales');  
@endphp



@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-up" style="height: 100vh;">
            <div class="col-md-6">
                <div class="card shadow-lg"> 
                    <div class="card-header bg-primary text-white"> <!-- Cambiamos el fondo y color del encabezado -->
                        <h3 class="card-title">Información de Usuario</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('ContraPerfil.index') }}" method="get">
                            @csrf
                            @if (!empty($usuario))
                                <div class="form-group">
                                    <label for="nombre_usuario">Nombre de Usuario</label>
                                    <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" value="{{ $usuario['NOM_USUARIO'] }}">
                                </div>
                                <div class="form-group">
                                    <label for="rol">Rol</label>
                                    <input type="text" class="form-control" id="rol" name="rol"  value="{{ $usuario['NOM_ROL'] }}">
                                </div>
                                <div class="form-group">
                                    <label for="rol">Correo</label>
                                    <input type="text" class="form-control" id="corre" name="correo"  value="{{ $usuario['EMAIL'] }}">
                                </div>
                            @else
                                <p>No se ha encontrado un nombre de usuario.</p>
                            @endif
                            <div class="form-group">
                                <label for="contrasena">Cambiar contraseña</label>
                                <input type="password" class="form-control" id="contrasena" name="CONTRASENA" placeholder="Ingrese su contraseña">
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary"><b>GUARDAR</b></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop


@section('footer')
    <!-- Contenido del pie de página, si es necesario -->
@stop
