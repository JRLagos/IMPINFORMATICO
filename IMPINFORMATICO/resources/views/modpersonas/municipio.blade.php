@extends('adminlte::page')

@section('title', 'Municipio')

<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@section('content_header')
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <button class="btn btn-primary me-md-2" data-bs-toggle="modal" data-bs-target="#addMunicipio" type="button"> Agregar Municipio</button>
</div>
@stop
@section('content')
<div class = "card">
    <div class = "card-body">
    <table id ="vacaciones" class= "table table-striped table-bordered shadow-lg mt-4" style="width:100%">
      <thead class="bg-dark text-white">
        <tr> 
        <th>CODIGO MUNICIPIO</th>
        <TH>NOMBRE MUNICIPIO</TH>
        <TH>NOMBRE DEPARTAMENTO</TH>
        <th>CODIGO DEPARTAMENTO</th>
        <th>ACCION</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($ResulMunicipio as $Municipio)
        <tr>
          <td>{{ $Municipio['COD_MUNICIPIO'] }}</td>
          <td>{{ $Municipio['NOM_MUNICIPIO'] }}</td>
          <td>{{ $Municipio['NOM_DEPARTAMENTO'] }}</td>
          <td>{{ $Municipio['COD_DEPARTAMENTO'] }}</td>
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

<div class="modal" id="addMunicipio" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                    <h3>Municipio</h3>
                    <button class="btn btn-close " data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <h4>Ingresar Municipio</h4>

                    <form action="{{route('Post-Municipio.store')}}" method="post">
                    @csrf
                    
                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Departamento</label>
                    <select class="form-control js-example-basic-single"  name="COD_DEPARTAMENTO" id="COD_DEPARTAMENTO">
                    <option> Seleccionar Departamento </option>
                    @foreach ($ResulDepartamento as $Departamento)
                    <option value="{{ $Departamento['COD_DEPARTAMENTO'] }}">{{ $Departamento['NOM_DEPARTAMENTO'] }}</option>
                    @endforeach
                    </select>
                    </div>
                
                        <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Nombre del Municipio</label>
                    <input type="text" class="form-control" placeholder="" name="NOM_MUNICIPIO" pattern="[A-Za-z].{4,}"required>
                    <div class="valid-feedback"></div>
                    </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger " data-bs-dismiss="modal">CERRAR</button>
                        <button class="btn btn-primary" data-bs="modal">ACEPTAR</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>