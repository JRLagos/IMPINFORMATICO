@extends('adminlte::page')

@section('title', 'Horas Extras')

@section('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
  @endsection

@section('content_header')
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <button class="btn btn-primary me-md-2" data-bs-toggle="modal" data-bs-target="#addDepartamento" type="button"> <h1>Agregar Hora Extra</h1></button>
</div>
@stop
@section('content')
<div class = "card">
    <div class = "card-body">
    <table id ="departamento" class= "table table-striped table-bordered shadow-lg mt-4" style="width:100%">
      <thead class="bg-dark text-white">
        <tr> 
        <th>CODIGO HORA EXTRA</th>
        <TH>CODIGO EMPLEADO</TH>
        <TH>NOMBRE COMPLETO</TH>
        <th>DESCRIPCION HORA EXTRA</th>
        <th>CANTIDAD HORA EXTRA</th>
        <th>ACCION</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($ResulHoraExtra as $HoraExtra)
        <tr>
          <td>{{ $HoraExtra['COD_HOR_EXTRA'] }}</td>
          <td>{{ $HoraExtra['COD_EMPLEADO'] }}</td>
          <td>{{ $HoraExtra['NOMBRE_COMPLETO'] }}</td>
          <td>{{ $HoraExtra['DES_HOR_EXTRA'] }}</td>
          <td>{{ $HoraExtra['CANT_HOR_EXTRA'] }}</td>
          <td>
                 <button type="button" class="btn btn-warning" onclick="" data-bs-toggle="modal" data-bs-target="#putcompra"><i class="fa-solid fa-pen-to-square"></i>Editar</button>
                        
        </td>
        </tr>
        @endforeach
    </tbody>
        </table>
</div>
</div>
@stop

    
<!-- mmksndkcpow-->