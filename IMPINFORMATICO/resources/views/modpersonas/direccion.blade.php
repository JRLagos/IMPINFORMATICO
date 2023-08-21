@extends('adminlte::page')

@section('title', 'Direcciones')

@section('content_header')

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
        integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <h1>Direcciones</h1>
@stop


@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
    <!-- botones -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
@endsection


@section('content')
    @if(session('success'))
        <div class="alert alert-warning alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif    

    <!-- /.card-header -->
    <div class="table-responsive p-0">
        <br>
        <table id="direccion" class="table table-striped table-bordered table-condensed table-hover">
            <thead class="bg-dark">
                <tr>
                    <th style="text-align: center;">#</th>
                    <th style="text-align: center;">Nombre Completo</th>
                    <th style="text-align: center;">Municipio</th>
                    <th style="text-align: center;">Descripcion</th>
                    <th style="text-align: center;">Accion</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ResulDireccion as $Direccion)
                    <tr>
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td style="text-align: center;">{{ $Direccion['NOMBRE_COMPLETO'] }}</td>
                        <td style="text-align: center;">{{ $Direccion['NOM_MUNICIPIO'] }}</td>
                        <td style="text-align: center;">{{ $Direccion['DES_DIRECCION'] }}</td>
                        <td style="text-align: center;">
                        <button value="Editar" title="Editar" class="btn btn-warning" type="button" data-toggle="modal" data-target="#UpdDireccion-{{$Direccion['COD_DIRECCION']}}">
                  <i class='fas fa-edit' style='font-size:20px;'></i>
                </button>
              </td>
            </tr>

                <!-- Modal for editing goes here -->
  <div class="modal fade bd-example-modal-sm" id="UpdDireccion-{{$Direccion['COD_DIRECCION']}}" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><b>Editar Dirección</b></h4>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        
            <div class="modal-body">
              <h4><p>Ingresar nuevos datos</p></h4>
              <hr>
                <form action="{{route('Upd-Direcciones.update')}}" method="post" class="was-validated">
                @csrf

                    <input type="hidden" class="form-control" name="COD_DIRECCION"  value="{{$Direccion['COD_DIRECCION']}}">

                  <div class="mb-3 mt-3">
                      <label for="dni" class="form-label">Empleado</label>
                      <select class="form-control js-example-basic-single"  name="COD_PERSONA" id="COD_PERSONA">
                        <option value="{{$Direccion['COD_PERSONA']}}" style="display: none;">{{ $Direccion['NOMBRE_COMPLETO'] }}</option>
                        <option disabled >¡No se puede seleccionar otro Empleado!</option>
                      </select>
                      </select>
                      
                    </div>

                    <div class="mb-3 mt-3">
                      <label for="dni" class="form-label">Municipio</label>
                      <select class="form-control js-example-basic-single"  name="COD_MUNICIPIO" id="COD_MUNICIPIO">
                        <option value="{{$Direccion['COD_MUNICIPIO']}}" style="display: none;">{{ $Direccion['NOM_MUNICIPIO'] }}</option>
                          @foreach ($ResulMunicipio as $Municipio)
                        <option value="{{ $Municipio['COD_MUNICIPIO'] }}">{{ $Municipio['NOM_MUNICIPIO'] }}</option>
                          @endforeach
                      </select>
                    </div>

                  <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Descripción</label>
                    <input type="text" class="form-control alphanumeric-input" pattern=".{3,}" name="DES_DIRECCION" value="{{$Direccion['DES_DIRECCION']}}" required maxlength="255">                   
                  </div>

                  <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal"><b>CERRAR</b></button>
                  <button type="submit" class="btn btn-primary"><b>ACTUALIZAR</b></button>
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
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
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
            var table = $('#direccion').DataTable({
                dom: '<"top"Bl>frt<"bottom"ip><"clear">',
                buttons: [{
                    extend: 'collection',
                    className: 'custom-html-collection',
                    text: 'Opciones', // Cambia el texto de la colección de botones
                    buttons: [{
                            extend: 'pdf',
                            title: 'IMPINFORMATICO | Direcciones',
                            customize: function(doc) {
                                var now = obtenerFechaHora();
                                var titulo = "Reporte de Direcciones";
                                var descripcion = "Empleados con sus respectivas direcciones";

                                // Encabezado
                                doc['header'] = function(currentPage, pageCount) {
                                    return {
                                        text: titulo,
                                        fontSize: 18,
                                        alignment: 'center',
                                        margin: [0, 10]
                                    };
                                };

                                // Pie de Página
                                doc['footer'] = function(currentPage, pageCount) {
                                    return {
                                        columns: [{
                                                text: 'imperioinformatico',
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

                                // Contenido
                                doc.content.unshift({
                                    text: descripcion,
                                    alignment: 'left',
                                    margin: [10, 0, 10, 10]
                                });
                            }
                        },
                        'csv',
                        'excel',
                        'columnsToggle'
                    ],
                }],
                responsive: true,
                autoWidth: false,
                language: {
                    lengthMenu: "Mostrar _MENU_ Registros Por Página",
                    zeroRecords: "Nada encontrado - disculpas",
                    info: "Página _PAGE_ de _PAGES_",
                    infoEmpty: "No hay registros disponibles",
                    infoFiltered: "(Filtrado de _MAX_ registros totales)",
                    search: 'Buscar:',
                    paginate: {
                        next: 'Siguiente',
                        previous: 'Anterior'
                    }
                }
            });

            table.buttons().container()
                .appendTo('#departamento_wrapper .col-md-6:eq(0)');
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
    </script>
       <script>
    setTimeout(function(){
        $('.alert').alert('close'); // Cierra automáticamente todas las alertas después de 5 segundos
    }, 5000); // 5000 ms = 5 segundos
       </script>
    </script>
@stop
