@extends('adminlte::page')

  @section('title', 'Planillas')

  @section('content_header')

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />



  <h1>Planilla</h1>
  <div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <button class="btn btn-dark me-md-2" data-bs-toggle="modal" data-bs-target="#addPlanilla" type="button"> Generar Planilla</button>
</div>
  @stop


    @section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
    @endsection


  @section('content')

  <!-- Modal para agregar un nuevo producto -->
  <div class="modal fade bd-example-modal-sm" id="addPlanilla" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">


                    <div class="modal-header">
                    <h3>Planilla</h3>
                    <button class="btn btn-close " data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <h4>Generar Planilla del Empleado</h4>

                    <form action="{{route('Post-Planilla.Store')}}" method="post" class="was-validated">
                    @csrf
                    
                
                        <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Empleado</label>
                    <select class="form-control js-example-basic-single"  name="COD_EMPLEADO" id="COD_EMPLEADO">
                    <option disabled selected> Seleccionar Empleado </option>
                    @foreach ($ResulEmpleado as $Empleado)
                    <option value="{{ $Empleado['COD_EMPLEADO'] }}">{{ $Empleado['NOMBRE_COMPLETO'] }}</option>
                    @endforeach
                    </select>
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Fecha Generar Planilla</label>
                    <input type="date" class="form-control" min="2023-08-01" max="<?= date('Y-m-d'); ?>" name="FEC_REA_PLANILLA" required>
                    </div>

                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-danger " data-bs-dismiss="modal"><b>CERRAR</b></button>
                      <button class="btn btn-primary" data-bs="modal"><b>ACEPTAR</b></button>
                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


   <!-- /.card-header -->
 <div class="table-responsive p-0">
 <br>
  <table id="planilla" class="table table-striped table-bordered table-condensed table-hover">
    <thead class="bg-dark">
    <tr> 
        <th>#</th>
        <TH>NOMBRE COMPLETO</TH>
        <th>SALARIO BASE</th>
        <th>FECHA</th>
        <th>SALARIO BRUTO</th>
        <th>HORAS EXTRAS</th>
        <th>VACACIONES</th>
        <th>CATORCEAVO</th>
        <th>AGUINALDO</th>
        <th>IHSS</th>
        <th>SALARIO NETO</th>
        <th>ACCION</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($ResulPlanilla as $Planilla)
        <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $Planilla['NOMBRE_COMPLETO'] }}</td>
        <td>{{ number_format($Planilla['SAL_BAS_EMPLEADO'], 2, '.', ',') }}</td>
        <td>{{ date('d-m-Y', strtotime($Planilla['FEC_REA_PLANILLA'])) }}</td>
        <td>{{ number_format($Planilla['SALARIO_BRUTO'], 2, '.', ',') }}</td>
        <td>{{ $Planilla['HORAS_EXTRAS'] }}</td>
        <td>{{ number_format($Planilla['VACACIONES'], 2, '.', ',') }}</td>
        <td>{{ $Planilla['CATORCEAVO'] }}</td>
        <td>{{ $Planilla['AGUINALDO'] }}</td>
        <td>{{ $Planilla['IHSS'] }}</td>
        <td>{{ number_format($Planilla['SALARIO_NETO'], 2, '.', ',') }}</td>
        <td>
          <a class="btn btn-warning" href="">
            <i class="fa fa-edit"></i>
          </a>
         </td>
      </tr>
    @endforeach
  </tbody>
</table>
</div>

  @stop

  @section('footer')

  <div class="float-right d-none d-sm-block">
    <b>Version</b> 3.1.0
  </div>
  <strong>Copyright &copy; 2023 <a href="">IMPERIO IMFORMATICO</a>.</strong> All rights reserved.

  @stop



  @section('js')

  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>
  <script>
    $('#planilla').DataTable({
      responsive: true,
      autWidth: false,

      "language": {
              "lengthMenu": "Mostrar  _MENU_  Registros Por Página",
              "zeroRecords": "Nada Encontrado - ¡Disculpas!",
              "info": "Pagina _PAGE_ de _PAGES_",
              "infoEmpty": "No records available",
              "infoFiltered": "(Filtrado de _MAX_ registros totales)",

              'search' : 'Buscar:',
              'paginate' : {
                'next': 'Siguiente',
                'previous' : 'Anterior'
              }

          }
    });

    </script>

    <script>
    $(document).ready(function() {
      $('.js-example-basic-single').select2({});
  });
</script>

    </script>
    @stop