@extends('adminlte::page')

@section('title', 'Reportes Generados')

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@section('content_header')
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
  
</div>
@stop

@section('content')
<div class="card">
  <div class="card-body">
    <h1>Reportes Generados</h1>
    <div class="table-responsive">
      <table id="reportesgenerados" class="table table-striped table-bordered shadow-lg mt-4">
        <thead class="bg-dark text-white">
          <tr>
            <th class="text-center">CODIGO REPORTE GENERADO</th>
            <th class="text-center">TITULO</th>
            <th class="text-center">FECHA GENERADO EL REPORTE</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($ResulReportesGen as $ResulReporte)
            <tr>
              <td class="text-center">{{ $ResulReporte['COD_REP_GENERADO'] }}</td>
              <td>{{ $ResulReporte['TIT_REPORTE'] }}</td>
              <td>{{ $ResulReporte['FEC_GEN_REPORTE'] }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>


@section('footer')
<div class="float-right d-none d-sm-block">
  <b>Version</b> 3.1.0
</div>
<strong>Copyright &copy; 2023 <a href="">IMPERIO IMFORMATICO</a>.</strong> All rights reserved.
@stop
@stop
