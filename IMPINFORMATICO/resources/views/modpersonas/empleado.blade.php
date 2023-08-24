@extends('adminlte::page')

@section('title', 'Empleados')

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
    

    // Filtrar los objetos con "NOM_OBJETO" igual a "VACACIONES"
    $objetosFiltrados = array_filter($Objetos, function($objeto) {
        return isset($objeto['NOM_OBJETO']) && $objeto['NOM_OBJETO'] === 'EMPLEADOS';
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
  <h1>Registro de Empleados</h1>
  @php
       $permisoInsertar = tienePermiso($permisosFiltrados, 'PER_INSERTAR');
  @endphp
  <button class="btn btn-dark me-md-2" data-bs-toggle="modal" data-bs-target="#addEmpleado" type="button" @if (!$permisoInsertar) disabled @endif><b>Agregar Empleado</b></button>
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


    <!-- Modal para agregar un nuevo Empleado -->
    <div class="modal fade bd-example-modal-sm" id="addEmpleado" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Personas</h3>
                        <button class="btn btn-close " data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <h4>Ingresar nuevo registro</h4>

                        <form action="{{ route('Post-Persona.store') }}" method="post" class="was-validated">
                            @csrf


                            <div class="mb-3 mt-3">
                                <label for="dni" class="form-label">Nombre</label>
                                <input type="text" class="form-control alphanumeric-input" name="NOM_PERSONA" required
                                    minlength="3" maxlength="50">
                                <div class="invalid-feedback">
                                    Por favor, ingresa un nombre válido (al menos 3 caracteres).
                                </div>
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="dni" class="form-label">Apellido</label>
                                <input type="text" class="form-control alphanumeric-input" name="APE_PERSONA" required
                                    minlength="4" maxlength="50">
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="dni" class="form-label">DNI</label>
                                <input type="number" class="form-control" name="DNI_PERSONA" required
                                    oninput="validateDNI(this)">
                                <div class="invalid-feedback">
                                    Por favor, ingresa un DNI válido de 13 digitos.
                                </div>
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="dni" class="form-label">RTN</label>
                                <input type="number" class="form-control" name="RTN_PERSONA" required
                                    oninput="validateRTN(this)">
                                <div class="invalid-feedback">
                                    Por favor, ingresa un RTN válido de 14 digitos.
                                </div>
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="TIP_TELEFONO" class="form-label">Tipo de Télefono</label>
                                <select class="form-control" name="TIP_TELEFONO" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Fijo">Fijo</option>
                                    <option value="Celular">Celular</option>
                                </select>
                                <div class="valid-feedback"></div>
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="dni" class="form-label">Número Télefono</label>
                                <input type="number" class="form-control" name="NUM_TELEFONO" required
                                    oninput="validateNUMERO(this)">
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="SEX_PERSONA" class="form-label">Sexo Persona</label>
                                <select class="form-control" name="SEX_PERSONA" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                </select>
                                <div class="valid-feedback"></div>
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="dni" class="form-label">Edad Persona</label>
                                <input type="number" id="tentacles" min="18" max="55" class="form-control"
                                    name="EDAD_PERSONA" required>
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="dni" class="form-label">Fecha Nacimiento Persona</label>
                                <input type="date" class="form-control" max="<?= date('Y-m-d') ?>"
                                    name="FEC_NAC_PERSONA" required>
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="dni" class="form-label">Lugar Nacimiento Persona</label>
                                <input type="text" class="form-control alphanumeric-input" name="LUG_NAC_PERSONA"
                                    required minlength="3" maxlength="50">
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="IND_CIVIL" class="form-label">Estado Civil</label>
                                <select class="form-control" name="IND_CIVIL" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Soltero">Soltero</option>
                                    <option value="Casado">Casado</option>
                                    <option value="Union Libre">Union Libre</option>
                                    <option value="Divorciado">Divorciado</option>
                                    <option value="Viudo">Viudo</option>
                                </select>
                                <div class="valid-feedback"></div>
                            </div>

                            <div class="mb-3 mt-3">
                            <label for="dni" class="form-label">Correo Electrónico</label>
                            <input type="email" id="email"
                                pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$" size="30"
                                class="form-control" name="CORREO_ELECTRONICO" required>
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="dni" class="form-label">Descripción Correo</label>
                                <input type="text" class="form-control alphanumeric-input" name="DES_CORREO" required
                                    minlength="7" maxlength="50">
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="NIV_ESTUDIO" class="form-label">Nivel de Estudio</label>
                                <select class="form-control" name="NIV_ESTUDIO" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Primaria">Primaria</option>
                                    <option value="Secundaria">Secundaria</option>
                                    <option value="Universitario">Universitario</option>
                                </select>
                                <div class="valid-feedback"></div>
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="dni" class="form-label">Nombre Centro de Estudio</label>
                                <input type="text" class="form-control alphanumeric-input" name="NOM_CENTRO_ESTUDIO"
                                    required minlength="4" maxlength="50">
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="dni" class="form-label">Municipio</label>
                                <select class="form-control js-example-basic-single" name="COD_MUNICIPIO"
                                    id="COD_MUNICIPIO" required>
                                    <option value="" selected disabled> Seleccionar Municipio </option>
                                    @foreach ($ResulMunicipio as $Municipio)
                                        <option value="{{ $Municipio['COD_MUNICIPIO'] }}">{{ $Municipio['NOM_MUNICIPIO'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="dni" class="form-label">Dirección</label>
                                <input type="text" class="form-control" name="DES_DIRECCION" id="direccionInput"
                                    required minlength="3" maxlength="50">
                                <p id="direccionError" style="color: red; font-size: 14px;"></p>
                            </div>

                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    var direccionInput = document.getElementById("direccionInput");
                                    var direccionError = document.getElementById("direccionError");

                                    direccionInput.addEventListener("input", function() {
                                        var regex = /^[A-Za-z0-9,.\s]+$/;
                                        var inputValue = direccionInput.value;

                                        if (!regex.test(inputValue)) {
                                            direccionError.textContent =
                                                "La dirección puede contener solo letras, números, comas y puntos.";
                                            direccionInput.setCustomValidity("Invalid");
                                        } else {
                                            direccionError.textContent = "";
                                            direccionInput.setCustomValidity("");
                                        }
                                    });
                                });
                            </script>


                            <div class="mb-3 mt-3">
                                <label for="dni" class="form-label">Sucursal</label>
                                <select class="form-control js-example-basic-single" name="COD_SUCURSAL"
                                    id="COD_SUCURSAL" required>
                                    <option value="" selected disabled> Seleccionar Sucursal </option>
                                    @foreach ($ResulSucursal as $Sucursal)
                                        <option value="{{ $Sucursal['COD_SUCURSAL'] }}">{{ $Sucursal['NOM_SUCURSAL'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="dni" class="form-label">Departamento Empresa</label>
                                <select class="form-control js-example-basic-single" name="COD_DEPTO_EMPRESA"
                                    id="COD_DEPTO_EMPRESA" required>
                                    <option value="" selected disabled> Seleccionar Departamento Empresa </option>
                                    @foreach ($ResulDeptoEmpresa as $DeptoEmpresa)
                                        <option value="{{ $DeptoEmpresa['COD_DEPTO_EMPRESA'] }}">
                                            {{ $DeptoEmpresa['NOM_DEPTO_EMPRESA'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="TIP_CONTRATO" class="form-label">Tipo de Contrato</label>
                                <select class="form-control" name="TIP_CONTRATO" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Temporal">Temporal</option>
                                    <option value="Permanente">Permanente</option>
                                </select>
                                <div class="valid-feedback"></div>
                            </div>


                            <div class="mb-3 mt-3">
                                <label for="PUE_TRA_EMPLEADO" class="form-label">Puesto Trabajo del Empleado</label>
                                <select class="form-control" name="PUE_TRA_EMPLEADO" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Gerente">Gerente</option>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Jefe de Planta">Jefe de Planta</option>
                                    <option value="Conserje">Conserje</option>
                                    <option value="Guardia">Guardia</option>
                                </select>
                                <div class="valid-feedback"></div>
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="dni" class="form-label">Fecha Ingreso</label>
                                <input type="date" class="form-control" max="<?= date('Y-m-d') ?>" name="FEC_INGRESO"
                                    required>
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="dni" class="form-label">Fecha Egreso</label>
                                <input type="date" class="form-control" name="FEC_EGRESO" required>
                            </div>


                            <div class="mb-3 mt-3">
                                <label for="dni" class="form-label">Número Seguro Social</label>
                                <input type="number" class="form-control" name="NUM_SEG_SOCIAL" required
                                    oninput="validateSEGURO(this)">
                                <div class="invalid-feedback">
                                    Por favor, ingresa un NÚMERO válido de 9 digitos.
                                </div>
                            </div>

                            <script>
                                function validateSEGURO(input) {
                                    const value = input.value;
                                    const maxLength = 9;

                                    if (value.length > maxLength) {
                                        input.value = value.slice(0, maxLength);
                                    }

                                    if (value.length === maxLength) {
                                        input.setCustomValidity(""); // Limpiar el mensaje de error personalizado
                                    } else {
                                        input.setCustomValidity("El NUMERO SOCIAL debe tener 9 dígitos.");
                                    }
                                }
                            </script>

                            <div class="mb-3 mt-3">
                                <label for="dni" class="form-label">Salario Base Empleado</label>
                                <input type="number" class="form-control" name="SAL_BAS_EMPLEADO" required>
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="dni" class="form-label">Nombre del Banco</label>
                                <input type="text" class="form-control" name="NOM_BANCO" required minlength="5"
                                    maxlength="50">
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="dni" class="form-label">Descripción Banco</label>
                                <input type="text" class="form-control alphanumeric-input" name="DES_BANCO" required
                                    minlength="5" maxlength="50">
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="dni" class="form-label">Número de Cuenta Banco</label>
                                <input type="number" class="form-control" name="NUM_CTA_BANCO" required
                                    oninput="validateCUENTA(this)">
                                <div class="invalid-feedback">
                                    Por favor, ingresa un Número válido de 8 dígitos.
                                </div>
                            </div>

                            <script>
                                function validateCUENTA(input) {
                                    const value = input.value;
                                    const maxLength = 8;

                                    if (value.length > maxLength) {
                                        input.value = value.slice(0, maxLength);
                                    }

                                    if (value.length === maxLength) {
                                        input.setCustomValidity(""); // Limpiar el mensaje de error personalizado
                                    } else {
                                        input.setCustomValidity("El Numero debe tener 8 dígitos.");
                                    }
                                }
                            </script>
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



    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif

    <!-- /.card-header -->
    <div class="table-responsive p-0">
        <br>
        <table id="empleado" class="table table-striped table-bordered table-condensed table-hover">
            <thead class="bg-dark">
                <tr>
                    <th>#</th>
                    <th style="text-align: center;">Nombre Completo</th>
                    <th style="text-align: center;">Sucursal</th>
                    <th style="text-align: center;">Departamento Empresa</th>
                    <th style="text-align: center;">Puesto Trabajo</th>
                    <th style="text-align: center;">Tipo Contrato</th>
                    <th style="text-align: center;">Fecha Ingreso</th>
                    <th style="text-align: center;">Numero Seguro Social</th>
                    <th style="text-align: center;">Sueldo Base</th>
                    <th style="text-align: center;">Accion</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ResulEmpleado as $Empleado)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
