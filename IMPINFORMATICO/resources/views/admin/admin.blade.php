@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<link rel="icon" type="image/x-icon" href="{{ asset('favicon1.ico') }}" />
    <h1>IMPERIO IMFORMATICO</h1>
@stop

@section('content')
    <p>Bienvenido al Sistema Nomina IMP_INFORMATICO</p>
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
<strong>Copyright &copy; 2023 <a href="">IMPERIO IMFORMATICO</a>.</strong> All rights reserved.

@stop