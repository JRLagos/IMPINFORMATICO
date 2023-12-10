@extends('adminlte::page')

@section('title', 'Generar Planillas')

@section('content_header')
<div class="d-grid gap-2 d-md-flex justify-content-between align-items-center">
        <h1><b>Generar Planillas</b></h1>
    </div>
@stop

@section('css')
    <!-- Enlaces CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
@stop

@section('content')

    <!-- Contenido principal de la página -->
    <form id="formularioGenerarPlanilla" method="POST" action="{{ route('Post-Planilla.Store') }}"> 
        @csrf
    <div class="container">
    <div class="row"> 
    <!-- Columna 1: Códigos de Empleados -->
    <div class="col-md-4">
        <div class="mb-3 mt-3">
            <label for="dni" class="form-label">Códigos de Empleados</label>
            <input type="text" name="COD_EMPLEADOS" id="COD_EMPLEADOS" class="form-control" style="width: 100%;" readonly>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mostrarEmpleados"><b>Seleccionar Empleados</b></button>
        </div>
        <!-- Campo oculto para almacenar los códigos de empleados -->
        <input type="hidden" name="codigosEmpleados" id="codigosEmpleados" value="">
    </div>

    <!-- Columna 2: Tipo Planilla -->
    <div class="col-md-4">
        <div class="mb-3 mt-3">
            <label for="dni" class="form-label">Tipo Planilla</label>
            <select class="form-control" name="TIPO_PLANILLA" style="width: 100%;" required>
                <option value="" selected disabled>Seleccione una opción</option>
                <option value="ORDINARIA">ORDINARIA</option>
                <option value="AGUINALDO">AGUINALDO</option>
                <option value="CATORCEAVO">CATORCEAVO</option>
            </select>
            <div class="valid-feedback"></div>
        </div>
    </div>

    <!-- Columna 3: Periodo -->
    <div class="col-md-4">
        <div class="mb-3 mt-3">
            <label for="dni" class="form-label">PERIODO</label>
            <select class="form-control" name="PERIODO" style="width: 100%;" required>
                <option value="" selected disabled>Seleccione una opción</option>
                <option value="MENSUAL">MENSUAL</option>
            </select>
            <div class="valid-feedback"></div>
        </div>
    </div>
</div>

        

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Nombre Planilla</label>
                    <input type="text" class="form-control alphanumeric-input" pattern="[A-Za-z].{3,}" name="NOMBRE_PLANILLA" id="nombre_planilla"placeholder="Escriba aquí." required minlength="4" maxlength="20" style="width: 500px;" >
                    <span class="validity"></span>
                </div>
            </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Fecha Desde</label>
                    <input type="date" class="form-control alphanumeric-input" name="FEC_INICIAL" placeholder="Escriba aquí." required minlength="4" maxlength="20" style="width: 500px;" />
                    <span class="validity"></span>
                </div>
            </div>
    
            <div class="col-md-6">
            <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Fecha Hasta</label>
                    <input type="date" class="form-control alphanumeric-input" name="FEC_FINAL" placeholder="Escriba aquí." required minlength="4" maxlength="20" style="width: 500px;" />
                    <span class="validity"></span>
                </div>
            </div>
            <br>
        </div>

        <div class="row">
            <div class="col-md-12 text-center mt-3">
                <button type="submit" class="btn btn-success btn-lg"><b>Generar Planilla</b></button>
            </div>
    </div>
    </div>
    </form>

    @if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            {{ $error }}
        @endforeach
    </div>
@endif



    <!-- Modal para mostrar empleados -->
<!-- Modal para mostrar empleados -->
<div class="modal fade bd-example-modal-xs" id="mostrarEmpleados" tabindex="-1" role="dialog" aria-labelledby="employeeModalLabel" aria-hidden="true">
    <!-- Contenido del modal -->
    <div class="modal-dialog" role="document" style="max-width: 80%; margin-left: auto; margin-right: auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="employeeModalLabel">Listado de Empleados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-primary" onclick="selectAll()">Seleccionar Todos</button>
                <table id="tablaEmpleados" class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <tr>
                            <th style="text-align: center;">#</th>
                            <th>Nombre</th>
                            <th>Puesto</th>
                            <th>Seleccionar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ResulEmpleado as $Empleado)
                            <tr>
                                <td style="text-align: center;">{{ $loop->iteration }}</td>
                                <td style="text-align: center;">{{ $Empleado['NOMBRE_COMPLETO'] }}</td>
                                <td style="text-align: center;">{{ $Empleado['PUE_TRA_EMPLEADO'] }}</td>
                                <td style="text-align: center;">
                                    <input type="checkbox" class="seleccionarEmpleado" data-id="{{ $Empleado['COD_EMPLEADO'] }}" data-nombre="{{ $Empleado['NOMBRE_COMPLETO'] }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarSelecciones()">Guardar Selecciones</button>
            </div>
        </div>
    </div>
</div>  

@stop

@section('footer')
    <!-- Pie de página -->
@stop

@section('js')
    <!-- Enlaces JS -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Tu script personalizado -->
    <script>
        function updateSelectedEmployees() {
        // Get all selected checkboxes
        var selectedCheckboxes = document.querySelectorAll('.seleccionarEmpleado:checked');

        // Extract employee codes from selected checkboxes
        var selectedEmployeeCodes = Array.from(selectedCheckboxes).map(function (checkbox) {
            return checkbox.getAttribute('data-id');
        });

        // Update the value of the COD_EMPLEADO[] input field
        document.getElementById('COD_EMPLEADO').value = selectedEmployeeCodes.join(', ');
    }

    // Function to select all checkboxes
    function selectAll() {
        var checkboxes = document.querySelectorAll('.seleccionarEmpleado');
        checkboxes.forEach(function (checkbox) {
            checkbox.checked = true;
        });

        // Update the selected employees when 'Select All' is clicked
        updateSelectedEmployees();
    }

    function guardarSelecciones() {
        var checkboxes = document.getElementsByClassName('seleccionarEmpleado');
        var selecciones = [];

        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                selecciones.push({
                    id: checkboxes[i].getAttribute('data-id'),
                    nombre: checkboxes[i].getAttribute('data-nombre')
                });
            }
        }

        // Obtén solo los IDs de los empleados seleccionados
        var codigosEmpleados = selecciones.map(e => e.id);

        // Actualiza el valor del campo COD_EMPLEADOS con los IDs de los empleados
        document.getElementById('COD_EMPLEADOS').value = codigosEmpleados.join(', ');

        // Almacena los códigos de empleados en el campo oculto
        document.getElementById('codigosEmpleados').value = JSON.stringify(codigosEmpleados);

        // Cierra el modal
        $('#mostrarEmpleados').modal('hide');
    }

    </script>

@stop