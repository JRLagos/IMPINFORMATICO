@extends('adminlte::page')

  @section('title', 'Vacaciones')

  @section('content_header')

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="d-grid gap-2 d-md-flex justify-content-between align-items-center">
  <h1><b>Vacaciones</b></h1>
  <button class="btn btn-dark btn-lg" data-bs-toggle="modal" data-bs-target="#addVacaciones" type="button"><b>Agregar Vacaciones</b></button>
</div>
  @stop


    @section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
    @endsection


  @section('content')

  <!-- Modal para agregar un nueva Vacaciones -->
  <div class="modal fade bd-example-modal-sm" id="addVacaciones" tabindex="-1">
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
                    <label for="dni" class="form-label">Empleado</label>
                    <select class="form-control js-example-basic-single"  name="COD_EMPLEADO" id="COD_EMPLEADO">
                    <option disabled selected> Seleccionar Empleado </option>
                    @foreach ($ResulEmpleado as $Empleado)
                    <option value="{{ $Empleado['COD_EMPLEADO'] }}">{{ $Empleado['NOMBRE_COMPLETO'] }}</option>
                    @endforeach
                    </select>
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Vacaciones Usadas</label>
                    <input type="number" class="form-control" min="0" max="20" name="VACACIONES_USA" required>
                    <span class="validity"></span>
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
    <table id="vacaciones" class="table table-striped table-bordered table-condensed table-hover">
      <thead class="bg-dark">
        <tr>
        <th>#</th>
        <TH>Nombre Completo</TH>
        <th>Vacaciones Acumuladas</th>
        <th>Vacaciones Usadas</th>
        <th>Vacaciones Disponible</th>
        <th>Accion</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($ResulVacaciones as $Vacaciones)
        <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $Vacaciones['NOMBRE_COMPLETO'] }}</td>
        <td>{{ $Vacaciones['VACACIONES_ACU'] }}</td>
        <td>{{ $Vacaciones['VACACIONES_USA'] }}</td>
        <td>{{ $Vacaciones['VACACIONES_DIS'] }}</td>
              <td style="text-align: center;">
                <button value="Editar" title="Editar" class="btn btn-warning" type="button" data-toggle="modal" data-target="#UptVacaciones-{{$Vacaciones['COD_VACACIONES']}}">
                  <i class='fas fa-edit' style='font-size:20px;'></i>
                </button>
              </td>
            </tr>
                <!-- Modal for editing goes here -->
  <div class="modal fade bd-example-modal-sm" id="UptVacaciones-{{$Vacaciones['COD_VACACIONES']}}" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><b>Editar Vacaciones</b></h4>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        
            <div class="modal-body">
              <h4><p>Ingresar Nuevos Datos</p></h4>
              <hr>
                <form action="{{route('Upt-Vacaciones.update')}}" method="post" class="was-validated">
                @csrf

                    <input type="hidden" class="form-control" name="COD_VACACIONES"  value="{{$Vacaciones['COD_VACACIONES']}}">

                    <div class="mb-3 mt-3">
                      <label for="dni" class="form-label">Empleado</label>
                      <select class="form-control js-example-basic-single"  name="COD_EMPLEADO" id="COD_EMPLEADO">
                        <option value="{{$Vacaciones['COD_EMPLEADO']}}" style="display: none;">{{ $Vacaciones['NOMBRE_COMPLETO'] }}</option>
                          @foreach ($ResulEmpleado as $Empleado)
                        <option value="{{ $Empleado['COD_EMPLEADO'] }}">{{ $Empleado['NOMBRE_COMPLETO'] }}</option>
                          @endforeach
                      </select>
                    </div>
 
                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Vacaciones Acumuladas</label>
                    <input type="number" class="form-control" min="0" max="20" name="VACACIONES_ACU" value="{{$Vacaciones['VACACIONES_ACU']}}" required>
                    <span class="validity"></span>
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Vacaciones Usadas</label>
                    <input type="number" class="form-control" min="0" max="20" name="VACACIONES_USA" value="{{$Vacaciones['VACACIONES_USA']}}" required>
                    <span class="validity"></span>
                    </div>

                  <div class="modal-footer">
                    <button class="btn btn-danger " data-bs-dismiss="modal"><b>CERRAR</b></button>
                    <button class="btn btn-primary" data-bs="modal"><b>ACTUALIZAR</b></button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </tbody>
    </table>
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
    $('#vacaciones').DataTable({
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