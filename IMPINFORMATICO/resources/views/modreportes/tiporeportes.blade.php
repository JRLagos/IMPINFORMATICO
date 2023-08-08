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

<script>
   script: $('#codigotiporeporte').DataTable({
    dom: '<"top"Bl>frt<"bottom"ip><"clear">',
        buttons: [
            {
                extend: 'collection',
                className: 'custom-html-collection',
                buttons: [
                    '<h5>Exportar</h5>',
                    'pdf',
                    'csv',
                    'excel',
                    '<h5 class="not-top-heading">Columnas Visibles</h5>',
                    'columnsToggle',
                ],
            },
        ],
    responsive: true,
    autWidth: false,
    "language": {
        "lengthMenu": "Mostrar  _MENU_  Registros Por Página",
        "zeroRecords": "Nada encontrado - disculpas",
        "info": "Pagina _PAGE_ de _PAGES_",
        "infoEmpty": "No records available",
        "infoFiltered": "(Filtrado de MAX registros totales)",

        'search': 'Buscar:',
        'paginate': {
            'next': 'Siguiente',
            'previous': 'Anterior'
        }

    }
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