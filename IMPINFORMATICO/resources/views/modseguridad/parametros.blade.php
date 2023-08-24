@extends('adminlte::page')

  @section('title', 'Parametro')

  @section('content_header')

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />


  <h1>Parametros</h1>
  <div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <button class="btn btn-dark me-md-2" data-bs-toggle="modal" data-bs-target="#addParametro" type="button"> Agregar Parametro</button>
</div>
  @stop


    @section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
    @endsection


  @section('content')

  <!-- Modal para agregar un nuevo producto -->
  <div class="modal fade bd-example-modal-sm" id="addParametro" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">


                    <div class="modal-header">
                    <h3>Objetos</h3>
                    <button class="btn btn-close " data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <h4>Ingresar Rol</h4>

                    <form action="{{route('Post-Parametros.store')}}" method="post" class="was-validated">
                    @csrf
                    
                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Descripcion Parametro</label>
                    <input type="text" class="form-control" pattern="[A-Za-z].{3,}" name="DES_PARAMETRO" required minlength="4" maxlength="50"/>
                    <span class="validity"></span>
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Descripcion Valor</label>
                    <input type="text" class="form-control" pattern="[A-Za-z].{3,}" name="DES_VALOR" required minlength="4" maxlength="100"/>
                    <span class="validity"></span>
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Usuario</label>
                    <select class="form-select js-example-basic-single"  name="COD_USUARIO" id="COD_USUARIO">
                    <option value="" selected disabled>Seleccionar Usuario</option>
                    @foreach ($ResulUsuario as $Usuario)
                    <option value="{{ $Usuario['COD_USUARIO'] }}">{{ $Usuario['NOM_USUARIO'] }}</option>
                    @endforeach
                    </select>
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Fecha Creacion</label>
                    <input type="date" class="form-control" min="2023-08-01" max="<?= date('Y-m-d'); ?>" name="FEC_CREACION" required>
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Fecha Modificacion</label>
                    <input type="date" class="form-control" min="2023-08-01" max="<?= date('Y-m-d'); ?>" name="FEC_MODIFICACION" required>
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
  <table id="parametro" class="table table-striped table-bordered table-condensed table-hover">
    <thead class="bg-dark">

    <tr>
        <th style="text-align: center;">#</th>
        <th style="text-align: center;">Descripcion Parametro</th>
        <th style="text-align: center;">Descripcion Valor</th>
        <th style="text-align: center;">Usuario</th>
        <th style="text-align: center;">Fecha Creacion</th>
        <th style="text-align: center;">Fecha Modificacion</th>
        <th style="text-align: center;">Accion</th>
    </tr>
        </thead>
        <tbody>
                @foreach ($ResulParametros as $Parametros)
        <tr>
                   <td style="text-align: center;">{{ $loop->iteration }}</td>
                   <td style="text-align: center;">{{ $Parametros['DES_PARAMETRO'] }}</td>
                   <td style="text-align: center;">{{ $Parametros['DES_VALOR'] }}</td>
                   <td style="text-align: center;">{{ $Parametros['NOM_USUARIO'] }}</td>
                   <td style="text-align: center;">{{ date('d-m-Y', strtotime($Parametros['FEC_CREACION'])) }}</td>
                   <td style="text-align: center;">{{ date('d-m-Y', strtotime($Parametros['FEC_MODIFICACION'])) }}</td>
                    <td style="text-align: center;">
                        <button value="Editar" title="Editar" class="btn btn-warning" type="button" data-toggle="modal" data-target="#Parametro-edit-{{$Parametros['COD_PARAMETRO']}}">
                            <i class='fas fa-edit' style='font-size:20px;'></i>
                        </button>
                    </td>
                </tr>

                <div class="modal fade bd-example-modal-sm" id="Parametro-edit-{{$Parametros['COD_PARAMETRO']}}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Editar Parametro</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h4>Ingresar Nuevos Datos</h4>
                                <form action="{{route('Upt-Parametros.update')}}" method="post" class="was-validated">
                                    @csrf
                                        <input type="hidden" class="form-control" name="COD_PARAMETRO"  value="{{$Parametros['COD_PARAMETRO']}}">
                                       
                                        <div class="mb-3 mt-3">
                                     <label for="dni" class="form-label">Nombre Empleado</label>
                      <select class="form-control js-example-basic-single"  name="COD_USUARIO" id="COD_USUARIO">
                        <option value="{{$Parametros['COD_USUARIO']}}" style="display: none;">{{ $Parametros['NOM_USUARIO'] }}</option>
                        <option disabled >¡No se puede seleccionar otro Empleado!</option>
                      </select>
                    </div>
                                        <div class="mb-3 mt-3">
                                        <label for="dni" class="form-label">Descripcion Parametro</label>
                                        <input type="text" class="form-control alphanumeric-input" id="DES_PARAMETRO" name="DES_PARAMETRO" pattern="[A-Z a-z].{3,}" value="{{$Parametros['DES_PARAMETRO']}}" required maxlength="50">
                                        </div>

                                        <div class="mb-3 mt-3">
                                        <label for="dni" class="form-label">Valor Parametro</label>
                                        <input type="text" class="form-control alphanumeric-input" id="DES_VALOR" name="DES_VALOR" pattern="[A-Z a-z].{3,}" value="{{$Parametros['DES_VALOR']}}" required maxlength="100">
                                        </div>

                                          <div class="mb-3 mt-3">
                                              <label for="dni" class="form-label">Fecha Creacion</label>
                                              <input type="date" class="form-control" min="2023-08-01"
                                                  max="<?= date('Y-m-d') ?>" name="FEC_CREACION"
                                                  value="{{ date('Y-m-d', strtotime($Parametros['FEC_CREACION'])) }}"
                                                  required>
                                          </div>
                                          <div class="mb-3 mt-3">
                                              <label for="dni" class="form-label">Fecha Modificacion</label>
                                              <input type="date" class="form-control" min="2023-08-01"
                                                  max="<?= date('Y-m-d') ?>" name="FEC_MODIFICACION"
                                                  value="{{ date('Y-m-d', strtotime($Parametros['FEC_MODIFICACION'])) }}"
                                                  required>
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
  <strong>Copyright &copy; 2023 <a href="">IMPERIO INFORMATICO</a>.</strong> All rights reserved.

  @stop



  @section('js')

  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>
  <script>
    $('#parametro').DataTable({
      responsive: true,
      autWidth: false,

      "language": {
              "lengthMenu": "Mostrar  MENU  Registros Por Página",
              "zeroRecords": "Nada encontrado - disculpas",
              "info": "Pagina PAGE de PAGES",
              "infoEmpty": "No records available",
              "infoFiltered": "(Filtrado de MAX registros totales)",

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


    <script>
  function cleanInputValue(inputElement) {
    var inputValue = inputElement.value;
    var cleanValue = inputValue.replace(/[^a-z A-Z]/g, "");
    if (cleanValue !== inputValue) {
      inputElement.value = cleanValue;
    }
  }

  var alphanumericInputs = document.querySelectorAll(".alphanumeric-input");
  alphanumericInputs.forEach(function(input) {
    input.addEventListener("input", function() {
      cleanInputValue(this);
    });
  });
</script>
    @stop