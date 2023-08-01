@extends('adminlte::page')

@section('title', 'Planillas')

<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@section('content_header')
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <button class="btn btn-primary me-md-2" data-bs-toggle="modal" data-bs-target="#addPlanilla" type="button"> Generar Planilla</button>
</div>
@stop
@section('content')
<div class = "card">
    <div class = "card-body">
    <table id ="Planilla" class= "table table-striped table-bordered shadow-lg mt-4" style="width:100%">
      <thead class="bg-dark text-white">
        <tr> 
        <th>CODIGO PLANILLA</th>
        <TH>CODIGO EMPLEADO</TH>
        <TH>NOMBRE COMPLETO</TH>
        <th>SALARIO BASE</th>
        <th>FECHA</th>
        <th>SALARIO BRUTO</th>
        <th>HORAS EXTRAS</th>
        <th>VACACIONES</th>
        <th>CATORCEAVO</th>
        <th>AGUINALDO</th>
        <th>RAS IHSS</th>
        <th>RPS IHSS</th>
        <th>IHSS</th>
        <th>SALARIO NETO</th>
        <th>ACCION</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($ResulPlanilla as $Planilla)
        <tr>
          <td>{{ $Planilla['COD_PLANILLA'] }}</td>
          <td>{{ $Planilla['COD_EMPLEADO'] }}</td>
          <td>{{ $Planilla['NOMBRE_COMPLETO'] }}</td>
          <td>{{ $Planilla['SAL_BAS_EMPLEADO'] }}</td>
          <td>{{ $Planilla['FEC_REA_PLANILLA'] }}</td>
          <td>{{ $Planilla['SALARIO_BRUTO'] }}</td>
          <td>{{ $Planilla['HORAS_EXTRAS'] }}</td>
          <td>{{ $Planilla['VACACIONES'] }}</td>
          <td>{{ $Planilla['CATORCEAVO'] }}</td>
          <td>{{ $Planilla['AGUINALDO'] }}</td>
          <td>{{ $Planilla['RAS_IHSS'] }}</td>
          <td>{{ $Planilla['RPS_IHSS'] }}</td>
          <td>{{ $Planilla['IHSS'] }}</td>
          <td>{{ $Planilla['SALARIO_NETO'] }}</td>
          <td>
                 <button type="button" class="btn btn-warning" onclick="" data-bs-toggle="modal" data-bs-target="#UptPlanilla"><i class="fa-solid fa-pen-to-square"></i>Editar</button>
                        
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