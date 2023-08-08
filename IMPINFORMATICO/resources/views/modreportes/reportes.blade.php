@extends('adminlte::page')

@section('title', 'Reportes')

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



<h1>Reportes</h1>
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <button class="btn btn-dark me-md-2" data-bs-toggle="modal" data-bs-target="#addreporte" type="button">Agregar Nuevo Reporte</button>
</div>
@stop


@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
@endsection

@section('content')
<!-- Modal para agregar un nuevo Reporte -->
<div class="modal fade bd-example-modal-sm" id="addreporte" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">


            <div class="modal-header">
                <h3>Nuevo Reporte</h3>
                <button class="btn btn-close " data-bs-dismiss="modal"></button>
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
                            <option value="XLSX">XLSX</option>
                            <option value="PDF">PDF</option>
                            <option value="DOC">DOC</option>
                            <option value="PNG">PNG</option>
                            <option value="JPG">JPG</option>
                        </select>
                        <div class="valid-feedback">Formato válido</div>
                    </div>
                    
                    <div class="mb-3 mt-3">
                        <label for="url_archivo" class="form-label">URL DONDE SE DESEA GUARDAR</label>
                        <input type="text" class="form-control" placeholder="Ingrese la URL" name="PV_URL_ARCHIVO" required>
                        <div class="valid-feedback">Url válida</div>
                    </div>                    

                    <div class="mb-3 mt-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" placeholder="Ingrese el Email" name="PV_EMAIL"
                            required>
                        <div class="valid-feedback">Email válido</div>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="frecuencia_reporte" class="form-label">Frecuencia del Reporte</label>
                        <select class="form-control" name="PE_FRE_ESTADISTICA_REPORTE" required>
                            <option value="" selected disabled>Seleccione una Frecuencia</option>
                            <option value="DIARIO">DIARIO</option>
                            <option value="SEMANAL">SEMANAL</option>
                            <option value="QUINCENAL">QUINCENAL</option>
                            <option value="MENSUAL">MENSUAL</option>
                            <option value="ANUAL">ANUAL</option>
                        </select>
                        <div class="valid-feedback">Frecuencia del reporte válida</div>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="indice_reporte" class="form-label">Indice del Reporte</label>
                        <select class="form-control" name="PE_IND_ESTADISTICA_REPORTE" required>
                            <option value="ENABLED" selected>ENABLED</option>
                            <option value="DISABLED">DISABLED</option>
                        </select>
                        <div class="valid-feedback"></div>
                    </div>


                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

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
    <table id="codigoreporte" class="table table-striped table-bordered table-condensed table-hover">
        <thead class="bg-dark text-center">
            <tr>
                <th style="text-align: center;">#</th>
                <th class="text-align: center;">NOMBRE USUARIO</th>
                <th class="text-align: center;">TIPO DE REPORTE</th>
                <th class="text-align: center;">TITULO DEL REPORTE</th>
                <th class="text-align: center;">DESCRIPCION</th>
                <th class="text-align: center;">FORMATO</th>
                <th class="text-align: center;">EMAIL</th>
                <th class="text-align: center;">URL</th>
                <th class="text-align: center;">FRECUENCIA</th>
                <th class="text-align: center;">ESTADO</th>
                <th class="text-align: center;">ACCION</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ResulReportes as $Reportes)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td>{{ $Reportes['NOM_USUARIO'] }}</td>
                <td>{{ $Reportes['NOM_TIP_REPORTE'] }}</td>
                <td>{{ $Reportes['TIT_REPORTE'] }}</td>
                <td class="text-nowrap">{{ $Reportes['DES_REPORTE'] }}</td>
                <td>{{ $Reportes['FOR_REPORTE'] }}</td>
                <td>{{ $Reportes['EMAIL'] }}</td>
                <td>{{ $Reportes['URL_ARCHIVO'] }}</td>
                <td>{{ $Reportes['FRE_REPORTE'] }}</td>
                <td class="text-center">
                    @if ($Reportes['IND_REPORTE'] =="DISABLED")
                    <span class="badge bg-danger">DISABLED</span>
                    @else
                    <span class="badge bg-success">ENABLED</span>
                    @endif
                    <!-- Botón para editar -->
                </td>

                <td>
                    <button type="button" class="btn btn-warning" onclick="" data-bs-toggle="modal"
                        data-bs-target="#UptHoraExtra"><i class="fa-solid fa-pen-to-square"></i>Editar</button>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
</div>

@stop

<div class="modal" id="updreporte" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h3>Hora Extra</h3>
                <button class="btn btn-close " data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h4>Actualizar Hora Extra del Empleado</h4>


                @csrf
                <div class="mb-3 mt-3">

                    <label for="dni" class="form-label">Codigo del Empleado</label>
                    <input type="text" class="form-control" placeholder="COD_EMPLEADO" name="COD_EMPLEADO" required>
                    <div class="valid-feedback">Correcto.</div>
                    <div class="invalid-feedback">Porfavor llena este campo.</div>
                </div>

                <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Descripcion</label>
                    <input type="text" class="form-control" name="DES_HOR_EXTRA" required>
                    <div class="valid-feedback">Correcto.</div>
                    <div class="invalid-feedback">Porfavor llena este campo.</div>
                </div>

                <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Cantidad Hora Extra</label>
                    <input type="text" class="form-control" placeholder="Cantidad" name="CANT_HOR_EXTRA" required>
                    <div class="valid-feedback">Correcto.</div>
                    <div class="invalid-feedback">Porfavor llena este campo.</div>
                </div>

                <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">FECHA HORA EXTRA</label>
                    <input type="date" class="form-control" placeholder="Fecha Hora Extra" name="FEC_HOR_EXTRA"
                        required>
                    <div class="valid-feedback">Correcto.</div>
                    <div class="invalid-feedback">Porfavor llena este campo.</div>
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
$('#codigoreporte').DataTable({
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
$(document).ready(function() {
    $('.js-example-basic-single').select2({});
});


</script>
@stop