@extends('adminlte::page')

@section('title', 'Planillas')

@section('content_header')
<link rel="icon" type="image/x-icon" href="{{ asset('favicon1.ico') }}" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
        integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    @php
    $usuario = session('credenciales');
    $usuarioRol = session('nombreRol');
    $Permisos = session('permisos');
    $Objetos = session('objetos');

    // Verificar si alguna de las sesiones está vacía
    if ($usuario === null || $usuarioRol === null || $Permisos === null || $Objetos === null) {
        // Redirigir al usuario al inicio de sesión o a donde corresponda
        return redirect()->route('Login');
    }

    // Filtrar los objetos con "NOM_OBJETO" igual a "PLANILLAS"
    $objetosFiltrados = array_filter($Objetos, function($objeto) {
        return isset($objeto['NOM_OBJETO']) && $objeto['NOM_OBJETO'] === 'PLANILLAS';
    });

    // Filtrar los permisos de seguridad
    $permisosFiltrados = array_filter($Permisos, function($permiso) use ($usuario, $objetosFiltrados) {
        return (
            isset($permiso['COD_ROL']) && $permiso['COD_ROL'] === $usuario['COD_ROL'] &&
            isset($permiso['COD_OBJETO']) && in_array($permiso['COD_OBJETO'], array_column($objetosFiltrados, 'COD_OBJETO'))
        );
    });

    $rolJson = json_encode($usuarioRol, JSON_PRETTY_PRINT);
    $credencialesJson = json_encode($usuario, JSON_PRETTY_PRINT);
    $credencialesObjetos = json_encode($objetosFiltrados, JSON_PRETTY_PRINT);
    $permisosJson = json_encode($permisosFiltrados, JSON_PRETTY_PRINT);
    @endphp


    @php
        function tienePermiso($permisos, $permisoBuscado) {
        foreach ($permisos as $permiso) {
        if (isset($permiso[$permisoBuscado]) && $permiso[$permisoBuscado] === "1") {
            return true; // El usuario tiene el permiso
             }
          }
        return false; // El usuario no tiene el permiso
        }
    @endphp



        
    <div class="d-grid gap-2 d-md-flex justify-content-between align-items-center">
        <h1><b>Planillas</b></h1>
        @php
            $permisoInsertar = tienePermiso($permisosFiltrados, 'PER_INSERTAR');
        @endphp
        <button class="btn btn-dark btn-lg" data-bs-toggle="modal" data-bs-target="#addPlanilla" type="button"  @if (!$permisoInsertar) disabled @endif>
            <b>Generar Planilla</b>
        </button>
    </div>
@stop


@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
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

                    <form action="{{ route('Post-Planilla.Store') }}" method="post" class="was-validated">
                        @csrf


                        <div class="mb-3 mt-3">
                            <label for="dni" class="form-label">Empleado</label>
                            <select class="form-control js-example-basic-single" name="COD_EMPLEADO" id="COD_EMPLEADO">
                                <option disabled selected> Seleccionar Empleado </option>
                                @foreach ($ResulEmpleado as $Empleado)
                                    <option value="{{ $Empleado['COD_EMPLEADO'] }}">{{ $Empleado['NOMBRE_COMPLETO'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="dni" class="form-label">Fecha Generar Planilla</label>
                            <input type="date" class="form-control" min="2023-08-01" max="<?= date('Y-m-d') ?>"
                                name="FEC_REA_PLANILLA" required>
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
    <strong>Copyright &copy; 2023 <a href="">IMPERIO INFORMATICO</a>.</strong> All rights reserved.

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
            var table = $('#planilla').DataTable({
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
                                title: 'IMPINFORMATICO | Planilla',
                                orientation: 'landscape',
                                customize: function(doc) {
                                    var now = obtenerFechaHora();
                                    var titulo = "Reporte de Planilla ";
                                    var descripcion =
                                        "Descripción del reporte: Planilla de los empleados";

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
                                    10]; // Ajusta el margen de la tabla aquí
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
                                    table.column(3).visible(false);
                                    // Imprimir
                                    $.fn.dataTable.ext.buttons.print.action(e, dt, node,
                                    config);
                                    // Restablecer la visibilidad de la columna después de imprimir
                                    table.column(3).visible(true);
                                }
                            },
                            {
                                extend: 'excelHtml5',
                                text: 'Excel',
                                title: 'Planilla IMPINFORMATICO',
                                messageTop: 'Reporte de planilla con todos los empleados',
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
        $(document).ready(function() {
            $('.js-example-basic-single').select2({});
        });
    </script>

@stop
