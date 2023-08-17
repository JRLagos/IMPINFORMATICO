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
  <!-- botones -->
  <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
  <style>
      .btn-group>.btn {
          font-size: 12px;
          padding: 6px 12px;
      }
  </style>
  <style>
      div.dt-button-collection {
          width: 600px;
      }

      div.dt-button-collection button.dt-button {
          display: inline-block;
          width: 32%;
      }

      div.dt-button-collection button.buttons-colvis {
          display: inline-block;
          width: 49%;
      }

      div.dt-button-collection h3 {
          margin-top: 5px;
          margin-bottom: 5px;
          font-weight: 100;
          border-bottom: 1px solid rgba(255, 255, 255, 0.5);
          font-size: 1em;
          padding: 0 1em;
      }

      div.dt-button-collection h3.not-top-heading {
          margin-top: 10px;
      }
  </style>
   <script>
    $(document).ready(function() {
        var table = $('#vacaciones').DataTable({
            responsive: true,
    autWidth: false,
    language: {
        lengthMenu: "Mostrar _MENU_ Registros Por Página",
        zeroRecords: "Nada Encontrado - ¡Disculpas!",
        info: "Página _PAGE_ de _PAGES_",
        infoEmpty: "No hay registros disponibles",
        infoFiltered: "(Filtrado de _MAX_ registros totales)",
        search: "Buscar:",
        paginate: {
            next: "Siguiente",
            previous: "Anterior"
        }
    },

    dom: '<"top"Bl>frt<"bottom"ip><"clear">',
    buttons: [{
        extend: 'collection',
        className: 'custom-html-collection',
        text: 'Opciones',
        buttons: [{
                extend: 'pdf',
                title: 'IMPINFORMATICO | Vacaciones',
                customize: function(doc) {
                    var now = obtenerFechaHora();
                    var titulo = "Reporte de Vacaciones de los Empleados ";
                    var descripcion =
                        "Descripción del reporte: Reporte de vacaciones de los empleados con sus vacaciones acumuladas, usadas y restantes";

                    doc['header'] = function(currentPage, pageCount) {
                        return {
                            text: titulo,
                            fontSize: 14,
                            alignment: 'center',
                            margin: [0, 10]
                        };
                    };

                    doc['footer'] = function(currentPage, pageCount) {
                        return {
                            columns: [{
                                    text: 'Imperio Informatico',
                                    alignment: 'left',
                                    margin: [10, 10]
                                },
                                {
                                    text: 'Fecha y Hora: ' + now,
                                    alignment: 'right',
                                    margin: [10, 10]
                                }
                            ],
                            margin: [10, 0]
                        };
                    };
                    doc.contentMargins = [10, 10, 10, 10]; // Ajusta el margen de la tabla aquí
                    doc.content.unshift({
                        text: descripcion,
                        alignment: 'left',
                        margin: [10, 0, 10, 10]
                    });
                }
            },
            {
                extend: 'print',
                text: 'Imprimir',
                action: function (e, dt, node, config) {
                    // Ocultar la columna número 12
                    table.column(3).visible(false);
                    // Imprimir
                    $.fn.dataTable.ext.buttons.print.action(e, dt, node, config);
                    // Restablecer la visibilidad de la columna después de imprimir
                    table.column(3).visible(true);
                }
            },
            {
                extend: 'excelHtml5',
                text: 'Excel',
                title: 'Vacaciones IMPINFORMATICO',
                messageTop: 'Reporte de vacaciones con sus empleados',
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    $('row:first c', sheet).attr('s', '7');
                }
            }
        ]
    },
    {
        extend: 'colvis',
        text: 'Columnas visibles' // Botón de columnas visibles
    }]
});

// Mover los botones de exportación al contenedor adecuado
table.buttons().container()
    .appendTo($('.col-sm-6:eq(0)', table.table().container()));
});

function obtenerFechaHora() {
var now = new Date();
var options = {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: 'numeric',
    minute: 'numeric',
    second: 'numeric',
    hour12: false
};
return now.toLocaleDateString('es-ES', options);
}

    <script>
    $(document).ready(function() {
      $('.js-example-basic-single').select2({});
  });
</script>

    </script>
    @stop