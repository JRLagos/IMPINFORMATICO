@extends('adminlte::page')

@section('title', 'Departamentos')

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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <div class="d-grid gap-2 d-md-flex justify-content-between align-items-center">
        <h1>Departamentos</h1>
        <button class="btn btn-dark btn-lg" data-bs-toggle="modal" data-bs-target="#addDepartamento"
            type="button"><b>Agregar Departamento</b></button>
    </div>
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
    <!-- Modal para agregar un nuevo Departamento -->
    <div class="modal fade bd-example-modal-sm" id="addDepartamento" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Departamento</h3>
                    <button class="btn btn-close " data-bs-dismiss="modal"></button>
                    
                </div>
                <div class="modal-body">
                    <h4>Ingresar Departamento</h4>

                    <form action="{{ route('Post-Departamento.store') }}" method="post" class="was-validated">
                        @csrf

                        <div class="mb-3 mt-3">
                            <label for="dni" class="form-label">Nombre Departamento</label>
                            <input type="text" class="form-control" pattern="[A-Za-z].{3,}" name="NOM_DEPARTAMENTO"
                                required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger " data-bs-dismiss="modal"><b>CERRAR</b></button>
                    <button class="btn btn-primary" data-bs="modal"><b>ACEPTAR</b></button>
                    </form>
                </div>

            </div>
        </div>
    </div>

      
    @if(session('success'))
        <div class="alert alert-warning alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif    


   <!-- /.card-header -->
 <div class="table-responsive p-0">
 <br>
  <table id="departamento" class="table table-striped table-bordered table-condensed table-hover">
    <thead class="bg-dark">

    <tr>
            <th style="text-align: center;">#</th>
            <th style="text-align: center;">Nombre</th>
            <th style="text-align: center;">Accion</th>
    </tr>
        </thead>
        <tbody>
            @foreach($ResulDepartamento as $Departamento)

                <tr>
                    <th style="text-align: center;">#</th>
                    <th style="text-align: center;">{{$Departamento['NOM_DEPARTAMENTO']}}</th>
                    <th style="text-align: center;">Accion</th>
                </tr>


                <div class="modal fade bd-example-modal-sm" id="Departamento-edit-{{$Departamento['COD_DEPARTAMENTO']}}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Editar Departamento</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h4>Ingresar nuevos datos</h4>
                                <form action="{{route('Put-Departamento.update')}}" method="post" class="was-validated">
                                    @csrf
                                        <input type="hidden" class="form-control" name="COD_DEPARTAMENTO"  value="{{$Departamento['COD_DEPARTAMENTO']}}">

                                        <div class="mb-3 mt-3">
                                            <label for="dni" class="form-label">Nombre</label>
                                            <input type="text" class="form-control alphanumeric-input"
                                                id="NOM_DEPARTAMENTO" name="NOM_DEPARTAMENTO" pattern="[A-Z a-z].{3,}"
                                                value="{{ $Departamento['NOM_DEPARTAMENTO'] }}" required maxlength="30">
                                        </div>


                                      <div class="modal-footer">
                                         <button type="button" class="btn btn-danger" data-dismiss="modal"><b>CERRAR</b></button>
                                         <button type="submit" class="btn btn-primary"><b>ACTUALIZAR</b></button>
                                      </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    @stop

    @section('footer')
        <div class="float-left">
            <strong>Copyright &copy; 2023 <a href="#">IMPERIO IMFORMATICO</a>.</strong> Todos los derechos
            reservados.
        </div>
        <div class="float-right d-none d-sm-block">
            <b>Versión</b> 3.1.0
        </div>
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
                var table = $('#departamento').DataTable({
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
                                    title: 'IMPINFORMATICO | Departamento',
                                    customize: function(doc) {
                                        var now = obtenerFechaHora();
                                        var titulo = "Reporte de Departamento ";
                                        var descripcion =
                                            "Descripción del reporte: Departamentos del pais";

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
                                        doc.contentMargins = [10, 10, 10,
                                            10
                                        ]; // Ajusta el margen de la tabla aquí
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
                                    action: function(e, dt, node, config) {
                                        // Ocultar la columna número 12
                                        table.column(4).visible(false);
                                        // Imprimir
                                        $.fn.dataTable.ext.buttons.print.action(e, dt, node,
                                            config);
                                        // Restablecer la visibilidad de la columna después de imprimir
                                        table.column(4).visible(true);
                                    }
                                },
                                {
                                    extend: 'excelHtml5',
                                    text: 'Excel',
                                    title: 'Departamentos',
                                    messageTop: 'Reporte de Departamentos',
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
                        }
                    ]
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
        </script>

<script>
    setTimeout(function(){
        $('.alert').alert('close'); // Cierra automáticamente todas las alertas después de 5 segundos
    }, 5000); // 5000 ms = 5 segundos
</script>

    @stop
