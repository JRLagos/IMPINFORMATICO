@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<link rel="icon" type="image/x-icon" href="{{ asset('favicon1.ico') }}" />


@php
    $usuario = session('credenciales');
    $usuarioRol = session('nombreRol');
    $Permisos = session('permisos');
    $Objetos = session('objetos');

    // Verificar si alguna de las sesiones está vacía
    if ($usuario === null || $usuarioRol === null || $Permisos === null || $Objetos === null) {
        // Redirigir al usuario al inicio de sesión o a donde corresponda
        return redirect()->route('Login');
    }

    // Filtrar los objetos con "NOM_OBJETO" igual a "VACACIONES"
    $objetosFiltrados = array_filter($Objetos, function($objeto) {
        return isset($objeto['NOM_OBJETO']) && $objeto['NOM_OBJETO'] === 'PERSONAS';
    });

    // Filtrar los permisos de seguridad
    $permisosFiltrados = array_filter($Permisos, function($permiso) use ($usuario, $objetosFiltrados) {
        return (
            isset($permiso['COD_ROL']) && $permiso['COD_ROL'] === $usuario['COD_ROL'] &&
            isset($permiso['COD_OBJETO']) && in_array($permiso['COD_OBJETO'], array_column($objetosFiltrados, 'COD_OBJETO'))
        );
    });

    $rolJson = json_encode($usuarioRol, JSON_PRETTY_PRINT);
    $credencialesJson = json_encode($usuario, JSON_PRETTY_PRINT);
    $credencialesObjetos = json_encode($objetosFiltrados, JSON_PRETTY_PRINT);
    $permisosJson = json_encode($permisosFiltrados, JSON_PRETTY_PRINT);
@endphp


    @php
        function tienePermiso($permisos, $permisoBuscado) {
        foreach ($permisos as $permiso) {
        if (isset($permiso[$permisoBuscado]) && $permiso[$permisoBuscado] === "1") {
            return true; // El usuario tiene el permiso
             }
          }
        return false; // El usuario no tiene el permiso
        }
    @endphp   
     
    <h1><b>IMPERIO INFORMATICO</b></h1>
@stop

@section('content')
    <h5><b>Bienvenido al Sistema Nomina IMP_INFORMATICO</b></h5>
    <br>
<div class="d-grid gap-2 d-md-flex justify-content-between align-items-center">

<div class="info-box">
  <span class="info-box-icon bg-cyan"><i class="fa fa-user-check"></i></span>
  <div class="info-box-content ">
    <span class="info-box-text"><h5><b>Usuarios</b></h5   ></span>
  </div>
</div>

<div class="info-box">
  <span class="info-box-icon bg-warning"><i class="fa fa-user-check"></i></span>
  <div class="info-box-content ">
    <span class="info-box-text"><h5><b>Empleados</b></h5   ></span>
  </div>
</div>

<div class="info-box">
    
  <span class="info-box-icon bg-cyan"><i class="fa fa-store-alt"></i></span>
  <div class="info-box-content">
    <span class="info-box-text"><h5><b>Sucursales</b></h5   ></span>
  </div>
</div>

</div>

<br>
<div class="d-grid gap-2 d-md-flex justify-content-between align-items-center">

<div class="info-box">
  <span class="info-box-icon bg-warning"><i class="fa fa-clipboard-list"></i></span>
  <div class="info-box-content">
    <span class="info-box-text"><h5><b>Empleado por Contratos</b></h5   ></span>
  </div>
</div>

<div class="info-box"> 
  <span class="info-box-icon bg-cyan"><i class="fa fa-code-branch"></i></span>
  <div class="info-box-content">
    <span class="info-box-text"><h5><b>Empleado por Departamento</b></h5   ></span>
  </div>
</div>

<div class="info-box">
    
  <span class="info-box-icon bg-warning"><i class="fa fa-user-friends"></i></span>
  <div class="info-box-content ">
    <span class="info-box-text"><h5><b>Empleado por Genero</b></h5   ></span>
  </div>
</div>
</div>
<div class="d-grid gap-2 d-md-flex justify-content-between align-items-center">
<div class="info-box">
  <span class="info-box-icon bg-cyan"><i class="fa fa-store-alt"></i></span>
  <div class="info-box-content">
    <span class="info-box-text"><h5><b>Empleado por Sucursal</b></h5   ></span>
  </div>
</div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

@section('footer')

<div class="float-right d-none d-sm-block">
  <b>Version</b> 3.1.0
</div>
<strong>Copyright &copy; 2023 <a href="">IMPERIO INFORMATICO</a>.</strong> All rights reserved.

@stop