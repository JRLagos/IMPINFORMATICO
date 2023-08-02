@extends('adminlte::page')

@section('title', 'Reportes')

<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@section('content_header')


@stop

@section('content')
<h1 class="mb-4">Reportes Guardados</h1>
<div class="card">
  <div class="card-body">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <button class="btn btn-primary me-md-2" data-bs-toggle="modal" data-bs-target="#addTiposReporte" type="button">Nuevo Tipo de Reporte</button>
</div>
    <div class="table-responsive">
      <table id="reportes" class="table table-striped table-bordered shadow-lg mt-4">
        <thead class="bg-dark text-white">
          <tr>
            <th class="text-center">CODIGO DE REPORTE</th>
            <th class="text-center">TITULO</th>
            <th class="text-center">FECHA GUARDADO</th>
            <th class="text-center">ACCION</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($ResulReportesGuardados as $ReportesGuardados)
            <tr>
              <td class="text-center">{{ $ReportesGuardados['COD_REPORTE'] }}</td>
              <td class="text-center">{{ $ReportesGuardados['TIT_REPORTE'] }}</td>
              <td class="text-center">{{ $ReportesGuardados['FEC_GUA_REPORTE'] }}</td>
              <td class="text-center">
                <button type="button" class="btn btn-warning" onclick="" data-bs-toggle="modal" data-bs-target="#updReporte">
                  <i class="fa-solid fa-pen-to-square"></i>Editar
                </button>
              </td>
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


<div class="modal" id="addVacaciones" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                    <h3>Vacaciones</h3>
                    <button class="btn btn-close " data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <h4>Ingresar las Vacaciones del Empleado</h4>

                    <form action="{{route('Post-Vacaciones.store')}}" method="post" class="was-validated">
                    @csrf
                    
                
                        <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Codigo del Empleado</label>
                    <input type="text" class="form-control" placeholder="COD_EMPLEADO" name="COD_EMPLEADO" required>
                    <div class="valid-feedback"></div>
                    </div>

                        <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Vacaciones Acumuladas</label>
                    <input type="text" class="form-control" name="VACACIONES_ACU" required>
                    <div class="valid-feedback"></div>
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Vacaciones Usadas</label>
                    <input type="text" class="form-control" name="VACACIONES_USA" required>
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



    <div class="modal" id="UptHoraExtra" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                    <h3>Hora Extra</h3>
                    <button class="btn btn-close " data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <h4>Actualizar Hora Extra del Empleado</h4>

                 
                    @csrf
                        <div class="mb-3 mt-3">

                    <label for="dni" class="form-label">Codigo del Empleado</label>
                    <input type="text" class="form-control" placeholder="COD_EMPLEADO" name="COD_EMPLEADO" required>
                    <div class="valid-feedback">Correcto.</div>
                    <div class="invalid-feedback">Porfavor llena este campo.</div>
                    </div>

                        <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Descripcion</label>
                    <input type="text" class="form-control" name="DES_HOR_EXTRA" required>
                    <div class="valid-feedback">Correcto.</div>
                    <div class="invalid-feedback">Porfavor llena este campo.</div>
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Cantidad Hora Extra</label>
                    <input type="text" class="form-control" placeholder="Cantidad" name="CANT_HOR_EXTRA" required>
                    <div class="valid-feedback">Correcto.</div>
                    <div class="invalid-feedback">Porfavor llena este campo.</div>
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">FECHA HORA EXTRA</label>
                    <input type="date" class="form-control" placeholder="Fecha Hora Extra" name="FEC_HOR_EXTRA" required>
                    <div class="valid-feedback">Correcto.</div>
                    <div class="invalid-feedback">Porfavor llena este campo.</div>
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
    
