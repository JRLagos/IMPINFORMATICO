@extends('adminlte::page')

@section('title', 'Cerrar Sesión')

@section('content_header')
    <h1>Cerrar Sesión</h1>
@stop

@section('content')
    <p>¿Estás seguro que deseas cerrar la sesión?</p>
    <form action="{{ route('ModuloSeguridad.Login') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
    </form>
@stop

@section('footer')
    <div class="float-right d-none d-sm-block">
        <b>Versión</b> 1.0
    </div>
    <strong>Derechos de Autor &copy; 2023 <a href="#">Tu Compañía</a>.</strong> Todos los derechos reservados.
@stop
