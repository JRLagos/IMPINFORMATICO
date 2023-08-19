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
            var table = $('#direccion').DataTable({
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
                    title: 'IMPINFORMATICO | Direcciones',
                    customize: function(doc) {
                        var now = obtenerFechaHora();
                        var titulo = "Reporte de Direcciones de los Empleados ";
                        var descripcion =
                            "Descripción del reporte: Empleados de la empresa con su respectivo municipio y direccion";

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
                        // Ocultar la columna número 4
                        table.column(4).visible(false);
                        // Imprimir
                        $.fn.dataTable.ext.buttons.print.action(e, dt, node, config);
                        // Restablecer la visibilidad de la columna después de imprimir
                        table.column(4).visible(true);
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    title: 'Direcciones de los Empleados',
                    messageTop: 'Empleados con su respectivo municipio y direccion',
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

    </script>
@stop
