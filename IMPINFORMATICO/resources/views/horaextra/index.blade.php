@extends('adminlte::page')

@section('title', 'Horas Extras')

<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@section('content_header')
    <div class="mb-2 d-flex">
        <h1>Horas Extras</h1>
        <div class="btn btn-primary ms-auto w-25" data-bs-toggle="modal" data-bs-target="#addDepartamento"><h1>Ingresar Hora Extra</h1></div>
    </div>
@stop
@section('content')
<div class = "card">
    <div class = "card-body">
    <table id ="HoraExtra" class= "table table-striped table-bordered shadow-lg mt-4" style="width:100%">
      <thead class="bg-dark text-white">
        <tr> 
            <th scope = "col">CODIGO HORA EXTRA </th>
            <th scope = "col">CODIGO EMPLEADO</th>
            <th scope = "col">NOMBRE EMPLEADO</th>
            <th scope = "col">DESCRIPCION HORA EXTRA</th>
            <th scope = "col">CANTIDAD HORA EXTRA</th>
        </tr>
    </thead> 
        </table>
</div>
</div>
@stop
    