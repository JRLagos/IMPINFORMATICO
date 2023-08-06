@extends('adminlte::page')

  @section('title', 'Empleados')

  @section('content_header')

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />



  <h1>Empleados</h1>
  <div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <button class="btn btn-dark me-md-2" data-bs-toggle="modal" data-bs-target="#addEmpleado" type="button"> Agregar Empleado</button>
</div>
  @stop


    @section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
    @endsection


  @section('content')

  <!-- Modal para agregar un nuevo Empleado -->
  <div class="modal fade bd-example-modal-sm" id="addEmpleado" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">


                    <div class="modal-header">
                    <h3>Empleados</h3>
                    <button class="btn btn-close " data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <h4>Ingresar Empleado</h4>

                    <form action="{{route('Post-Empleado.store')}}" method="post">
                    @csrf
                    
                
                        <div class="mb-3 mt-3">
                    <select class="form-control js-example-basic-single"  name="COD_EMPLEADO" id="COD_EMPLEADO">
                    <option> Selecionar Empleado </option>
                    @foreach ($ResulEmpleado as $Empleado)
                    <option value="{{ $Empleado['COD_EMPLEADO'] }}">{{ $Empleado['NOMBRE_COMPLETO'] }}</option>
                    @endforeach
                    </select>
                    </div>

                        <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Descripcion</label>
                    <input type="text" class="form-control" name="DES_HOR_EXTRA" required>
                    <div class="valid-feedback"></div>
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Cantidad Hora Extra</label>
                    <input type="text" class="form-control" placeholder="Cantidad" name="CANT_HOR_EXTRA" required>
                    <div class="valid-feedback"></div>
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">FECHA HORA EXTRA</label>
                    <input type="date" class="form-control" placeholder="Fecha Hora Extra" name="FEC_HOR_EXTRA" required>
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


   <!-- /.card-header -->
 <div class="table-responsive p-0">
 <br>
  <table id="empleado" class="table table-striped table-bordered table-condensed table-hover">
    <thead class="bg-dark">
    <tr> 
        <th>#</th>
        <TH>Nombre Completo</TH>
        <th>Puesto Trabajo</th>
        <th>Tipo Contrato</th>
        <th>Sueldo Base</th>
        <th>Accion</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($ResulEmpleado as $Empleado)
        <tr>
        <td>{{ $loop->iteration }}</td>
          <td>{{ $Empleado['NOMBRE_COMPLETO'] }}</td>
          <td>{{ $Empleado['PUE_TRA_EMPLEADO'] }}</td>
          <td>{{ $Empleado['TIP_CONTRATO'] }}</td>
          <td>{{ $Empleado['SAL_BAS_EMPLEADO'] }}</td>
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
    $('#empleado').DataTable({
      responsive: true,
      autWidth: false,

      "language": {
              "lengthMenu": "Mostrar  _MENU_  Registros Por Página",
              "zeroRecords": "Nada encontrado - disculpas",
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