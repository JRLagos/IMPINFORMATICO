@extends('adminlte::page')

@section('title', 'Tipos de Reportes')

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
<h1>Tipos de Reportes</h1>
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <button class="btn btn-dark me-md-2" data-bs-toggle="modal" data-bs-target="#addtiporeporte" type="button">Agregar
        Tipo de Reportes</button>
</div>

@stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
<!-- botones -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
@endsection


@section('content')
<!-- Modal para agregar un nuevo producto -->
<div class="modal fade bd-example-modal-sm" id="addtiporeporte" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">


            <div class="modal-header">
                <h3>Tipo de Reporte</h3>
                <button class="btn btn-close " data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h4>Ingresar nuevo tipo de Reporte</h4>

                <form action="{{route('Post-TiposReportes.store')}}" method="POST" class="was-validated">
                    @csrf


                    <div class="mb-3 mt-3">
                        <label for="dni" class="form-label">Tipo de Reporte</label>
                        <input type="text" class="form-control" placeholder="Ingrese el nombre del tipo de Reporte"
                            name="PV_NOM_TIP_ESTADISTICA_REPORTE" required>
                        <div class="valid-feedback"></div>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="dni" class="form-label">Descripcion</label>
                        <input type="text" class="form-control" placeholder="Ingrese una descripcion del Reporte"
                            name="PV_DES_ESTADISTICA_REPORTE" required>
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
    <table id="codigotiporeporte" class="table table-striped table-bordered table-condensed table-hover">
        <thead class="bg-dark text-center">
            <tr>
                <th style="text-align: center;">#</th>
                <th style="text-align: center;">Tipo de Reporte</th>
                <th style="text-align: center;">Descripcion del Reporte</th>
                <th style="text-align: center;">Accion</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ResulTipReportes as $TiposReportes)
            <tr class="text-center">
                <td>{{ $loop->iteration }}</td>
                <td class="text-nowrap">{{ $TiposReportes['NOM_TIP_REPORTE'] }}</td>
                <td class="text-nowrap">{{ $TiposReportes['DES_TIP_REPORTE'] }}</td>
                <td>
                    <button class="btn btn-primary btn-editar" data-id="{{ $TiposReportes['COD_TIP_REPORTE'] }}" data-nombre="{{ $TiposReportes['NOM_TIP_REPORTE'] }}" data-descripcion="{{ $TiposReportes['DES_TIP_REPORTE'] }}" data-toggle="modal" data-target="#modalActualizar">
                    Editar
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal" id="addreportes" tabindex="-1" role="dialog" aria-labelledby="addreporteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Nuevo Reporte</h3>
                <button class="btn btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('Post-Reportes.store')}}" method="POST" class="was-validated">
                    @csrf

                    <div class="mb-3 mt-3">
                        <label for="COD_TIP_REPORTE" class="form-label">Tipo de Reportes</label>
                        <select class="form-control js-example-basic-single" name="PB_COD_TIP_ESTADISTICA_REPORTE" id="PB_COD_TIP_ESTADISTICA_REPORTE" required>
                            <option value="" selected disabled>Seleccionar un tipo de reporte</option>
                            @foreach ($ResulTipReportes as $TiposReportes)
                            <option value="{{ $TiposReportes['COD_TIP_REPORTE'] }}" data-report-code="{{ $TiposReportes['COD_TIP_REPORTE'] }}">
                                {{ $TiposReportes['NOM_TIP_REPORTE'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3 mt-3">
                        <label for="PV_TIT_ESTADISTICA_REPORTE" class="form-label">Título del Reporte</label>
                        <input type="text" class="form-control" placeholder="Ingrese el Nombre del Titulo del Reporte"
                            name="PV_TIT_ESTADISTICA_REPORTE" required pattern=".{5,}" title="Ingrese al menos 5 caracteres">
                        <div class="valid-feedback">Título válido</div>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="PV_DES_ESTADISTICA_REPORTE" class="form-label">Descripción del Reporte</label>
                        <input type="text" class="form-control" placeholder="Ingrese el nombre del tipo de Reporte"
                            name="PV_DES_ESTADISTICA_REPORTE" required pattern=".{5,}" title="Ingrese al menos 5 caracteres">
                            <div class="valid-feedback">Descripción válida</div>
                    </div>

                    <input type="hidden" name="COD_USUARIO" value="{{ Auth::id() }}">

                    <div class="mb-3 mt-3">
                        <label for="PE_FOR_ENV_ESTADISTICA_REPORTE" class="form-label">Formato del Reporte</label>
                        <select class="form-control" name="PE_FOR_ENV_ESTADISTICA_REPORTE" required>
                            <option value="" selected disabled>Seleccione un formato</option>
                            <option value="XSLX">XSLX</option>
                            <option value="PDF">PDF</option>
                            <option value="CSV">CSV</option>
                        </select>
                        <div class="valid-feedback">Formato válido</div>
                    </div>

                    <input type="hidden" name="PV_URL_ARCHIVO" value="/DESCARGA">
                    <input type="hidden" name="PV_EMAIL" value="ejemplo@correo">
                    <input type="hidden" name="PE_FRE_ESTADISTICA_REPORTE" value="MENSUAL">

                    <div class="mb-3 mt-3">
                        <label for="indice_reporte" class="form-label">Indice del Reporte</label>
                        <select class="form-control" name="PE_IND_ESTADISTICA_REPORTE" required>
                            <option value="ENABLED" selected>ENABLED</option>
                            <option value="DISABLED">DISABLED</option>
                        </select>
                        <div class="valid-feedback"></div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-danger " data-bs-dismiss="modal">CERRAR</button>
                        <button id="btn-generar-reporte" class="btn btn-primary" data-bs="modal">ACEPTAR</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="container">
    <h1>Editar Tipo de Reporte</h1>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>
@endsection
@section('styles')
<style>
    div.dt-button-collection {
        width: 400px;
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
        border-bottom: 1px solid rgba(150, 150, 150, 0.5);
        font-size: 1em;
        padding: 0 1em;
    }
    div.dt-button-collection h3.not-top-heading {
        margin-top: 10px;
    }
    
</style>
@endsection

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
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.3/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.3/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

<script>
    
$(document).ready(function() {

    
    var table = $('#codigotiporeporte').DataTable({
        dom: '<"top"Bl>frt<"bottom"ip><"clear">',
        buttons: [
            {
                extend: 'collection',
                className: 'custom-html-collection',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        title: 'Tipos de Reportes',
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function(doc) {
                            var currentDate = new Date().toLocaleString();
                            var titulo = $('#PV_TIT_ESTADISTICA_REPORTE').val();
                            var descripcion = $('#PV_DES_ESTADISTICA_REPORTE').val();
                            doc.content.splice(0, 0, {
                                text: 'Título del Reporte:' + titulo,
                                fontSize: 16,
                                alignment: 'center',
                                margin: [0, 0, 0, 10]
                            });
                            
                            doc.content.splice(1, 0, {
                                text: 'Descripción:' + descripcion,
                                fontSize: 12,
                                margin: [0, 0, 0, 5]
                            });
                            
                            doc.content.splice(2, 0, {
                                text: 'Fecha y Hora: ' + currentDate,
                                fontSize: 12,
                                margin: [0, 0, 0, 5]
                            });
                        },
                        action: function(e, dt, button, config) {
                            $('#addreportes').modal('show'); // Abre el modal con el id "addreportes"
                            button.trigger();
                        }
                    },
                    {
                        extend: 'csv',
                        title: 'Tipos de Reporte',
                        exportOptions: {
                            columns: ':visible'
                        },
                        action: function(e, dt, button, config) {
                            $('#addreportes').modal('show'); // Abre el modal con el id "addreportes"
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        title: 'Tipos de Reporte',
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function(xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            $('row c', sheet).attr('s', '25');
                        },
                        action: function(e, dt, button, config) {
                            $('#addreportes').modal('show'); // Abre el modal con el id "addreportes"
                        }
                    },
                    'columnsToggle'
                ]
            }
        ],
        
        responsive: true,
        autWidth: false,
        language: {
            "lengthMenu": "Mostrar _MENU_ Registros Por Página",
            "zeroRecords": "Nada encontrado - disculpas",
            "info": "Página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Filtrado de MAX registros totales)",
            'search': 'Buscar:',
            'paginate': {
                'next': 'Siguiente',
                'previous': 'Anterior'
            }   
        }
        
        
    });
    
});

</script>

<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2({});
});
</script>
;
</script>
@stop