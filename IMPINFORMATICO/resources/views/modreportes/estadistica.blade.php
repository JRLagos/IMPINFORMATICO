@extends('adminlte::page')

@section('title', 'Estadisticas')

<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@section('content_header')
<div class="progress">
  <div class="progress-bar bg-dark" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
</div>
@stop
@section('content')
<h2 class="mb-4">Estadisticas</h2>
<div class = "card">
    <div class = "card-body">
    <table id ="horaextra" class= "table table-striped table-bordered shadow-lg mt-4" style="width:100%">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <button class="btn btn-primary me-md-2" data-bs-toggle="modal" data-bs-target="#addDepartamento" type="button"> Agregar Estadisticas</button>
</div>
      <thead class="bg-dark text-white">
        <tr> 
        <th>CODIGO </th>
        <TH>USUARIO</TH>
        <TH>TIPO </TH>
        <TH>TITULO</TH>
        <TH>FORMATO</TH>
        <TH>EMAIL</TH>
        <TH>FECHA</TH>
        <TH>ESTADO</TH>
        <th>ACCION</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($ResulEstadistica as $Estadistica)
        <tr>
          <td>{{ $Estadistica['COD_ESTADISTICA'] }}</td>
          <td>{{ $Estadistica['NOM_USUARIO'] }}</td>
          <td>{{ $Estadistica['NOM_TIP_ESTADISTICA'] }}</td>
          <td>{{ $Estadistica['TIT_ESTADISTICA'] }}</td>
          <td>{{ $Estadistica['FOR_ESTADISTICA'] }}</td>
          <td>{{ $Estadistica['EMAIL'] }}</td>
          <td>{{ $Estadistica['HOR_FEC_ESTADISTICA'] }}</td>
          <td>{{ $Estadistica['IND_ESTADISTICA'] }}</td>
          <td>
                 <button type="button" class="btn btn-warning" onclick="" data-bs-toggle="modal" data-bs-target="#UptHoraExtra"><i class="fa-solid fa-pen-to-square"></i>Editar</button>
                        
        </td>
        </tr>
        @endforeach
    </tbody>    
    </table>
    
</div>
</div>

@section('footer')

<div class="float-right d-none d-sm-block">
  <b>Version</b> 3.1.0
</div>
<strong>Copyright &copy; 2023 <a href="">IMPERIO IMFORMATICO</a>.</strong> All rights reserved.

@stop
@stop