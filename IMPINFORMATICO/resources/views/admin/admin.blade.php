@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<link rel="icon" type="image/x-icon" href="{{ asset('favicon1.ico') }}" />
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
    @foreach ($ResulTotalUsuario as $TotalUsuario)
    <span class="info-box-number">Total: {{ $TotalUsuario['TOTAL_USUARIOS'] }}</span>
    @endforeach
  </div>
</div>

<div class="info-box">
  <span class="info-box-icon bg-warning"><i class="fa fa-user-check"></i></span>
  <div class="info-box-content ">
    <span class="info-box-text"><h5><b>Empleados</b></h5   ></span>
    @foreach ($ResulTotalEmpleado as $TotalEmpleado)
    <span class="info-box-number">Total: {{ $TotalEmpleado['TOTAL_EMPLEADOS'] }}</span>
    @endforeach
  </div>
</div>

<div class="info-box">
    
  <span class="info-box-icon bg-cyan"><i class="fa fa-store-alt"></i></span>
  <div class="info-box-content">
    <span class="info-box-text"><h5><b>Sucursales</b></h5   ></span>
    @foreach ($ResulTotalSucursal as $TotalSucursal)
    <span class="info-box-number">Total: {{ $TotalSucursal['TOTAL_SUCURSALES'] }}</span>
    @endforeach
  </div>
</div>

</div>

<br>
<div class="d-grid gap-2 d-md-flex justify-content-between align-items-center">

<div class="info-box">
  <span class="info-box-icon bg-warning"><i class="fa fa-clipboard-list"></i></span>
  <div class="info-box-content">
    <span class="info-box-text"><h5><b>Empleado por Contratos</b></h5   ></span>
    @foreach ($ResulContrato as $Contrato)
    <span class="info-box-number">{{ $Contrato['TIP_CONTRATO'] }} : {{ $Contrato['CANTIDAD_GENERO_EMPLEADOS'] }}</span>
    @endforeach
  </div>
</div>

<div class="info-box"> 
  <span class="info-box-icon bg-cyan"><i class="fa fa-code-branch"></i></span>
  <div class="info-box-content">
    <span class="info-box-text"><h5><b>Empleado por Departamento</b></h5   ></span>
    @foreach ($ResulUsuario as $Usuario)
    <span class="info-box-number">{{ $Usuario['NOM_DEPTO_EMPRESA'] }} : {{ $Usuario['TOTAL_EMPLEADOS_DEPTOE'] }}</span>
    @endforeach
  </div>
</div>

<div class="info-box">
    
  <span class="info-box-icon bg-warning"><i class="fa fa-user-friends"></i></span>
  <div class="info-box-content ">
    <span class="info-box-text"><h5><b>Empleado por Genero</b></h5   ></span>
    @foreach ($ResulGenero as $Genero)
    <span class="info-box-number">{{ $Genero['SEX_PERSONA'] }} : {{ $Genero['CANTIDAD_GENERO_EMPLEADOS'] }}</span>
    @endforeach
  </div>
</div>
</div>
<div class="d-grid gap-2 d-md-flex justify-content-between align-items-center">
<div class="info-box">
  <span class="info-box-icon bg-cyan"><i class="fa fa-store-alt"></i></span>
  <div class="info-box-content">
    <span class="info-box-text"><h5><b>Empleado por Sucursal</b></h5   ></span>
    @foreach ($ResulSucursal as $sucursal)
    <span class="info-box-number">{{ $sucursal['NOM_SUCURSAL'] }} : {{ $sucursal['TOTAL_EMPLEADOS_SUCURSAL'] }}</span>
    @endforeach
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