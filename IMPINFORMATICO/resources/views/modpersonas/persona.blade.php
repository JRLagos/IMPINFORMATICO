
@extends('adminlte::page')

@section('title', 'Personas')

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
        $objetosFiltrados = array_filter($Objetos, function ($objeto) {
            return isset($objeto['NOM_OBJETO']) && $objeto['NOM_OBJETO'] === 'PERSONAS';
        });

        // Filtrar los permisos de seguridad
        $permisosFiltrados = array_filter($Permisos, function ($permiso) use ($usuario, $objetosFiltrados) {
            return isset($permiso['COD_ROL']) && $permiso['COD_ROL'] === $usuario['COD_ROL'] && isset($permiso['COD_OBJETO']) && in_array($permiso['COD_OBJETO'], array_column($objetosFiltrados, 'COD_OBJETO'));
        });

    $rolJson = json_encode($usuarioRol, JSON_PRETTY_PRINT);
    $credencialesJson = json_encode($usuario, JSON_PRETTY_PRINT);
    $credencialesObjetos = json_encode($objetosFiltrados, JSON_PRETTY_PRINT);
    $permisosJson = json_encode($permisosFiltrados, JSON_PRETTY_PRINT);

  
@endphp


    @php
        function tienePermiso($permisos, $permisoBuscado)
        {
            foreach ($permisos as $permiso) {
                if (isset($permiso[$permisoBuscado]) && $permiso[$permisoBuscado] === '1') {
                    return true; // El usuario tiene el permiso
                }
            }
            return false; // El usuario no tiene el permiso
        }
    @endphp

    <div class="d-grid gap-2 d-md-flex justify-content-between align-items-center">
    <h1><b>Registro de Personas</b></h1>
        @php
            $permisoInsertar = tienePermiso($permisosFiltrados, 'PER_INSERTAR');
        @endphp
        <button class="btn @if (!$permisoInsertar) btn-secondary disabled @else btn-success active text-light @endif btn-lg" data-bs-toggle="modal" data-bs-target="#addPersona" type="button"
            @if (!$permisoInsertar) disabled @endif><b>Agregar Persona</b></button>
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
<div class="modal fade bd-example-modal-sm" id="addPersona" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Agregar Persona</b></h5>
                    <button class="btn btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- Pestañas -->
                    <ul class="nav nav-tabs" id="myTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="datosPersonales-tab" data-toggle="tab"
                                href="#datosPersonales" role="tab" aria-controls="datosPersonales"
                                aria-selected="true"><b>Datos Personales</b></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="infoLaboral-tab" data-toggle="tab" href="#infoLaboral" role="tab"
                                aria-controls="infoLaboral" aria-selected="false"><b>Información Laboral</b></a>
                        </li>
                    </ul>


    <form id="formularioPrincipal" action="{{ route('Post-Persona.store') }}" method="post" class="was-validated">
    @csrf
    <!-- Contenido de las pestañas -->
    <div class="tab-content" id="myTabsContent">
        <!-- Pestaña 1: Datos Personales -->
        <div class="tab-pane fade show active" id="datosPersonales" role="tabpanel" aria-labelledby="datosPersonales-tab">
            <!-- Campos del formulario de Datos Personales -->
            <!-- ... -->
                            <div class="form-group">
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
                                <label for="SEX_PERSONA" class="form-label">Sexo</label>
                                <select class="form-control" name="SEX_PERSONA" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                </select>
                                <div class="valid-feedback"></div>
                            </div>

                      
                            <div class="mb-3 mt-3">
                                <label for="dni" class="form-label">Fecha Nacimiento</label>
                                <input type="date" class="form-control" max="<?= date('Y-m-d') ?>"
                                    name="FEC_NAC_PERSONA" required>
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="dni" class="form-label">Lugar Nacimiento</label>
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
        </div>


        <!-- Pestaña 2: Información Laboral -->
        <div class="tab-pane fade" id="infoLaboral" role="tabpanel" aria-labelledby="infoLaboral-tab">
            <!-- Campos del formulario de Información Laboral -->
            <!-- ... -->
                        <div class="form-group">
                           <label for="nombre">Sucursal:</label>
                            <select class="form-control js-example-basic-single" name="COD_SUCURSAL"
                                    id="COD_SUCURSAL" required>
                                    <option value="" selected disabled> Seleccionar Sucursal </option>
                                    @foreach ($ResulSucursal as $Sucursal)
                                        <option value="{{ $Sucursal['COD_SUCURSAL'] }}">{{ $Sucursal['NOM_SUCURSAL'] }}
                                        </option>
                                    @endforeach
                         </select>
                        </div>   

                             <div class="form-group">
                              <label for="nombre">Departamento Empresa</label>
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

                       <div class="form-group">
                          <label for="nombre">Fecha Ingreso:</label>
                          <input type="date" class="form-control" min="2015-01-01" max="<?= date('Y-m-d') ?>" name="FEC_INGRESO" required>                                  
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
                     </form>
                 </div>
                     <div class="modal-footer">
                        <!-- Botones de cerrar y aceptar -->
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">CERRAR</button>
                        <!-- Botón de ACEPTAR -->
                        <button class="btn btn-primary" type="submit" form="formularioPrincipal">ACEPTAR</button>
                    </div>
                </div>
                </div>                  
            </div>
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
        <table id="persona" class="table table-striped table-bordered table-condensed table-hover">
            <thead class="bg-cyan active">
                <tr>
                    <th style="text-align: center;">#</th>
                    <th style="text-align: center;">Nombre</TH>
                    <th style="text-align: center;">DNI</th>
                    <th style="text-align: center;">Teléfono</th>
                    <th style="text-align: center;">Sexo</th>
                    <th style="text-align: center;">Edad</th>
                    <th style="text-align: center;">Fecha Nacimiento</th>
                    <th style="text-align: center;">Lugar Nacimiento</th>
                    <th style="text-align: center;">Accion</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ResulPersona as $Persona)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td style="text-align: center;">{{ $Persona['NOMBRE_COMPLETO'] }}</td>
                        <td style="text-align: center;">
                            @php
                                $dni = $Persona['DNI_PERSONA'];
                                $formattedDni = substr($dni, 0, 4) . '-' . substr($dni, 4, 4) . '-' . substr($dni, 8);
                            @endphp
                            {{ $formattedDni }}
                        </td>              
                        <td style="text-align: center;">{{ $Persona['NUM_TELEFONO'] }}</td>
                        <td style="text-align: center;">{{ $Persona['SEX_PERSONA'] }}</td>
                        <td style="text-align: center;">{{ $Persona['EDAD_PERSONA'] }}</td>
                        <td style="text-align: center;">{{ date('d-m-Y', strtotime($Persona['FEC_NAC_PERSONA'])) }}</td>
                        <td style="text-align: center;">{{ $Persona['LUG_NAC_PERSONA'] }}</td>
                        <td style="text-align: center;">
                            <button value="Editar" title="Editar" class="btn btn-warning" type="button"
                                data-toggle="modal" data-target="#UpdPersona-{{ $Persona['COD_PERSONA'] }}">
                                <i class='fas fa-edit' style='font-size:15px;'></i>
                            </button>
                        </td>
                    </tr>
                    
                    <!-- Modal for editing goes here -->

                    <div class="modal fade bd-example-modal-sm" id="UpdPersona-{{ $Persona['COD_PERSONA'] }}"
                        tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"><b>Editar Persona</b></h4>
                                    <button type="button" class="btn-close" data-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <form action="{{ route('Upd-Persona.update') }}" method="post"
                                        class="was-validated">
                                        @csrf

                                        <input type="hidden" class="form-control" name="COD_PERSONA"
                                            value="{{ $Persona['COD_PERSONA'] }}">

                                        <div class="mb-3 mt-3">
                                            <label for="dni" class="form-label">Nombre Completo</label>
                                            <input type="text" class="form-control alphanumeric-input" pattern=".{3,}"
                                                name="nombre_apellido" value="{{ $Persona['NOMBRE_COMPLETO'] }}" required
                                                maxlength="50">
                                        </div>


                                        <div class="mb-3 mt-3">
                                            <label for="dni" class="form-label">DNI Persona</label>
                                            <input type="number" class="form-control" name="DNI_PERSONA"
                                                value="{{ $Persona['DNI_PERSONA'] }}" required
                                                oninput="validateDNI(this)">
                                            <span class="validity"></span>
                                        </div>


                                        <div class="mb-3 mt-3">
                                            <label for="dni" class="form-label">RTN Persona</label>
                                            <input type="number" class="form-control" name="RTN_PERSONA"
                                                value="{{ $Persona['RTN_PERSONA'] }}" required>
                                            <span class="validity"></span>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="TIP_TELEFONO" class="form-label">Tipo de Télefono</label>
                                            <select class="form-control" name="TIP_TELEFONO" required>
                                                <option value="" style="display: none;" disabled>Seleccione una
                                                    opción</option>
                                                <option value="Fijo"
                                                    {{ $Persona['TIP_TELEFONO'] === 'Fijo' ? 'selected' : '' }}>Fijo
                                                </option>
                                                <option value="Celular"
                                                    {{ $Persona['TIP_TELEFONO'] === 'Celular' ? 'selected' : '' }}>Celular
                                                </option>
                                            </select>
                                            <div class="valid-feedback"></div>
                                        </div>


                                        <div class="mb-3 mt-3">
                                            <label for="dni" class="form-label">Número Télefono</label>
                                            <input type="number" class="form-control" name="NUM_TELEFONO"
                                                value="{{ $Persona['NUM_TELEFONO'] }}" required
                                                oninput="validateNUMERO(this)">
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="TIP_TELEFONO" class="form-label">SEXO</label>
                                            <select class="form-control" name="SEX_PERSONA" required>
                                                <option value="" style="display: none;" disabled>Seleccione una
                                                    opción</option>
                                                <option value="Masculino"
                                                    {{ $Persona['SEX_PERSONA'] === 'Masculino' ? 'selected' : '' }}>
                                                    Masculino</option>
                                                <option value="Femenino"
                                                    {{ $Persona['SEX_PERSONA'] === 'Femenino' ? 'selected' : '' }}>Femenino
                                                </option>
                                            </select>
                                            <div class="valid-feedback"></div>
                                        </div>


                                        <div class="mb-3 mt-3">
                                            <label for="dni" class="form-label">Edad</label>
                                            <input type="number" class="form-control" name="EDAD_PERSONA"
                                                value="{{ $Persona['EDAD_PERSONA'] }}" required>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="dni" class="form-label">Fecha de Nacimiento</label>
                                            <input type="date" class="form-control" max="<?= date('Y-m-d') ?>"
                                                name="FEC_NAC_PERSONA"
                                                value="{{ date('Y-m-d', strtotime($Persona['FEC_NAC_PERSONA'])) }}"
                                                required>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="dni" class="form-label">Lugar de Nacimiento</label>
                                            <input type="text" class="form-control alphanumeric-input"
                                                name="LUG_NAC_PERSONA" value="{{ $Persona['LUG_NAC_PERSONA'] }}" required
                                                minlength="3" maxlength="50">
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="IND_CIVIL" class="form-label">Estado Civil</label>
                                            <select class="form-control" name="IND_CIVIL" required>
                                                <option value="" style="display: none;" disabled>Seleccione una
                                                    opción</option>
                                                <option value="Soltero"
                                                    {{ $Persona['IND_CIVIL'] === 'Soltero' ? 'selected' : '' }}>Soltero
                                                </option>
                                                <option value="Casado"
                                                    {{ $Persona['IND_CIVIL'] === 'Casado' ? 'selected' : '' }}>Casado
                                                </option>
                                                <option value="Union Libre"
                                                    {{ $Persona['IND_CIVIL'] === 'Union_Libre ' ? 'selected' : '' }}>Union
                                                    Libre</option>
                                                <option value="Divorciado"
                                                    {{ $Persona['IND_CIVIL'] === 'Divorciado' ? 'selected' : '' }}>
                                                    Divorciado</option>
                                                <option value="Viudo"
                                                    {{ $Persona['IND_CIVIL'] === 'Viudo' ? 'selected' : '' }}>Viudo
                                                </option>
                                            </select>
                                            <div class="valid-feedback"></div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal"><b>CERRAR</b></button>
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
    </div>
</div>
@stop


@section('footer')

   <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.1.0
    </div>
 <strong>Copyright &copy; 2023 <a href="https://www.unah.edu.hn" target="_blank">UNAH</a>.</strong> <b>All rights
        reserved.

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
            var table = $('#persona').DataTable({
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
                                title: 'Reporte de Personas Imperio Informatico',
                                orientation: 'landscape',
                                customize: function(doc) {
                                    var now = obtenerFechaHora();
                                    var col11Index = 11;

                                    doc.header = [{

                                        columns: [{
                                                image: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAPsAAAE1CAYAAAAh55bWAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAALuJSURBVHhe7Z0H3JZj+8cfQnsP7SHtVEokklBCEmULke1P9uY1Xnu/9p4ZoVA2GdlSZshqqbTTUqr/73t2/27nc3U/9aSyun6fz3Gf6ziPcx3HOa5156VIkSJFihQpUqRIkSJFihQpUqRIkSJFihQp1jLWy7gpUqwRLF26tMiPP/64YbFixYrMmzdvg8WLFy8lfuHChUvKly+/ZOLEiYvatGnz23rrrRfiU/x5SI09RaEwduzY4osWLSozffr0UqLSv/zyy8a//vprecWVFZWSUZcQlZa/HHzyF99www3XL1KkyNINNthg6frrr4+BL5J/7kYbbTRHaXOKFy8+Q5PCTPHMln+6JoOfSpcuPVNxs6tUqbJQ/AszxadYA0iNPcVy0Opb8ueffy4/YcKEyjLyZlOmTGk1e/bsejLYiqJyMsJSMtZSMtLiCm+k1Xwj+eVdP09pGSl5eYRl2IGIj9MyWCweDBqah9FL1izFTVWemTL87ypXrvxFyZIlx4omlClTZobCv4ScKVYZqbGnyPvuu+/KiqqPHz++yeTJk1tPmzatpVbt6jK6ijK6siVKlCgrdz0ZYp5W5jwZejBkSAYajBh/0piJg9885jMcBy1ZsiSkUQYuYe0OcGcqfabkTNXqP0kG/1mpUqU+kftJpUqVfhLNzohLsRKkxr6O4oMPPqj1+eefNxgzZkx7bcvb/Pbbb/VlZFVk1BVl3BsULVo0a6gYH5Q0Wqc5zvG4ADfOnyvdfuKBjd1hQByGD8m/RDRDdZusun4jw39Tq/3b5cqV+65mzZrTMllS5EBq7OsQhg4dWvPrr79uPmrUqD1mzpzZXCtlPRlNRZ2Ri8nAs8ZtstHZaG2cudJAnG4keSHDccBpcdguhME7DmhyCnFa+ecrOFG7jdEy/Nfr1as3WP4fqlWrNncZZwrj995L8a/EsGHDqn/44Yeb/fTTTx20gndQVH2t2tVk3OvL2IPBaYUMLltnjBOjJ4wfA8OfKww5jGsiDDDGXMaeJOA8cRwuMuyH4HOc/Rg+WLRo0QK14Xut8m+XL1/+ZZ35P6xbt+4E5VsUGNZxpMb+L4QMoMjjjz/e9L333tt7ypQp7bXSNZYBV9LKVxTDtnFjPDZsyCu7w7Fx228yTxwXpyVd+4HdZFxMcZz9sQswdMLUDb8nAYxfNENp32tCG6Zt/tM623+0rl/c+73nUvzjoVW89MiRI1vqLH7gjBkzti1ZsmQ9KXtJzt8QiC+uxdt2hzEYpzs+JozL5DD5QBwHYlkQiHlyEUjyAsvCJZ66cYYHjrcfwJMxeiUtHafw21WqVHm0du3a75QpU2ZqYFrHkBr7vwDvvPNOhddee63j999/v++8efO2lpFXl5FvgGGzimOMKD8Gj4FgKF7dnYax4IeIt6ED0vHjJimWURDBY1kgF08uArnyGU7j+EE8YdpBmLbjNxEnw58svvfLli07kLP9umb0qbH/gzF06NBKb7/9dscvvviit5S4rQy8erFixYLxoewQfhtu7EI2EMfHfhtVzAeBmJc0pzuPw/bH6SYQ50ny2x/H53KNWJaBkTuOdMJMdjJ6rtpzBb9/zZo1X5HxrxNX8fP3Top/BEaMGFHupZde2l7b9T6//vprOyltFZTZho4Rxit0TMQ5HhdjKMgPCON3PuB0h+13npiXuDjd7soozmt/7Fq+YbkxkmEDowcy+p/F80bp0qUHiV78t9+6y90bKf6WkJIWufnmm7f58MMPj50zZ06H8uXLV2c7jlJz6wwXI7fBE8YI8JviONyYnGY/iNMNp8eUK0+u8KoQoJ6goPQYcXySx6t8HE8c2/tFixaxnX9Vx597tMoPq1GjxrzA8C/D8j2W4m+JwYMHNxkyZMhx06dP31mGXV9Gvh6G4HM5LkqMUcVb95hWFGcDsD8Om4wkT0EynAc3TnfeXAScj3AsIw7H/HZBHJdMj/kM83ExT1v8cZI/UEZ/V/369Ucpftk9vX8Jlm99ir8Vvvrqq0r9+/ffU+fyPtqmt5Ghb4TCx2dyGzyrFGm5jB2FLsjYbQRWfOIdNp/TgMPkddhxIM4HcqWbiGeFNa/j7bfr/OYD+B1vJPMaST5A/emzuHwZ/RLRKPXng2XKlOFMPy4k/AuQv/Up/la46667tnj99dfPmD9//valSpWq5IdgbNwoK35cFBYjJ50wbi6ywdjvsJErzWEQx9nYQcwT50nKKIiMgtJwLQdgpMS5rcA8ScRb+DjdcRDy4riFCxfOUXCYVvmblP/VevXqLQgM/2Ckxv43xNtvv11lwIABB48dO3Z/GXgr0foYslfx2MhtAPgdRlmTYbuxH8Th2DWB2A9iHodNjrff6Y6L4+N0yH7qneSN02M/sGxAXhDz2dhBHG8XxH6XyQQgox9btGjROypWrHhruXLlpoeEfyh+b2GKvwUeeOCBls8///wFOj92lJFX8HkcssHbkGNjjsOOS/qB/XG6wyDmQ5795gPmtxtTrrg4vqD0ggh+EMfF4aTfIExek9MxfMM8uUAa7YdfBj9LUQMrVKhwrYz+s2Uc/zzk76EUfxl++OGHYvfdd1+v4cOHH6MVpD2KxrbdBp40dJTUrpU2Dpvi9GQcRB77HbZB4AfEWz7IJdNEHASScfY7zXFJvwnE/AXFG7EfEIbPsh0X+5NwHveBy1m0aNFSneVHlC5d+vKNN974RcX/416tXb61Kf508LLKgw8+eMqkSZP2laHXwKh52g0XeFXH2EwooV0rKGErsylOT8YB/HFaksf+ZNiuZeSKN3+ynk5zXNKfJPPH4ViOEacbcRwu+XLlNcyDG1+8c1hGz7b+3rJly95eqlSpiZls/wgs39oUfyoGDRrUVIZ+kRRppzJlypTFMNi6o2AYOQ/KoGjE22jsmkg3j/2Q04Fdxyf5kn5c54n9MV+cnsybjDc5fxwfxznerkHYrsnhJF+cBjBYx1s2cFwMwjZwjNt9jd+88s/UKj+wRIkSV1auXPmrEPkPQP6WpvhTcdVVV+2gVf0srRQdREX9BBzGjouSWdkctt+K6jj88KKoNnqnGebDtUKbiAdOt5uMS6bbNZkHOM5tMC+I868onnrG8ZDrbh7IiNuVTANxHDwx4njkYOD4qT9+AA9xCi9cvHjxq/JfWLVq1Q8Vv4zhb4z8PZHiT8O55567zxdffHG6DLuNV3Bv1+NtO4plig0esuLhwmsk0wF+k9MKIgCPZVoeYdKd3y5IhgH8cRtIS8okznmBw4b9ji+IjKScOD2XW1Aaxm6/6xnDYRn8cBn+ZdWqVXtWcX/rD2Tmb0GKtQ4pUZGTTz653zfffHNEyZIlG3E2L126dEjDEDB0XAw7XsFzGY7JccDh2AW50h2O4yDKieNwc+VP+k3miycswklewi7LBIgHcZxdEPMlZRbEZ8TpyXJiygXqygrvicBly+C/0bb+So3dgL/zN/FytyrFWoGUZL3jjz/+grFjxx4uQ6/J8+woEFfdUaJ4RY8NBdgfU6yc5nO8XYP8IJmGC5FuP+nJ/HFc0jWBOJzL2HPlBQ7Hfodxk3EgF5/bCWLemCd2QSwHIlwQkvmdR+M3TkZ/s8bwzr/r/fiCW5VijYLvrh999NFXfPfdd0eXKlWqJgaOcXM+X7RoUbj6jqKaYgVMKmOuOJAMA/xW3mR6QWEmHiluWMEA+V3eygBPzB+7JtpHXGHkGa5LUn6Skojjc7n250KyHIDrMXI8PBrLWoo7WSv86VOmTKkemP9mKLilKdYYtGUvc8UVV1w4ceLEA8uWLVsZI5fBBwVm9YMw+liRrGixwiX9VjZgf8zjeBDzx+n47cZ5CCfzOJzLdb7YEIh3WxyOeR3vcOw3zG/emMfy7Kc/IfM5r/OA2J+UCRyGnB5PNHadDlxmpg6/yOCflHth+fLlfwwMfxMsq22KtYbPP/+81JVXXnnxhAkTDsLQMWouxrF62jAwfoDRozAmKxWwMjkuGZ/kBzFPMs0KCnAJQ0mQlpSfJJ9jIfxxGMRuQbwxkEl59I3hPEk43mlxXQ3S4vpavv3A+XLlJ0xdPD5xWiwLiK+0xnN/xV05a9ashiHyb4LU2NciWNFvuOGG8ydNmrS/DL0SysJ2HeXAwCErNGkojJWmMP4YBcUXBHhtJBhcDOpkBbbMmDcmtvvwJol8sRtTLlh+XB6gLq4P5DqZ33lMRjJsvqQc4Do5Lk4Dcdh+y4jjHFZaUY3nXirzqtmzZzcJkX8D/N6iFGscxx133Dk6ox9fpkyZqqzonNNREowc4/ZKgWujTxqa480XKVRwzRfnMU8cXhEB8lOWw4C4WK7THYcLaI95Yjm4UCwDMhwPcrmxH95YjuNz+c2Ha2DslhHHw0ca9XTYcoDlOM55nQ843XGO5xFbTYbPK3xWhQoVPg2RfyF+b3WKNYpTTjnl8NGjR/fRil4VRcLYUQpcG4HJyoLfSkOcw+YxiLNLvPObciGOT/IQjpU09pNG+Z6QXJeYYt5YdlKeyXxJcjss1/FGLCNOj3liP3B6XG8jTovDhsOOs99yLDPmgwB1VDofGNlVwSunTZvWPCT8hUiNfS3g3HPP3WvkyJEnlitXrj7hkiVLBmNhBcwowXJKkktpCiJg11hRfK40+6mPt/H42ZZTPxt3XC/STcD5csE8sbuiOMNlQZQdH3cIG5Tt/PCSDuFPwrKSaYSTFMfHSMY5HPcPcHt8xAGK66LwFdrSNw4RfxFSY1/DuPbaa7cZPnz4qeXLl98MBeBiHEBhUQArbZKsMKZccRBYUfzKkOQh7DpQN+ppWHFtVPbbJa/DoKDy4zyFoRg2akAdqR8TEaC8ZJnuN5BLLmlur3lzyQHJNLuWR9gyCFNX19e8QPXlTzF3njdv3n/mzp1bIxP9pyM19jWIBx98sNFLL710QdGiRbdCIX0v3SsOcRAKEhu9FQPXZMQKCexHoYyYP46PEfMA81meZSaNK5ZHmuF42mGK65oMgzhsP4h5cJEdk+sU1y1e7Z2HdIg497XlJhGXaZnkQybx+E3mjf0g9gPLwXWa66z6FlF491mzZp05c+bMCoHxT0Zq7GsIQ4cOrfrEE09cJEPvICNf38oI2cDtWhFMwC6I/QVhZTyFkbGqQKYpNgQDpY4VviDKlV4QXJ4BLwYEnAbF9SGdLTSuJwSQLBNyXlwj9gPCudLJ77qAmMdGbuBXOSXk3W/hwoUHKbxsy/cnIjX2NYCPPvpow/vvv/8kDWBnGXsxBtrbTRt8kqxAkJUN14oZ+61EcZ44bH8STs/Fk4u/MEBpkxQDucThug32240R1yPOuzKKy45lu2+BeeJ+N695nM/xcflxvNMcBzHOJtfFfMTlCqsOlbSV7zdlypROiv9jg/AHkRr7GsCAAQP2/emnn/bdaKONymPgXHHH2JPKYoqVDuASNpJ5gN2VIc5TEAorKxcs3zLisMltsQEYpNnNRU6LgYxYDunIdzwUGxZE/3oXlSsdctiI00xGMhwjNnRgv+uWBHWSbtRbsGDBxdKZzTPRfwpSY19N3HbbbVuMHDny+JIlS9ZBwVAK32ZLEmnJcEwFxRtJfy4yCkqLXfsLi2TdHDbsd3qs8PbHBhDzG85rxOFc8XG6ZTvOqzlIlh0jzge/8yfHI25vLA8XozcBeB3vMCAuU6c2Mvij/8zze2rsq4G33nqr9nPPPXeOzuhbMZis5hg6Rs+gxgpjsrIYyXAuFIbnz4BXsSQZDlvBk4aTbIfz2iU9lgec32mmWF6cDmIZjAXjYh6IvK4bcH2dZr4YcVws3yDOcmLEsgFhKGPwe8rYeyrv77dA1iJSY18N6Jx+5OLFizsxcN62e/uIS7wVC9dkEO+0WIGsWLGCGQWlkd8ycqWDZBjEvCbqg4tSxvEx3Bbqbzgctx3EdbNsEMsm3YZhXhD7ndf8AH8MZMTl+l439YHXxkYaYXiT9XScy7I/5ov7xvks2wTIg9/1AC5DOlPp119/PWHcuHGtMklrFb9rXopVwv/+97/OP/zww77avpdl4KwQSVgZgF3zWQkgpxmx0kBJZSKclOu4XBTnhSjTbpJy8ULIiXlweT3X8vH/9ttvfHo5T1vUQIQdRzokBc/Ki2FjshGZHBe7gDIJOx8GzaRruTZwynIYXqeTn7h4J+Z6Wa75IfidBjlsAvaTHiOORybl4Ff5zefOnXvEmDFjymdY1xry1yhFofDoo482v/rqq2+Vd1s//orCeFWPlQTXymG/4z34ELDyIo80I/Ybzus03GQccDiOs9/8SZjfaXapn0H9gY2DMH4MGz9GxwNFfIUHKleuXF7FihUDlS1bNq9MmTIhnheDYlCW+ymmZBx9hHwbsg0WUDZhQJ1tlIB8wPU0GXE59sdGTRjEcpME4HM45qVc4H4D8+bNmyL+8xo2bHiX3N+3AGsYy490ihXim2++KXrEEUfcPGrUqAMVLOZBRYmsCIaVBXhgY35cBt18hHFRDCOWaRnmsx9YmZDlOGBeyweW7zT7c7kxYl6nW5FJK1++fF79+vUDVa9ePa9WrVp5lSpVCoaOYdrQyIvffUY4l5FBzpNMnz59On9dnactcHbXADB0iEmYbwZ4gqE+1apVC/926/K96/DdE3YcgDSXB+B3/8Zg7OJ4XIh87hPgPiKN8pDvXQ7lEDdnzpyRmgQPr1u37sch01rAstqkKDROO+20bv37979u2rRpm7JNXVOwYgD8cTiG06xM5sONlc1x9hMPHE6iIN6YP1ZgeFBUjHizzTbLa9WqVV7Tpk2DwWPcrNwYAyus88APAcclDQvXYShp7HYxzJ9++invnXfeyXv11VfzPvnkkzyNSUjDcAF5eYrRhr/xxhuHCWiLLbbI23bbbYOfepKOwVk27TTcF4aNNheBZNggTF7npzyv7sTNnz9/sep7Y+XKlf+ztr5j9/tIplgpPv/8843OPvvsu4YNG9Z7xowZQZFjxUiCgUR5IPvJw4sxkBURg/HqgoLihw/lszHYtUI6Hb/jgcuD32mxm/RD8JrfYXgow37q7zjzUV/qjoFTZ4h4+JzPvPa7H+J0x8X8Dsf1chwgnroA8g8fPjzvqaeeynvttdf4d50QXxDIS1032WSTvC5duuR16NAhr02bNnm1a9cOsjBE3HjXxTjjkuYwsAu/CTgeXkCYNFzvCEjDD2VW+h+kF4fVq1fv9ZBpDSM19lXAJZdcspuU6WatKnWsBCg85HCsxDYMh+N4jMTpuM4X+wHpwHGWQRjgNxlxHSwHRYt5IeIoD0KJ7Y95AC71tcIikzIg0nCd12nA6cS5HsCyibO/IDJP7II4L36v5l9//XXewIEDeU8hb9KkSSEd4LoP7NoguW7AzgTD32+//fKaNGkS0tm5wWs+yiDMsQEDpb2eEHBJg4DzuDwIHuB+dBxh+h+SrNu0AzlLE+jMwLwGkRp7IfHGG29Uu/rqq++WdxfOfQwiqwP+WMlj42cwHQ+/ibANAjgewA8B8sf5knyG4wB+0mL+mAz88FnpbCwoHO2y8dvI4zpbvttF2H0AXFacnkyL4+2P0+2P02M+3DiPw67nF198kXfHHXfkPfHEE5yHQ/2SBmg4HnCu79WrV97BBx+ct/nmm2cNEX5WX/JClDFv3rwwUcDjfrTcOJwrzoaPa4PH1UIyUUeOE+rXr/9EYFiD+H30U6wQhx566BlffvnlmaVLly5HGOVhoBk4K5iVLvZDVhAPtNNA7GfA47BBniTgywV4Xabz4bdCJ2XBC6HQgHZxHuaKOdtclJ92oohul8nlQHEf4JJGmZYPAeeJ42NZjjMvSKaDXHVxPG3Apa2DBg3Ku/7668M233zuI9rMJEfbiIv7hvM8q/yxxx4b+sAGjwz3FTLIa5Dufgb4HUc+4HCcBjGREEae/E9oK3+0xmBayLSGkBp7IXDjjTduecUVV9wrJWpqZWGA4hXcSgfsgthvPuexHJDki+G0ON75DKehLLF8QH77YxnEx3LYnnI7rEWLFnktW7YMCs/OhWsLyXyUAeGHbOBJv/kgI5lmGY4jP0QYJHmB/Y53GHLb2aEwUY0fPz7vwgsvDFt754Xgof0Q5XlCY1x98ZWz/CmnnJK3++67hzT6iMkEg8edP39+iDeQ5fJN7mPXLeahTNfBE4pkTtU4HNOwYcM1urr/rmEpCoTOcneOGDHikKlTp2Yfa7RieeAKA/itZA4bxMVhkAwXFs6Xq5wkSIMPBa9bt25ep06dwq0zGznG4gtvhg3LBonS24AA8ZD54jT7KTMZb9dynZ70A8flSqMtjAthy8K95ZZb8v773/+Gq/aEzWMX8jg4jjB9cMghh+SdffbZeVWqVMneogOkO4/91omYzGs+7whs7MQxkZCOfBn+UzVr1jy2atWqkwPjGkDBWpAiQGe+xjqrP/b++++38KD9EaCMGA/EORhlQykhBhiDslHBGysprv2kAQyMOOB0kFR8+5OELICLslE223aurFMn6olLOu2mPOD8cR3jMl3HmK+g9JjPhkC6EedxvjjdeR2PayN1fYkDlvPMM8/k9evXL9y2A3Eej2+uOLDDDjuEyYJdDwbpdBsrLiA/hotLfEzOY7Kx2wVs6bW6z9SEe3Lz5s3vDZFrAKmxrwSnn376McOGDbtMq0H4O2UG0C7E4JkcB5JhXAyIFRMjQhltTKQ57DzEW4bdgsq1fEDYfM4Xx6NQTkPZYoOG8LOS4QJcy8G130QY2A9/7I/zO95+h4HjXS4gDOI8lg8Rb8oVjuPws03mlucbb7yRt+++++ZNnjw5m+62+zxeEBo3bsynx8IOiAt/wDIgDNVwn9qI8ceIjTwm6sBkIffJRo0aHbmm/k4qNfYVQEpR7+KLL36oVKlS7TEArxbe2hJmgPFbCXGtsLEfkE4eBj1WRIBrXvykG+aJ8zjOLnC8+eI4KzNpvhgU8xsYv5WSNPKYJ+a3H1huTOZL+nMRwIXP5TmOcLI+xNOPcV7gcuLy7Pe2mXyM19ChQ/P69OmTN2bMmCATwGcDTMJlY4g8jXfjjTeGW3WEbaTkQz79Cy9xANdtsAucL0nIhLS6Ty5btuxRzZo1ezqTZbXwu6akWA7HHXfcqZ999tn5WpFLowgARcEgvAoDXBODjGLEBOx3njjerv0gV7phf6w4gLDr4TCAH0IZqb/OgeEpt6Rs3Lh+Dttvo3DYfuLNZz/AdX/gj8l8kOXF4WRaTMDGHssHcR774zQbJPl4COfQQw/N3poj3cabC5ZLv3KFnlt7PJDDxTz0wZMoiGXgj+ORYT/xuCbqh0s9kKfjwoPaTRy/Jp6qW1ZqiuXw9NNP1zvrrLPu18B08ABbQe0C4mNl8kACFMgDCuI04PgVoSAe5CYBL0oS1w1QLvE8GrrVVlvlbbrpplmFxwXOA6/ries22e/4mMyDG5P7KVcacaRDsRzCwHmB4+EBtMtyLAO/5cTyAH7aifEw2dEXyMBA//e//+WdeeaZ4QyOHOJz9W1SHjLq1avHa87h7gX33OMycEEsDz9kOM06YkPHj3z8mojGVa5cuY8M/tVMtj+M1NgLwFFHHXXEkCFDLps4cWJFlIDBszIABtzwYMZxuUBeyHyWFSNX3JoAV9p33nnn8EgoysiFOC4Uujwbj+uXi6zsuISB45MEYiN0vONifyzfLmm50olzGOAmeeN4tw9DxJjg8VgCVmVurd17771hHMmXawyINwF44G/Xrl3e7bffHvqVc7Zluywbb0wxSDePjd2EwWee4rupffv2J6rs5WehVcCymqfIh5EjR5a85JJLbn3uued6M2OvCWBgXKBD6UwoBcrjsJUpqdSOw4UPoBzEQUlwTSGenDBqbqfVqFEjvBDCRSrqg0K5XPhwgct2XJJcF/gAfJYDiHfYvK4rftLcDuLitlqm/TGfeWNZwHmJg9/y4vrjh4CNy2ljx44NT83pyJblzQXSgPPa3XvvvcMZnnLpd+IwXAM+UzLsOK/khG3ojtPZ/aPq1avv36BBg28D8x9Eauw58OSTTza//vrrH5cSNPG9TwYB10oWk5ErHn4Mi6vwGBlbRxSSOFzSiXOYfMS5HFwrL37zQFZ8w354UBLS47wYve8GWMmc7rDlOg4XWLZlJV3DdXIcYbcTXoi4mIhL8gLLicn8+C0PP7DsuDy3C5c+MfDDw0MxTMLaxeX17t07+zz8qoCx4wo9T9yhLwBjp3yAvJhyxcGPS70gDN0rvbbyv2iSPqNt27Z8Q+EP43dNTZHFOeecc8RHH310XenSpUvS2SgDimFDtULhEh8roOOSSgg5jUF1HvyxDOD8wOmxDOIgwpYH8FNfeKgfiodrxHIN0omzDMs0X+za73Rch+0iD9d+80GUQR96sol5cF0HjIc2uC2k41pOHMYfk+MoAz8yYjIoi1WYsrwLOvroo/MefvjhDMeqgesg/fv3D+d4JhDXH1BWTIA0+3EJJw3exo48Gf/A1q1bH7E6j9Au2zOlyIJvwD/yyCPnaSvcnAHzAEEoTwzHMyieiU0oEHG4TscfE3ExcZEIA8VlhYHww4vLoNuN+QibH6I8lBilpw3IRvldZ5A0DsPxjisozeR4jJWyHEYu9XD9XEeufEO0iTbAAy/5OX5QTxsC/rgM+Fzf2IUo23HmhzxGSaIM+HHdPzVr1sx7/vnnQ/0KC8qgbJ7Koy3cf6cttM+gPCP2A9fHoD7AdaRulKG+qyD/J7fddtvXgeEP4PeRTBFw9dVXb64OfUozaF3CDBywUlmhcAF+u/aDOJwcYJArzojT8FMWLmSZKBZwvMFWfcsttwwXjOAlL8qI4rhOjgduj2Uk02KYN0nIx6VOv/zyS1B80+zZs/NmzZoVDAiDhwdeZDEhVahQIXxUgtuBECsjT/LxjL4NxvyQy3LYcZB5bTCG60a8+ys2KudBxrnnnpt30003hbTCgnzk54s4d911V1779u2zExmyXeaKCMR1xCVMHxDOTOK3N27c+OQaNWr8oQtJqbEnsOuuu54zYsSIc6Wk4ZNTgM72gDouF+I0DzIgnxHLdHouxGmWBeXym4drAp07d85r2LBhMBYuxnmFhw/DwB+DdiXlmOA3nB+QRj7CtA1D/u677/K+/fbbvClTpuTNnDkzGLl3HigsfKxSKLDLwkWW+4d7/9y/xuD5kgz3sJkAbNB24/pBTMi4jndZuOaxIUGUayLNKzvg1diuXbuGSWtVQL0oY//998+74oorsmUClwWScSbq7ToStkvf0Y/4NWl+1KxZs73VPz8GIauIgjV3HcQPP/xQrHfv3g+8//77e8fbsNWFt7hWxtgPrMhGnGZ+w3wog3cd8BDWmS6cHVlh/Iw7ac6DS9jKlSRk4JovBnXAKCgTwsB5m+zLL78Mhs6qPXfu3HC/GSKMkgLKywXKcBp3CiDiqDfPBGD03bt3z5OCh0kLXreJ+hDGdf+5zsTbcHAJkwY5LobrgEvbjjzySP7lJ5uHePMUBPLRP0ywvEPPvXfKoh84npBmObE8XPgcxh8T+UySNVM7zhPbtWv3QGBeRaTGHmHgwIF1r7322ie0srex4oCk8ifTGCgrBWDgGWDi8MdvkKGs5MGPksKDIsdn7KQCIwM/hN9lkAahFGzfWUVZ3dkaUyYKAiiTulme65sk5ADzmagLsqgjq/aoUaPCbSpv01FoVkKMfWWTJPKA68B363bccce8rbfeOvh9x8L1xWWXgoESpi6AvO4X6kb7bdiQjcVxcdtt7KQTBnYp+6WXXgpX5t1/hnmSQLb7DjBZ8EotW3nXw+2O6whw43qY33Hw06e4mQd3bt5hhx1OlbxV/gDi71qbgjeadnzttdce0KpS3YPDQKIAKJYpVjiIsP0AfsiDjAwrm/ktgwG1TPyWYRck8wJkkw+XOJSBMnGZWIiz4cGHbMtxOUlyfZ0HWcjByDFqtrj+sCOGjcsKzySDTOD8DucChsmnn3r27Bm260xO1N31YyKkLpTreIj4WC5x8NFe6kBe0k2kmcwfp9kP7NLen3/+OdxGY0JznPlzwXJx6bNGjRrxufGwu3IZpHk8HGd/XBeHY0ImEwf5ZfDvaAe3v3ZBY4OAVcDv+8MUeXXq1DlMSrMbWzEGGIVH4VBOCL8VEJd0/CghYVwoVlB4kGV5KCTEAOLCAwh70EHS9aAT9oqDH5kuA3m4xMPvsOGyY39M5MM1yIuCffXVV+FDjp9++ml4U4xz+YQJE4KhUxfa4HoCy8sFDGCPPfYIK6c/8IihMpngsnOAkMuFPXYMpFEWRBp1YoIwCFPXeCVGruvkfsU14nS7AB52RXyi+oMPPgjtiPPlAvk9jvipJ2/H8Vkr2mTE5SX9ucIQZSMbY6eNOhoVlX599EeuyucekXUQzz33XOXzzjvvUZ2JdiBshbXB4kKOM8wXE2CQ8MObVDLkYbjA/MTHfoc9KRjII414viTDedZ8KENcLq7zxnGWnSTnBdTR32b//PPPw0pOGENH8ZL1xZ+rrUn4IhyTIttzJlFgY3UdbbjEA/cDLuf5//u//wu3ueCjHK4PwEs6IM5EnRzvOgPiXcfYpW58tJIykEsey0rC8lx/8x5wwAF5l19+eYhz2bQNv8uFF39cD4cdZ5nUgziNw2L12wXbbbfdf0OGVcDvLV/HcdFFF7W8/fbbn5Qi16eTPRiAQTKI84Cax2HD+Ric2ACIZ7Cdjksarv0FIZaPDO4Jc+WdlZJVzkYBMFSXAVx/G5LrTRg/eXEp3xMbqzkrG19oZaWaOHFivivU5E8aV1wm/hW1B/icbRmuEwqObPJDxCVlcceBL89sv/324ZoBeZmEcN1XuPZ7UgDwuH4xj112aVx0ZPfBHQbC5C+oPS4zlssFOt6K43VYX6gkDTkgLtP1APhNgF2L0zmzE9bK/mDTpk2PXtVbcL+PzjqOQw89dN9nnnnmFq1ef/gvdBlMKymujcmwERKHy3bfg0rYEwH5cM1LPlznI8wFLbbBKJN2I/nKcn5geYblQvCThjyUEJdt58cffxzO5nwbH8LgbZC5EJfhtiOPFZLPOMVlxQSc120jr0HYgIew45DPSyiXXnppmDRI947DZOC3wbi/Xab5kvwQn6Livfc/AtrOuZ0/pPBkhEyPsetjEI7j8MPreNqLodNGTR4jdETYXeM/ITAXEqmxZ9C9e/dL33333TNl7AX2Sax8ucC2lItFDAwKiBF6wFBiX2lm0FAGwlYC4vFDKCL8TkOW/aQRphz+WonbbBiplQjYMIDlGYRNDgNksFXn31X4oANGzvk8/jMMKBcsj/p54sDId9ttt3DMALTXbaT++H2dAz/5IOJou4k0XPeJQR9SHn3g+gFc4k2Gw3EbnJ50kUc9L7nkkrB7AG7fqoBPWHGhz+XGEyZxsTzriePMj2s/bYY0ThMbNGiw92abbfZ2YC4kVqy96whGjRpV+tRTT31QnbpHJioMLgpmRbTCEZ8kQBpKjLIyYPATZnAYKNIxUFxmZ+Si6AB+y7FM8jsOkI96II80ZJLfMlCIuC6xPMIGYachh3zUBcPmIhxXoqdOnRq+0caKZDhPrKAG9SIeoiyegONKe/zhSvqFNOpLuW6/iTA8EH54kOu+T8LleevOBENbHG8CpOMnHTLcJmBeu9SBlfn4448PcfDGeQsDPozBRypdNojr4rKADRs4PabY2HWs+rVy5cr/p3P7nSFDIfF7a9dhPPbYY5vqfDVQq0RzFNIGZaW08tlocCEGznEoJYPCQMHP4BCHSxy8VlormQceICce/BiWh9FwRne55ieclBWX4ToC8wLqgx/jZruKgftKO30Q87kduRDLZ7eyzTbbhOMFOx0IYyYv8vAD9ydubNR2SYMIux5WevczdWRy4CyLGxs8sEuc403ALojj4KWePE9w6623hjB1wF0V8ATgbbfdFsbPdUCOy4jLj9sF8LvP7fdWnqOWZF61yy67nCF5vwtZCZb14jqOM888s9uLL754tzqwigfDSmalww8ZucLkg+C3yyCZFyKc5I/9wK7B6oXy8RdFPCGHMTif4TDk+gKHDfNAyGElf+GFF8JtLs7mvNtNmuXF5eCHknB5KCV++o4r5r49hpJa4Wm/+XPJisuKXRsCbjJMO9iFINcGYjKv+91xzmt/0kUWbpzP6YVFnTp1wlV9dje0i3H02CXlJScq15kwfsjGDml1H7LjjjvurxW+0M/1/q4t6zD23Xff82Ts582ePXvDWHGteEYcjgfK/OQFST9wXuezMjlMOhTLBfChJHy+mItyvDTic6rrSp64TLuAdJdlP8D4WMmHDRsWrrSzmhO2vLgezh/HxXAeXIi6UD/i4vabxy5IynS6480HYt44fywz5lkdWBZtd9+6LYUB+ZnsnnzyyTwZZOgPxtH9H8uiHAybONcff2zs+CEMHaOfMWPGl23btt29UaNG34cMhcDvWrGOQtvXDX755ZdGv/7664Zxp0J0akyeVd3hcbwHIpc/luUwaXHYcnCph/lRELbGPHHGNp6LfqzysdJYKSGUDAJWHFxWFHitxKzk7777bljZMXbIvM5nuIyC4DRceIHbZnmWEbv2x+Q4I06LEccl3TUBy6I+sVtYkJ8+4IEgxiVZx3iMkv1AOBkXg7Amj2raiTXJRBUK67yxayAqa5ZsgKHZEJKd+2fCSmAXsH3nvjorBRf9UAQbu+sKf6xAMYhH8TB4QFvfeuutsJpj5KzoVi4Ql53ij4M+53oCoH+NWMfisYrjVwR4NEZl5s6du0kmqlBY54192rRppbXKlWVgcg3AnwUbK0YcGzNbdrbwGCq32YykQcKfKw7ESoTLM988NMLqjqGzAsMLxbwpVg/0K7czGU/8gL614XuCtWs/vI4zkn7pQxHtSGtmogqFdd7YtY0tpQEpkQlmDeTPhgfbqy+DjfHy2iqrOas6dePsB48H3xOE6+38wGnwckbHj5HzWioXtH788cdwTICP8lwmlGLNgEXE8JgBG3OSkvEeF+eBPEbaoVUQz/L3JQvAOm/sWtkraquV/VCFjebPhstHOfAz0GzduVfNmZ2r24YHHOBS5zhscjwTAH5Wcv66mMdfuerOLRzzQCnWLBjD2KWP8ZsKQq60OA5/RgdKa2e27F5mIbDOG7sUv7wMLHQYg+Ht1l8Byo9nbt6c4sUR7q2zokNOi40Uv5WBMH7uO8dtQS4vtPjxVwwfXuIhg7yxYqX442CSZUcVj0Oyf93/kNNinmSciTFXnrJarFJjLyyk9BXVecXijvwr4HIzgxgeN/UTaGzjbZi4ya06FPtJ5+ULDB65KBwrOY/BcnU4vvJu/FXt/jeDsWD8AGMHcvU5rsmI/TFiPk0iJXUcS429sJCxV9bKvlEmGGDj+bPBILpsvtrCOR1l8RNoEJMBZNjATeaxHJSMq++c01nV/XRcUk6KNQ/GgCMY8PgV5F9ZWkzIZbcgf3EoMBcC6/xoawUs7VnXBkKH/tmgbIyPunA+b9CgQViZedzU8NkbUEf8xJHX+Z3GBMH5H/eHH34I99N5H52PP5AHnr+inesSeC6CyTpjmPmIcYaScQWl44/lZHS1hFb2ZbNJIbDOG/vcuXPL0HnARvNXwQPJ9p1zOobux0xBciV2fWOCB5fVmzM+eXnGm1tAnNUx9PgiYIq1B5525Ajmfvb45gonySgoLTN+JRcuXFg2RBQC67yx6wxblg6k8zyT4v+z4XIxbt4aw8XYqRPxrhN8Nmhgv8lyfIuOczorOoTBk5acNFKsHfCYLLszwLjkWuELQ+iAJ3yHcSWP83q6shcG6rAimhnD8/B0nrfESdiQTDFfbHhGHCYdfpDkA8Q5njpw9Z2PUnDWw+ABMmJyHvwxnO76oVzcS+cLM7zCCqxwVp6CQH7X2zJjuA6QkQzHdXV8HLcqiPMUNn9BeWJ/Ljh9RTwFIc7DizD0NaDfAenuf4h4+x2PG5Nlkkb/4QKlbbhgwYJ0ZS8M1ImLtd1Vn/2+sgM6NHbjTsf1gDgMPCAgjsPvsJHkdTpu/A44fK5DnAcQzkUGKzsX5PgCLLfZMHiX5fJi/hjEw4MiYuS56hDLcrzDoKA4h+O4whBwnjj/ipDkK2x+p6+IpzDg01mWQRvQm8hQ88mPw8l461ucnpkkishNr8YXFuowEPwMiDsSuHNjJBXQiHnjNOKdhtFAuXhxSeOPEbhAxxduAbzEO93+OBwTIA0j5Yxug0eO86wMrh/8+OkfdhlxXtchiWQ8ebhIGMfbH/MVhFx5kBmH1yStrmzXlSMYf3pBvxHmOgl9aaJP7SYpjo/zOB4XmfKvB4VCC4FCM/5bsf322z/w9ttv9+aCVkFglWQCYOBQXIwRY+I8xgrMwHoASCeNwcWFyMdjqc7PgKFUJvIC5PHUHF9fpQz4PcjIhhdkBjr4kU88YfyWTfn+/DNE+yzH5cX+GMQbpDdv3jyvY8eO2XjLsd/kMH1F+bgoPH/hxDUDP5prN84DUXfiIfud7n7CpQ/pG2Aeg3TLSPohQD8ZLtt8ELAL7HefJ0F+A17C1I9+Y0wpz7JdnhcUXORCxNt1mY6DjzEknked6V/t2Gaqf4/dY489HgnMK0H+nloHsc8++/xP59rj6VTAwOC3y9VUBo7OxegZPD+6it/3wRkQBgLjR6l8NRw58KHghEknDR4rgQeXMOUwefj+rNNBrLwMPq6VmPKRDy9hVnT+c5z766NHjw75DfIBy03C6Zbbp0+f8BVX5Mdp9uNCyLNM2kI7ADsMQBz1tqEmQdvdJ/bHbacuxNGHyIjrYBCXJAAfflyX4bweO/MTdlzMZwPNBeppXvcDMjwmHi+ItpEGiHd5zpMEPCbAY87o0MyZM2fUqlXruNTYC4ljjjnmcg3wGTZIGyuDglJYqRgEwnQ4EwCulcNKSR4PrvlxkW3jR54HzeUQhgfgkt8ygZUkJpdnGSCuJ//D9uyzz4Y33LjHHuez3IJgeYCJ7OSTTw4Xm5jk4rIgy6JM0mgj/QMvbeFTzDzI43ra0PFDjocwAsulvyzTcJ/7qTTzwkO7LQdyfC5ymuG8cRt8jALOB18ukOZ+QDZ+6oo82gTwu++RA8X+OIyLTOA05FkWxk5YE/p0jL1Hjx6PhoSV4PcWr6Po3Lnz7VLOIxkkOpOBpiNRSjqceIgON48VNh6U5IBbcYmHUF7yxQNsEEe5fImG++vksyxgGRBKAyyffMTDTxi5GNn777+fp+NJ+JMHLs6tKigHWchHHsbOI7zAdac8+sogbKJObDe53UfbyUMdXdckiHO85RPG77rQZveDeZ3PFOeFkn7DMqi/ZZKX8O67757Xr1+/bNtoj5FLjssElhvzJf3wO4/9LsvpuJaNn3SIMP0KpkyZMm2TTTY5Riv7gBCxEqzzxr7jjjve+tVXXx2NQrqDgV0Qx9HhcRqI8zEYyXRgHlzIfBB+zrb8LRIfamQLj4KjZCg4fsu034ofG7uNAuN88cUXg8FzXmfHsiqgXNcXeYCJCrkuy+mxmwR5Yzn4LTsJx8Vpufxx+UnkivsjuOyyy8K/zVBn+jcpN66LQZzD+OM89jseue5X+x12Oq77zRQbO+nTpk2b3KBBg8O7des2JGReCZbXynUMvXr1ukDb3XP4LFUmajl4RYZQVpQeP7AyeKBJhxgUKyZGGLsm0j2gfEhy1113DcbONpV45CSN3cbN5IRL2OXZ2KnvgAEDwp898GeMqwrkIgu53Pdn8sHvOuMC18v1AJSPUlJvk+OcvyBYtnlil/zUgbYRRi5hp8cuwO8wfHEaSIYpl3Fl+37uueeGB2KIc7tiuP2xjLjeTs/lQvQHlPST32FA2AYOxcaOX9v4sc2bNz+4S5cub4QMK0H+Fq+DOOGEEw5/6KGHbvQHLGLFwOXsycDjJ40zPXH4UQSUwxeiGDDOqxiBt+34cVFO+FEoG6Vl4pKX8zFfprFCw8ug4jecFhu78yPXRsA3z3l3nTOz01cFyKCOZ555Zl7Xrl2zdSCeelEu9YWYnOgH0ti282lqPkmNy4VCjhGcM6mblToJx8dprjdl4SKfiYfy8ENxHsfFRJpd+x2mLw2nURbtpi89Ti4feNyAXRDXHx4IecTnItIBLmNMnPN6zCEbOMSYg+hq/Lebb755b+1C3gsJK8Hyvb6O4dJLL+02cuTI/lKg0h4cOtlGhItxe0BQAAzefCi7FQQQhoeBsbIQZ2NHwTzY5KdMgB/A63qYlzS7KzN25PJ6K1815czOhbpVRaykV1xxRd4OO4T/usyWbWOHbHzE8701PoyBceOilDzQQzx1og8LAmXFQJ7h+uAymVI+6UkyL37cmMifjAf0F+2CbFi49KVl4sb1sz+Z7rDT7SITvykO44cMxxnWO1zXL7oaP6pt27YHbr/99iMy7CvE71ce1lFIUWdq67yYlxb4xhsuxL1httRclGIry+umrLpcQEPBWclwURKUjwkARbQiOR4XxfEkgELg2g8vLryQQTyD7HQTcU4nHPshyrOy+KxuvsKCMiDLZKJCpt1Y8YizUbOSQ7xZx4qOSx3ggyzX+WMyj8PINSEDl7wuD4WPKY7DH088nnziMPVlFwK/646fCYxxoCzqQ/tdd/dNEnGaiTxxnOF2WmacjpvMlyTny/D9qrGfGzIUAqumBf9CXHnlldtoBXy6bNmy4WuODC6GiMJ51bQx0cG5jA9+QDpxzg/gNw9xhPFbeSmDeL5Kw2RjGcTH+QHxzg8fBJ/DpEEo9RNPPBEeqmE77XquCpAD+K82nuqrW7dukIEs18N1ZJWBMEraguuVnHbiUj+7rkvcLtLi+KQfop2Uix85hnmB5ZtAQe0nDnmUzUTdt2/fcO3Est0HKwN8zuNyHef6GB73XARy8VsO9aSfiWNi0mT1js7r+7Zs2bJQ27d13thvuOGGprfccsuz8m6CUtCZrI4oLMrFLE/nxgYGH/AgkUYcacADTZrjcRks0uy3TFb9Xr16Zd9hJ84yY4Vz2HGuF/UFrguK8Mgjj4S/dPILMKsCygGUY0NgR+N2uG2UhQuIg5ewibgYhJ0X2AXJOLvuqzhsJHlXBxj5tddem70eA+K+B4UpBx6IeuLG7QWFMXbgcGzs+L1TyuxeXt511133a968+fTAvBKs88b+0EMP1Tn11FOfnjRpUksPkIEyAwYdvwcOPiuClS9WQvvNC+BP5iUMcSTgv8D5Iwgu9tmI4TMvIC9EGq6NgAnC9cPPhPXwww/nvfLKK+FT0asKl4Nsdhsuz/W3H1DXOM59ZDcmA16QKw7E8fiT/UBczA9y5c/FYwLmo32HH354uDaB3zuWXLwFwXxut/1xGDBmgLgkgSR/LmNHBkcRuY/tu+++fWrXrv37P3CuAPl7Yx3ERx99VPaYY44ZJHd7OhmlwmW15ayOy1mdGZ8OZ1B9Hkcx8EMoCHlJJw0Xo4OHeNKRi4tM0gh7VeaZeP7txc/ZO1+s5AC5TmPQqRPlIRe/FfWpp54KT9DxPjt5kLkqcJ7TTjuNB4+C33caSKNsFC+znQzphDkr+4IcacRBKCp5rLyFrU/cx5RruK9NrheuYZ7YjxvnpU70GW8bMi5cewFOj7GiOps3bhv+ZFspDxCXJJCLnzj3HXoD8S1B9cnNJ5100vEZ1pVinTd2dWyRY4899v5x48YdiKJAdC4KgOHhcrUZAlYOFIMBtqFDHnAbO7woFoAPubjkxRjMx+BiECga6YB41wfAQxxkhSUOmfA4H2Hqyv+ss5XnKzXwEr8qcL0w9gsvvDDbJ8R7haENkI0bQhHtjw3dric5KAZyc8GTqvvBfUB97Hd/OGzEcfZbDmHqQJu40Eq9SCdMvPNBRrLOBnldH1zGHT/8hON8hAFxSQJxOoiNnXIg+nLOnDlLtTicf/TRR18SGAuBdd7YwQUXXHCtOvMkFAvQ0Qw6BuQBx28FIWylIA4/rvPid9guPAwaeSnHfvgJYwhGrNiUC4/DEHCZVlJPPshl0uCz0fxdMPfa4bMSFQaUDz/lsqo/88wz2XKJj42Z8qm7w3EaCkoaZGVFpuvpdsVwOkS9aafrgxz6w3nNB9zPcZxdgAzC5GWH4v7G5a+wuHPgfoplxKBM5NAO14n6bbXVVuGDI+Sh3aTRXvhNRuwnP4DXdQPmwSXNRF0pmx2TzuzzKlSocOIRRxxxV2AuBJZv0TqIM84445KpU6eerRl+PRSVwWLgrSAQg+qBczgGcbHCkZfBcX4rErABWxbEFW/O7sRZDjIgw7zARkAZ5EGmeUnjivw111wTLtLZyAqLuBxuOe69997h4iETig0c5cNP+VBSIXFpr10T9bAbE212msuP45Cz2Wab5bVo0SL4476O6wuScbjIwMiRRz3pK/qJOxZcmCMdKiyQiaxatWqFnQ93K9x+6kbfuP4xv8N2Xa7rGKdD7lcTcjH2WbNmTWzcuPH+OrMX6uk5kBq7cO655/Z9+eWXr9MKW4rBQhHc2QyYjcjK4wHxANpvOF88eDGvXYBhcD2A5+K5t++yQWzA5HcZyIY8AaEEVl4DP0/R3XvvveE+8qqC/PSF/Y0aNQrGTn2toCZAHeyPXYg6mhx2WxxvP3JiOA9ffTnkkEPCdRR2Li7Dctw/8NM3DgPCLgc/fUUa/XLOOeeET3fF+aFcIC/lWi444YQTwuu/TCROg2iH5cT8rrfLiYk0XPjxO8w4IA/Xu6bJkyd/3KNHj55bb731j0FgIfB7LdZh3HjjjR2uvPLKB8ePH18nE5UdWEDn0+lrCyivzl552267bTBwQJnUwWSFcTyAlzBKgEvYBg/PV199FVYdHpldVbhM2o3fhv9XgC3ywQcfHAydi6Uce9wHwH0D8Dtsv3kddpuYCAcNGhTSPMnawHIhlgsf/8PHNQ36nHM/8FhAnrhcPnJXRgbyPWHgQky0PiZNmTJlyFFHHXVg/fr1Cz2Tp8YuvPrqq3X+85//PPrJJ5+0Q5G4h8ktJwaRGZuVl3hWNgbOg0IYeFXFJT0mTxj44fGgIheQThorJ0/sYfgoCnEG+QiTjzTKAS4XRUAOYe8GIJTi+uuvz3vssceydS4MKAN+ZKO8bOVPOumk8JorfeNtul22lVZOKE5z2Ol2iYvb4za6fEA6cZRLHTjm0D/JaxzAeewC8ibjKQs/r/5effXVoT3UiTi7ufqKeMug/kw6xx13XHjoiDoZlgMZbhf5LJ/0uJxcYfiJw4XoU+rL3Q/Jufbss88+Te7vBa0Ev/fMOgydazd45JFH7vz5558PRem4rYFyoVQYD1flMWwMFGXxwDDIuMTFRsaAMsDkZ5AA8ci2MiCPPAygZbo8/HYtB5cw+ZFjkAZQfnhIIy/lUt+RI0fmnXrqqdmvxRQG1If8dinj/PPP50Mf2W2kiXK92jjNhk597cdFluMN6kw5EG2DDCu/Xd8RAfAn4fzmRzZhXOB+5VHeSy65JOx4XK7bS/1yAR6n08d77bVXXvfu3UNcvKrH8nCBXeKA011PQNjj67D53Wf0LcYu/fylZs2aJxx55JH3BYZCIjX2DK655pqD1Ym3lS9fvjgdilIwcAwIg4vCYDyETY4H8HqgAfHIMC8wP4MIL0ZkBbEBkA4/cQB55IOIJwxPzAe5DMs1L3VAsXnIJq4b5TlPEsigjvBbDhegkMEFKQzXRLr9tAUiLy5xlEMYF3IdLNflUCcmC9ppXteT+iCPsPsOWBawDOTC676P45ENuEvxwgsvhDTijWTY5cflkM5FQo5dPBfBBBSnA3ggx+O6TY7D77KcBkgn3nG0hTB9Q3/iTpw4cdx22223pzA8ZCok8tdyHcb999+/+YcffviszoU1mEFt7IBBZxC8igIPZqx45nPYBgpwSbcC4ZLXA8sugQdrGFDyUr4BH7Is23Is02nIcblMTBgGcr///vvw5RVux1mG6+/6xXA8sgFygZQrr0ePHsEPj43cbaC8mOJ4XPuJd7mU4YkBP/VlYsGI4HV9k3B87Lo89x3+GMgcPHgwYx14MZxcQJaJOsRgx0dfMun5OQwAH/V3HuRbhtvrOFy3zf2S5CedePoFUFcWIfpq1qxZH+200049RBNCYiGRuyfXQehcW+Oee+4ZqMFrS4fS6VZ2jI1wDAbCPPFAGnHY6YA4hy2f8jiPYki8ZUc8g4wiuWxcK5NdgB8+y7Jc+FF66olSouScu1EYQJoNNYm43shyfQHPyGOMPEiDDCulFRZyGDhfnA6Rj3YjgzB14bsBu+22WzgHM7FSD5MR+4HDuMihvjYk+oU4+gLwIY8bb7wxfFobkFYQLC/2c/Q68MAD8zp06BDqzcTk/qF98JnXdQCWg0tc3D/AfeO8EHHuI8IsQPQ5rvgePeigg/rUq1dvQUZEoZC/59ZhfPTRRxvqbPvo+++/vxedHCu5By05oE7DNZweDyYwD2nAYcox74knnhhuwWGQKCgK77pAscFDjo/TPFGhjKzurgur2k033RQ+uYRMZKM4BYF8uepMOTYiygJxW+N8K4N5qScXKDkD+1l8tsgux/JcD+eLw7FLGnltLBgpn7K+9NJL88aNG5dvorPsGPSj05Djdu6yyy5hQkYehu7jEu2P5djveibT4jjcXLpCmcTTBghDx505c+Z89dF/pKtXZtgLjWW9kyLg9NNPP2LAgAGXaYAreoBtMAysFR1l8EDiEm8/6XEYf6w8+CFAGH6Igdxiiy3yWrVqFW4xoYzwWRZ+y0YuRJz9xJMOkEV9gesNaAsfo2B1y6wQyymaYbmut+Ey+TgmKzz1pDwrvCkZjuPhRw51IMwDRRg7RsjOgXqS7rpRXhKOi12IMmivy2GS4+u63GZ77733QhmMLbyWn4RlIot6QLyCzMsy7JLYhdHX5Hc9XTYUI44zD/y4cTgGYepI/SH8GDvxM2bM+HabbbbZR5NOoT5YESM19ghPP/30ptrOPyGFa8nqSueywgBmcs/mDLQVApeZHjDwvsrOIBLGjwvghWyYyMclD34Mh3QUlDyWQRwuvAUZO37KsmFTf+S4vsgmjOLcd9994aIdb07lArKoD3KBFdNh0tq0aROu8vNkHYqI3FhBIfigZJxd4DwAI6e+Lj8J6mHE9bFLPuTZoHE56/Jw0fPPPx/6gXgDebFMw7JdB2799enTJ3zUxHoAXB4u/MhyHofjMmIe3GQegzBycRk3E2Mqeu7oo48+UBPkzAx7obFMM1IE9OvX77dZs2ZtVb169c0YWO6lcobmLMmKw/12ZnbP7hgPA8+tF+LwY7jEo7hWXlwbol14bfTwEI8fXhArUNLALcNx5icuJqcjl3phVNSNh3datmwZ/jzCr8Ca1/JwrZDIxh/HT5w4Me/DDz8M/17D8wGUZ37I5VOu/cihLlDcH7Sf/sCPDJcF4nJjisvyZOF6YiTIIp6HZnj7jzRPMi6DvNTBsDwTPIz/PvvsEwze4+k0y7DfZBQmHCOuG37qi5/nGHDnzp27QHo2QEe9FzJZVgmpsUe46667fu3cufOm2l7uhHJ4m8msGvuZdeMZ18QqwsDYTx5mY9zMywtZHrusipkZO8vHREIZGAD1sPLZWFBQ/DER53gbEnAacRBtQBYXwTB6JrSxY8eGe8/wGvAYKJrr4DD1IM9HH30U6o1sHvbg4hcvlXBGxmUy4bFU6oChWIGhJIizwjtMneK6uB7EQ/STw64HYcaA9/kff/zxkC9XmdSJ8oDLgQDx7Op4L4C+It0TNDyuJ37LdtjIFQccX5Afop8g6xZ+9e94HfMu0VFz1T9SIOSvRYq8W265pcNbb73VX6t4TQySwWWgGVz8DIRd4DQPKPH4rUgQPObzYAIMhoEEGAJ+DH3HHXcMRugtIoRMy4XI6zTgeMKeEFwO+bzCYgyUQxpl8gDRd999F95s40k7LmC5TjHcPtxYrtvHf8qzAyIv9fbOhng+ykGady3kAXFfxH5gv9tnuB6kk+YwMl03XF7xZfvOBECay4xhfvqF9Lh8dkB8PYhrKPjZubku8MW8IBm27Dg+Dsd9YBdyPbygoIP4WQTmzJnz8lFHHXVA48aNp4ZMq4jU2BMYOXJklSOOOOLJb7/9dtvY2BgED6DD+IlLgjTngweYz3JwUTJmbECc5aNkPLRBGsbpckzks0FDlEM8LvHwkw9jxo/SEM9EAjAAlMjp7C4AKzOrIW+C/fDDD+Fvm/iGXS7jTwL5/lgnxAUttr4YietLndxeyoXsj10Q+w3aaNBWZCEXF34mE/w8MMPXdTEQ4unrXLA8eNy38NJPPFPABVNWc2/fLcv8BmEoBunJeIfj+Dgd2SZ0D2KsIO2YFmqncc2FF154doZ9lbG8pqbgquv1zz333FFaDYsxGHQ6g80g2KA82HbhQ6k9yPiBDZ544vBDhvkAfpSV76FpwgkPcAAbs8uCjzrYJR24bgAX43Iacl0X0rwCQ8jhYh3t4/oDysUVbBs8frbibMsxIPIgB0PgOoafJMNIMHR2EaS7TLcdv5WZdFyAH7K/ILj9AL95kQsxgTFRDRw4MJQNqG/Mm4TTvOOhDdz+bNu2begnT1aQ6+58wGEQl2G5cVwctj9ORxb1hjw21J/x0JHpx6222mr/3r17F+ob8bnwe++lyGLw4MGtBg0a9IiMrTEdT2ej1AClQJltZAyqlc3GRZwNkThAHH4rAS5gEiEPA43f/JSRLId8yE3KdzpI1gM/crwdpD3Ex8bg+tBO+By2TOJ9TQEZuPBYBmVRH3hsEM5PvMslj40Df0zE2x/DdaAMpxOHS9uoC+1jsnrppZfCzoR6eDdieZYD4jKoH2HKZ9LiXj9bd2T7BShkuT9jeW5TLBs4DjdOxx+3367jTTZ02kbZmWs6L+2zzz69t9lmm59Dxj+A/LVMETB58uRSOu/dJWPal0Gn472NQzlsaI4DKIOV3oMLD2ErqsPOA0izcRJvA2eQkQM/gMeKgt91wQ+Rx4jrQjwEP0pjYzZQWJTKsglb2YiDN1ZC0h0mDaKujjd/7NpvImzYH/O6/2wwuKTj2u/+ou1cd+Caw7Bhw0Jd3B7nB+Z3mDRAPGAXxcstXGNgx8IKz1ggx7KA8xeEXOlxufbTX5YJ3H+4bgN+xksT2RzV75Lzzz//igz7H0L+qx8pArQVnVO9evWnpdzzbUgMkP0oSKwsMRmkQ+aFrDgYIeQ0ZBOPa0NzXoDSsQJTtvMy0cQyIMLU0XnhBygMykM6cZRF2EZBHHkoF0UDhK14EGnwOg043XWHciFOo17Jdsdyc8VTjvPZD2gP1xQeeuihvDfeeCO0x/UxkGd+QFvdL+RHHh8N2XfffcNDQsSxdYeHNAh5cRvsz0W50p0/6ZpchsuDHM/YaezHNGnSZHAQvhr4fWpJkQ9aJRo9+OCDA7WVa0KYi1jM+ICBADYsBgrgB07HRXliZQNxOnlJj/M6Dwa2+eabh48kMPCU54kAHvPhopyk4yfd8mLlIY7yUCDISgdiZcNvIowBwe92xGm4wHmR53j8pmTYZNhveYTdBkDY/QQPfu4iDBgwINxBcD3pH8P57cZlEoefOwU8j89zFKzmrPDEuy3wud0xLAfEfiOOi9sE3BcA12HqHhOT19y5cxerXQ8eeeSRRzVv3nzV/o43gd97M0U+qPM3OOqoo+577bXXwldnGQzIigOsfMQDu4bDcR6DuHjQQSzLfiYYPp3ElWHirHi4sWFj7Kz2uOZB+VFagPJYgQFpNg6Uym2hTuY1P4Q/jrcCA4fdntifDIOYz3HmNdwu18H1A+R79913815++eXwt03weJdSECzP5dBXnM35oCYXJTmv47os1yXO4341zBOX67jYTfqTceSH6F/3Me1hgp0+ffpYTfaHSxdfCRlWA6mxrwBPPPFEp+OPP/6eGTNm1MWIGAgrHYNkBQIePOD4XHEgzmse+zFgBh4X4OdDi7zEgkKyegP44bEC4ieNegLyoTTU2X4Iv8u0UkH4gcvG9WSAH6JMXHhJsx955rEMiHhTMmy+OAxiP+UB2shtQS6YcUeAN/j4aq6vQQDqCeL8hvvIZdGPPMuglTL7tCMrO3AbXTYgnERBdQYux3B+x8fppEHuU1yIYxsfDVXak4cddlhf7fBW+fHYJFJjXwE0IEWuuOKKG6VUh0spinory6qAy1kaw/BFNQNFcTqDij/eYhPGD+E38Fs2+UgnH3lY4SkDF+UgHfmWR9jneKdbcWy08JJGmHRAmDQM3gbsNGA58OAC85icz/H2x3yx3wRwqZf95iPOfPhpG1/d4R46twOpj18OAeY34jD9Ax8uz/LzgUi+HUDf+gOWtMF95zzA5dsfu7kQ86zI73biQh4TT7y0bfbs2ZM33XTTE0899dTHQubVRGrsK8Fbb73VZsSIEY9LKTbJRGUNG2NDKQoyXNKtZLGxM6hxHDxWKMLkY8DhQcnhs2LY+OED9sOHolgOiBUJcpyN1yBMPHHw2bAp0/Ul3bykWzaw32Hz45ocBs6PbNeDtlJ/DI8yIOJoG4/gsm3nL6gxAiZdVj7LAMjGTx4Q1wWwmm+55ZbhBR7KYDXndVr4zWPEfZgLSX6HcZN+91+S3B+4tJV+t5820hdyX9h///0P69ix48QgdDWRGvtK8MMPPxSTkt0gIzsyNkwMHpc4E4pjRbGixmHyOF+cNwbxGDR8LotwbPAoalwecfDbSG1A8JDmeKcRZ6UjLg7j9yoPr+MhYL/zOW8sx/Exv9PMC2xokMOUCdFe6sAXcnlQhuf3yYeRe+sOv8sB9IXhfmHi5Ou0vJLLq7T0CRfh2L4XBNdnRYh54jYkXeB0k/sHv/sN133OkUVb+Gm1atU6V7gtI2a1kRp7ITBkyJDO77///n0611VH0RgcGx8KZ6Oz8gL8dj3I+DFKQJg8JmTGfsu3PMLkRylYxdu1axduGZEOP4SfdBQG17AM4lEoK5j5LQPgOt2GZ3nmsTzLiP2mXGEQx1kmbQZMMp4MucL+5ptvhk9puc9Z8agL6eQHuITdN5YFWLlZybnmgXGzohPn/J4MCwvLdtkG4ZgcB1yWyf1COwB1jonrELRTxv5a7969D+nUqVOh/o65MEiNvRCYMmVK6dNPP/2+0aNH78XgMWA2YisAYUAcMF882I53HsfHvMjBIO0HKAFwmRCvlf7f//1fXvv27QM/BgGf01Em4i0fUAZkA8YP7I8J4FoWsnEJm8flxbwA1+SwZcZ5kJcET8LxcAwX4Fjh4OeiHC7tiOWCuN8dz2rORyExdF4oYgJhNWdHBE+8S1oVWL5dIw4neXAh94+J9rgP7cfIcaVv0xo1anTOmWeeeXsQsoaQGnsh8cQTT+x03HHH3Tp9+vRNrXSxCxxO+oF5zL+icAynWTGTBn/22WfndevWLSgyK2NSgey3XFziTU43T5wGGQ7H/E5PhnEtC9iPGxNtwRCZlDBoDJxXZvEzEWDs3rKzClOG+wkg0/GA++Rs1blNiZFj1N6yUw78dslDXurxR1BQPse77QA/5Ha7fLueTFnVabPq9aJW9SO23HLLcRkRawS/91yKFUKDtN6ll1563qRJk/rJsMp78HxBCSXyVhuFRJFspPhJy8gJYfghA17C8UplWV6RkMWqZYXHSAjz0A0K7ZWSeAyf/OTBYMhjmV6hzWtlI85EPlMcD+CF4rRk2HHIdn0dD2gr8bzv/tlnn+V9+eWX4So79fFW1rx2QSzL4P44f7nMm3Z8TAOjpz/8bDv1iMcDWE4uxLKTyFUXg7Q4PdkfhE2E6RuIsK9FaGczWbuSU0844YSHMmLWGApucYrl8Mknn9T8+uuvbylduvTuKA+zMEqFAUEYdGzIDCgK4Th4AHHwmt/A7wkDBcB1fpTWymVZKDFKgnHgpzyfe23ExJEWE3IgKx2EH37ygzjefOSNw5ZjhY3z4ALX0+USRqm54MbXXvlLab9GS1swcniB+R2mXZQFSOMKO0bO9+swciZFDB+XcaHf4rqsLpJyqANwu5P+uE8gwrQl9tMeXHSJtqvOT5966qmH/pHPTq0MqbGvIl577bXdZs2adXfFihU39oqJgVoxIRsyg0oYkI7yOYwbG7cVB4W2vDg/cb69BlAWKzP1QGnIQxge/MSRBpCFUpFu40Q2rhUQWAGJt1KaQBx2PpdrfywLI3a7WcV5xJXv2OPyAgv5vJLjB/DGshwPWLW5MMl2nXvl3q5j3DzTTh8ZcV3wry4sKwnXj3Tz2O9+gegPYAMnjf5hjOiDOXPm/NClS5ejDjjggJcD4xpGauyriG+//bbK0KFD/6eB2octNAMXGyyEclvBCTOoEGGMOVa8mNdK4TiHY+UHXrUt30ZFGVYkQB6eDKtRo0bgo55MBKyghEknH37LJi9EGvIcxg9wSbPfYVzLoQ4Qfs7ffOuOd+PHjx8fwhnFDvWgPuSnLS6DfC4DYMBcReeNNG6j8SAMxu2tOis5bQOux+qgoPyuU1w3/KY4DOL+gez3GEEeD95sq1y58p2XXXbZqSr/99ltDWL1emUdxYABA/YYNGjQjVLC2lZsjDNWEvwoMLDxAPNYAQib18oBnJcw6RglclBq+81LeqxEBisGcvigBM+B8/QYW1+/1WWjJw8ygeuBPFzS4rIogzT4XC6IlDZ8m47/lsPI2aLz4Qvq4q0qvMBlxEAm10EwYiYq/nmFlZwLbZ4EWd3dBuoR1wd5+A3SINIKi4J43VbLNOJw7KcuJuJw3Z/ucyY+SP3z5mGHHXbMdttt92XIvBaQGvsfgM6bxc8666x7Hn744X0V/Nv3IcqLkfOlVN7ywoA442JAfgkEA4PPZIVFKa3AVlIMHgVllcaQMW6ecuOLNnxoEiIdZca44cfQk8BwvTqzWmPAGDhEnTBqJjf4WL2pI7spjBzZritwHR023I54AlgZnCcXXI55VuaPDR7ypEo/2tC1yxm39dZbn3XMMcc8HBLXElJj/4MYOXJkvZtvvvkaKXJXKWBxr3goJ8pooKiEcT3gKCR8XpWstOaL4wzy2dDIx+oIL35WTdIJOw+8KBbxDuPHYNgW42Jo1ANDgognjEHhRx5ADuVhuCinXVZyyiYMj/kcT9j1dd1wkU0Zcbm4Xqkh/PA4L64NCCAr7qc4vrAoiNey7BqE47hcfPSx+dzngDB9Y5f4zFFmria5/n379j1+dV9hXRlSY18NaJu6qc6il2tV6mnDQnFRVAjDQaFwiWeg4YkVOjZQeJwfoCwQ6eSzAeNiTMQjB4NCgWxYELABEg9wIerhsBXQSklel+U4yjGP0xx2nRzGJc4U53UartsNEee+oHziDPNDMeIwfsuK8/5RWHayzBikJflw3UeQ49wXJvqdPmO3I2N/Q4Z+XIcOHb4IGdYiUmNfTXz00Uc9tLLdLoOvggEymGyNGWyMnMG2saPIhHHhiycExxOGSLMBkwYBlIR48uBHjuXit/FiOMCKRRqw0cVK6bwOmy9JcTxwnYDzJ0GcyzO/2xvzx/mT/DFyxa1puIxkWa43iN3YT71NjmMMPI647HygX3755cfOnTuffOihhw4MzGsZhT/IpMiJOnXqvCrjHIiReWXGuAyMFmP04GPIhNmi2iBxc63o8KFg5EUmhMJYHn744knBad5KE4d8ZFvZbPyEDcoxxcqJPNcDEGeiHPMizyCNsOsIAbeF+lI3XJN5SIfgpc4ud23AdUtSQYjbk4tcdwh4bBymnxgX4uTOql+/fv8/y9BBauyricqVK/9St27dKzSQ7xDmLMzg2qjjrakNByU2WZlx4cXFGFEIG7eB8tioKANeG3FGgUIaZRCHcmFUuMB1wIWAFRVCJq7rTNiGTLzLJt08MSzDeWIijvaQTj631YDHbXL94/bj2g/gzUVrE26f62Iijvo7DIijza4XbWEscDVOS9TGd/fZZ5//BeY/CWtv2lzH8P3333eZPn36bSVKlKiHIjOwrNY2CozSLvEoBWEIZcCFl3ivBkljQFFsuPA6bEUzD7IAYRPybGDmc7zzAvwO4zrOYVzzGsRbjtuD32QeQBpkmMfyzQeoq8NxPIhlxEjygbgfY+TizYVkHWI3bo/DwONEGD8XNG3s8n+65557ntqzZ8+18vBMQcj/MnWKP4zrr7/+h7lz5y7VrL116dKlw59LoMC+ogy82oN4244y2giBlQbFwCUMAcLwoUCOc1kQ8j0J4LfBQMRZCYknnXhkmsxrxHE2GucFcX4Q89uPS93sOt0EYpnAZTk9V54Ycd2SFCOZN5kOzJOrLMK0w20xCNuN0zLGHcL0vc7pY9u1a3d1nz59BgSGPxG/926K1YKUZkmVKlUeLFWq1IMa0KW+rcRgo1C5VnPHeytOXLztJo78Nl7C5EkqHC5ALnzeTbCtRx55CJMPfsuzQsLvPPDkIuAyHUauZXvXABnEOz32g5gPIBPZlmHKBXgtz+G4XrnguoOY3679cTgZT3+5v82H677EdZg0+h+/V3TpxdRGjRo91KNHjzX+kkthkBr7GkS5cuWmaxt/qwb6TQYfQ2Y1RykZ/FjpQTIMYuXCD1AYtvZWIsPKZwVEDvKsePjhR+lQNmCjJGwltFzibfT4XRfLc70ctyLXZBmxHxe+mOJ0wpRH3YiDgNvH5Gh+w3wFEfkgYDmGeWI4jnJykdNcd5PbQ90hbq8RL3dW5cqVB/Xq1et/tWvXnp8p5k9F7qkzxWpB5/c95s2bd3nZsmUbY/AYKmCljxXWChcrCUoO4TccHytkrGwQfsfHcbEbI06zLBAbuWXhOs7kONKdBzIcTlKuNOBykGXgj+sDzG83iYLijcKk5yoLitsZ9wvkPiHeExWTKfFa0eeWLFny+ZNOOunEJk2a/KG/W14TSI19LUCDvuGPP/54kAb6Im3ra2LUKIC3y15drSQGfisKrhUIXvzEo0yeJEizDNJwIdIdRzpAnmUiz7DSEo8fN4bzA6ebhzRkOn/Miz8XxWn2x26MgozLaUnE6THgtawYufgJx+0z7Hce90Psh+gPJnf31ezZs+dpYn/lqKOOOnXrrbceHYT8RUiNfS2B5+dlbIdroM8uU6ZMNQyQmd7GbuWIFQqFRFlQFMhbdysrcU4n7DzI8EQAyEccRwjLAS6TOCguGzjdZEXGhWiD/UbME7tOM6/TYsRh88IXy4HittrvvEnXcNj9E6cneUFB6XFe95nDuNTP/QkxPl7RZ82atUBj8OpBBx105s477/x5yPQXIjX2tYiJEyeWlBEeIoM/Vyt8NRTPsz7beBsusBLBg6KQhgED/BCTBDw27DgPwE+8FRCXOKfFiulwTCDeNbh+5k+SkZwEkJXks3yHcWO+2G/gp21x+3LxxUjGOxzLgBwGyCTsNCNZFmHHAVz6COBybYS4zLWQ+Qq/0adPnzO7du36SWD6i5Ea+1qGlKP4Tz/9dIjO7qzwtTB2lAIDwngJo0D4bVgYD8qHAmHYpNvAAWnE2RhRMBuplRHX8qycII43r/ntj/NQlsl1McFnOG9M8MRpwHExnBbDcc5LviRfrnwgF1+uONpkv2HeXARcD8j9xBhCyMPQ582bt0B8r/fu3fvsXXfddUTI+DdAaux/Avj2fOnSpfeRclxSrFixWigMbzwBjDw2WtKshMAGRjqujZ6dAS55iTchD1gWBB9kEAcsE5jPYSszYfyQ62UegzoA85lcpsP2G7E/Njzy4VIO8fYDwo4DBbnGyuJBksdu3HaAG8fRbozbY8DYzBc0Bq/37NnznB49evxtDB2kxv4nQcpQVNv6g6TI5xUvXrwOcb4tY4O3EtnIUGqv+N4BWKmA+aE43oYDiAfxpAA/cF5AGSbzOM2wjGQ8cJzzQS7bYRDLzpUO4vjkEQHX7UvGx2FjRWH7C3Ljujockydi0nnNV/0zV7u2tw444ICz/26GDlJj/xPBCi/l3UcKcrZW+EYoClt6K0zsAgzPKxlxsbHFigacL540Yjg9NmZcKJ4cnNe8JuLgcxqu+Z3uONJjN04zCMdyYsRxlhHXEcSy7TdylbWiuDgNf7LeJvcdfex+YRwy2/jZG2644WsHH3zwOTvttNNa+9rM6iA19j8ZUpoiOsPvOHv27LNLlizZkZX7l19+CQpkw0axCAMrnlc4KxrxVjj8VkjIcZCNJPbD43R4gcOkgVieCV5c80GGwzHBF6fZH7vA6XGa/W63y3QdHG+4LPcfwI39SeTiAy7LMuOyPckyDiat6j+XKVPmxb59+17Qrl27H0KmvyFSY/+LMGnSpBZTpkw5V1v63bUiFMtsA4NCocgoFH6U18pmBbfCmeAzD65BPES85QDCdk2WYTm5eHLFAeqdKy0uz+kgV9hI1hHgd71iOIxrf678IOY1cuWJ4xzvfmQFJ52+5Hl30nnWvV69ev0POeSQ61u0aDE5ZPibIjX2vxBTp06tMX78eL4merBW+QqZK7nhnI5hW8kASoZyWRkdNg9hiInAcJx5nB9lRT5wHGR/rjiTEYeTfvIAuwXxWjZIxsV8wH7qDmLZsRzHJ5FLFm4uQoaJsCdhQP/iZ5w0XqM233zz24844oi7qlWrtvxH9v5mSI39L8aMGTPKjRs37nCtGscVLVq0HkaI0bNy4IesdFY4FD6pnCgkLrBykmaYL6ZkumE/ruVAlu+8MV+SHG836Ydy1QGK22e/YX9ch1hOsm8M+2O3IKLNyLRcwvSpSYa+QOUMb9++/f/69ev3hPzLBuZvjtTY/waQQm3w9ddfd541a9ZZWtU7+Oo8F+8MKyJACW34TAYouOPIB2IlxfVKTrx5rdBJxAZGuss2OS6ZBhxvfxxvf9IgHZ8E8UlZcZmONw+IZcd57ZricCwTv4k+Is79yDZeE/EUTcpv7bXXXlf17NnzvSDoH4LU2P9GGDNmTH2t8ufL26NEiRJl2DKyylvpMFhc4uMVHzIcJo+JsBXYvDYKx5uScJzlgmRcnIYbp9uNeYw4DjeX3LhODuPGE1LsOj1GLrkxke58dm3gdmXoS0Sj69Sp88gBBxxwz5r+08U/A6mx/83w1VdfVZo2bdqhUqyjtYLUJw7j9lnRSp5cwUjD9UoPiHO8ldiKTBgQtltQejwx5DKymNcUI47PRcD1sx8Qpi7AbTIPiPnsB+bBTfpdTlyey2Dl9oSKHyOn37XDmqnd1vBOnTrdcNxxxz0bmP+BSI39bwgp24Yff/zxdjrP99tggw22lwKWQjlRQMgvuFhpY1iJTQbxXqmcJ85v3jiPeU0xj8lIptlv1/5YTlJmMhwjGY9bEOWaGOL+wrWBs3Pi1WP6xkQfwyP/UqV/V7t27UF77LHHXTvuuOPXIdM/FKmx/43x5ZdfVhs/fvxhUl5epmmAgkJcCfYKjlJaiYFd4mKYz0pv10Q+G0JMwMaDIeRKj/OBpN+uKVcdYwM1Gc5jF9g1zG+XdOcxOY/99AGPHdOflO/dUyZtmtzPOnbseFOvXr1e+CdcbV8ZUmP/m0OKud67777bVlv7E6WYnaWUlVHM+Cyf4QsucQZKC5FGntignNfpVnLHAec3nN98kOF88Dgtrl8sx3G45k/KNH/MG6fbBbl43J5YTlwGfhs3EycXQ4lX3ALFjapfv/6Arl27Ptm5c+dvgoB/AVJj/4fgu+++K/v999931Sp0oJRy64022qgSiuqzJX4Mhyv5+CGU1yDNcfhtZMSB2BAchmI5TjcvLrCsJF/sj8POtyIe+82bBOmxHIfdHoeTaY7Dhbxll3+p+nZ85cqVX+vSpcsd+++/f/g0+L8JqbH/w/DNN99U/umnnzpPnTq1t4JbabUvj7KyMrFSgdiYrdQxHCbdSPqdz8bu9DgtlgNRJnHmTaabx+mxYRJvJPPZn3RdVmzEJuA4XHjMZ9d+GfnPOrd/3L59+wd32223lxo3bjw1CPiXITX2fygmTJhQ6Ysvvtgdo9cq30ZKXQbFZqWyYvtcjx+wAwC+4ux4GwXxMRwP2TgMx8fp9jsd+XHYSMbhmhy260nA8l0P19354jT8cdtot13SAP2kyXFK8eLFP2/YsOFTPXr0eKpNmzZ/2ffh/gykxv4Ph1b6mqLus2bN2kuG0VoGWx5Fh7zFZ2uP0dgQiCfMxSkbSIzYSOGLDQ44zfJMDhuWE8eZz/VxnGG/XRuoZcd5HKYcpwPCNnDHE0eZtH3+/PmTy5Yt+3GjRo2e3WabbV7Uufz7kPFfjtTY/yX48ccfq3322WfdpkyZsqeUu5VW+2ooORfygF0MPzYS/JCN2saB32kxGXGcdwqOR4b9JsPpcTxhxzlsv/kchwviujs/Bg4BwuYBWsXB5KJFi37RvHnzAZ06dXqpY8eO/7gHY1YHqbH/y/Dtt99W+f7777fVub6HVrDWMu46olJWfN9msjEnjTo2EMN8pBnmsfE5jJsrLukvLCHLrv1xGhQbOZBRh2cR4JkzZ85MRY2tUKHC8BYtWjync/l77dq1G7+Mc91Cauz/UmhrX3TatGmNtOJ30Wq/k7bszWSwfPSyiI0DQ8GAcePzuo0J2PjjOBDHMRHEcTZK4u13uuMArv1xOc4T5zOv09iOG3E6fpWxQPhZ/u90Hn+lZcuWzzVu3PibLbbYYl4myzqJ1NjXAbDaf/rpp1uOHz++iwyiuaiBoitpq18MI8Pw7WIwAKMBNmRggwR2bWQG8YRxY177QZxuP0jGxX5ciDoA6kU8IE7HlDkKT9Wk9YPO459vvvnmLzRr1uxTbdfXyVU8F1JjX8cwbNiw6pMmTWo6ffr0DrNmzdpaBl5Xq34VGU9ZG5hXfoBrw4Ji489llIbj4I/THA8ZLiuON5/9ds0j/xIZ+QwZ+VRt2cfUrFlzWO3atd9p2rTpqC5duvyrr6r/UaTGvg7j/fffrzp58uRGEyZM2GrmzJmtZDw1ZETVZUzcuy8lIypqQwSsoBgarg0PZIwv+D0xmAfgxn6nmSwnhssCuKKF4v1F7lSljStWrNhkGfiI5s2bv7Ppppv+sNVWW00KzCkKRGrsKQKGDh26QYkSJSrpjF9bZ/1N5s2bV1+rZgOdfevJwKqIJUwA2iaXKFKkyHoYKQaZNFzH42L49mOw+InzhEAcLsDNxGl++W2BaK745qq8acWLFx+rIwfb86/q1av3ic7hY7bbbrspIWOKQiM19hQF4p133ik+Z86c8lOmTKkmt4aotiaBmnKrayIoK5ayMvxyckvLSIvJLSriT+eLKLxexsDXE4+8S2TLS/lZLP8iGfOvcnkOfZ6Merbi52gnMat06dKTS5Uq9ZMMe4zcCZUrV5648cYbz+jQocMMyU2xGkiNPcUqg12AVtsSMvris2fPLvXLL7+UX7RoUem5c+eWWbhwIVRCbBj9+orXorzRIhn0YtFvWql/3WCDDebJkGeVLFlyRrly5WYWLVp0rtw5/Ntpp06dfj83pEiRIkWKFClSpEiRIkWKFClSpEiRIkWKFClSpEiRIkWKFClSpEiRIkWKFClSpEiRIkXhkD4bn2KtYezYscWHDBly0HrrrbfpkiVLeElmXJ06dV7abbfdPlvGkeLPRP5vB6dIsQYxYsSIHX/44YejJkyYcITo4J9++mmf+fPn180kp/iTkRp7irWGSZMmbVWkSJH666+/fnm55YsWLVq8atWq69QXXf9OSI09xVrB5MmTS02bNq3NBhtsUI6PUkAbbbTRtHr16v1r/jvtn4bU2FOsFYwZM6bJ3LlzN9GK7i/TLK5QocLoGjVqrNNfeP0rkRp7irUCndU7aPvO56z8KapZtWrVeiMkpvhLsNavxnNFds6cOeV+/fXXomXKlJm/ySabTOOLJZnk1Qb/bvrzzz8Xk2KtV7JkyYXNmjWbIfnLPmy2hjBixIhys2fPLq5t6JLSpUvPbd68+ZxMUoH4/PPPN5JTYdGiRUW0qi3cfPPNqdcaazfytUUuM3/+/KIbbrjhYvXtrNq1a8/PJP/luOaaa56bNWvWLkuWLGH7zrflpvTo0WOHVq1afZ5hWSnUb0WGDx9eQ94S0p8NJGe+2jh54403Xmn/FxYfffRR2V9++WW9Tp068WcS/2qscWPXAK2nAWr09ddfbzlx4sTmUsZaiqsoKrp48eIFUsxJVatW/VRG+Vb79u0/yGRbJbz11lubfP/99+2mTJnSVgNVX0ZUknK1ZZwjA5hSsWLFT1u0aDF06623/jSTpUAMGDBgc+WpoPwY50wZ5QidKxe8//77DWVQPSZNmtRCilZRsvnG2hKVNaNKlSrvdu7c+aH69etPDkIy0GpW7Jtvvun81Vdf7ah61VN7y/z222/rq818Z22q6jWyYcOGQ3faaaePM1mWwzPPPNNY5dVWPun2RnyP7cudd955LmlMnKNGjdpa1EUTaF3xUO9ifNNNvJPEO7px48bD1Ldvr8jwP/zww/qq544lSpTw9+B+3nfffV/IJK8Qb775ZosZM2a0ULnF1W8LFDWxW7dur5D24osv7rBw4cL62r43+fLLLw8XTxlNwuHDkkWLFs1Tv74g9w3l+1KG/wx5klC+ijoCbKvx3UZn/k1Vtyrq+6KSu57yzpPMKToOfNa6desh22yzzYeZbAVC47u9yudfcdaTjF8bNGjwetu2bSe+8sornT777LND1JZKkvdCv379bspk+ddijRm7BmH9559/vr2U6IDp06e3VAfXUjQfJCwq/4Yijfv6S6T4C9Tpv8gQxtSpU2ewBqz/Zptt9t0yKSvGc889t7kMcC8p+tYynk0lo6JkFpd/fZWPUvGds4WKm6W0H6Twg7bffvv7ZGA5v0Qq5dzq1Vdf/U+xYsVqZlbgSTLiy7VT2FEGtYPi6iqttGRtKPb1JZtsGMdUxb/VvXv381u2bPk1ka+//vouMqIjtJq1VJs3lqwSqsd64mULu1R+/sJktuo4WrubB6Vw92iH8PvfmghMFvfcc88d8rahTOX9SfW/adNNN31J/dpJhnCQlLOljKWG5JXI1Mdn4t80SfBF1rGVK1d+vkuXLrfI6McEhgTuu+++KyRvX8kopXzkGa52n1iY/z676KKL7lC/7KB8TGTzy5Ur99aZZ555kMIbXHrppU9oB7SVxnhj2i6iXiEffuXjA5QTVb9BJ5988rEhIQN2aJpgD1Ef7L5gwYLG4qukPg5/YgFw1W5cxnim5H5Xs2bNJzUGN1erVi1Mhkm89tprbTQul6iezZVnI+WZrgXgdulfxU8++aSHRHGnYKrG4TxNdvdnsv1rsUaM/b333qup1fyQ8ePH99Ds21hRJdW54euiDLa8YbAJe9CI06CO16z6ihTtMm3vCrxKK9nV33nnnQO0kneXwjSTrHIyKDnrB7nIRDZycTNYqkGdoNV0aNeuXc/VgI7NxGdxxx13nK06nywZFcknd6lkTJPRlJS/ODxWVpWX/ccUVimtXvN0Bn1eq+6Zav+xo0eP7qZ6bCJFL6Jys3VhC+v60Wb8oq+bNm167cEHH4xhZ6HVprUU9FHJ4B9bAq8mk680uc2XMVRVnfgzhyKBWcjUOdTR9SKP6j9V2/oXd9111zOVP98/osjIywwcOPAV1b8t9RGWFi9efMgBBxywz8qOATrO1Hj00UefkQ3yH3KUtUiG9uDRRx99uIyq89ChQ29VPeqr/qEe1A2X+uEHcmdp8rr2wAMPvChECMq79QcffHAmf1qhOlUmP31NHrcR4CcNF8ybN29cjRo1Hj3hhBPOVL7lPj7fv3//E7R6n6d+qURbIeX/Tf3JxL0+bZCskdppHa6JrsDd1r8Fq32BbvDgwa1eeOGF6ydPnnyCFJsViT8RnCeFG6MBG67OfEuDPUxG+rniZmIEACUQf02tBF2lJMfq7MTquRy0mu8o+TeNGzfuZMnaRopZQTKWSvZ0yRwt+kCy3pNCfC0/fwFk5VhPSllz5syZuw4ZMuQ/rJpBYAStkm3kVFgWCv9Msp5kVZJ3Q9X1Z5X3jRTiS8V/r/gFKIfKDysUX1dVm/eSQr0pAzpe5TZQOruDWSr/K8kYLvdj8Y5HOWk3hLKKGsl49xk5cmS4gGVo+9pNImqi6JRFO6Ssjb/99tvNlYd/Zf1NE8lEuZ9L5kdyP1W9JmeUOPxTK2UpXyWV2+WNN944PiM6C+1amumIwX++BSOkLK3OYwtz3v/xxx87qk+rUQYTmsqerm1x2P7riNFaZW6IXNLgoZ8y7SWOJfoXTfBf161b91nygMcff/zIl19++RbVqZv6pzLtpl6SM1kyRirvu/K/L/pS7LOoL7IhjUEtjcE+knHUMmm/A31SW7eRl/EMdYF0rNxA/YOx82360TrKDFHbkf2vxzLL+4N44okntnv33XfPVd9tLSqlAVgo+qJs2bKv63z2smZdOnM2vNra19I5rJuMrocGtBWKz8ApX9WpU6d21sB0EttL8BpPP/303m+//TYr7+aSw+OWSzVYYzVTc65+S/LfL1269Fgp4CIZdV1t8feW21WD2lhlhJ2FUFGr2DY6R3eRP3tO1ErSXJNAA/GE5Q2F5B9OlY8/6H9bO42BG2+88fsKL9FKUEn5D/jpp5/2FCsXjIIhqv5MDtVQUMnhotHH2lo+o1X7RfXBVPi04m/zxRdf/J+UvL3K2FD8YYVRHetop9JULD/DB6Twm8kpjmx4cGmD5M9XWV9qtX5LR4AXVa/RquN8ySiqOrVT3Q5UG7dWn1YgDyTDr6wz77baGjfbaqutvlhWQnjQhavkwQCA/DMqVar0SSa4Qsigt1T9eUAm1E9GOVZjMJS0UqVKjZDRPK52dtd4NmRHw/hiYBqfUZzXxTZLdZygo9sI8jz22GPHaMxOUlx2JyOZP2q395aOXgOrV6/O+M6RzCJqXy21c3dNkr1U5+aiDZgUlLeO+ndP6dUjKiN7kU3pdbVTaCI3TB7UJzMJLVT9P1RfvlOlSpW3VNYw5ePaw78ef3gb/9RTT3XU9vpCdRxPSRXToP4iIxzauHHjG/fee+9XM2zL4dlnn+2us+2FGoDNpDDKWgSFmCWFu+XEE088R3Fh3/zkk0/21bnqZIWbEGaQpDwf1a9f/26d8Z+WAk8jPgltM/eWAp0tu2qFoaCUGuR5OifeedJJJ/XLsDFRHamV9WLxVUEhUQrxTtS29B5tzS9JKgDfStcKfomU6kQpLxfFQjzy5Z8m5Xl02223vVpnwh9DQoTM2ZEzIf+kGpRP9LMmhfP233//sJXXSlRbk8/TUvhW9AmrNNty1W1SyZIln23SpMkdPXr0+AjeJNiaq36n8Viq5G+M0ZBXk9ck5fuvjgvZi0/XX3/9IE28e2TqjbF8toegye2HDEtOcOFMY/6Q6tOVfPSXjkgPagt9cIYlQDynabt/sdpXlHaId7qOEqf36tXr7gxLgPr/8I8//vgMyWnARCuDXqIJY5iOWzerOo9n2JaDdnq76th0ieRuTh0g6cW37du3P0vHlicybFzoPEAL0Q38yw3jS51Vn7kKD2jTps1V2rqvE6t5jD+0jZdiNdZseo46mjMWhj5b+v+clP2MFRk62H333Z/RtvEBdf4wKeXXMsSxGqzxWtU20sxdCh4Zx87M+JIdDF18XMV/tV27dqf37dv3noIMHey3334DtNo8LJlTGWAMS4PMHxpsIoWtlmFjO7u50irAI4VHGeaWL1/+mVyGDvjzgjp16rwu3rBi21hEC6RAz+yyyy6X5DJ0sMMOOwzXyjIa5ac+5JX7m/osu3XWdrSFFJ5zeeDBANQG/lf8ls6dO59dkKEDrYKzt9tuuys1Kbys+iyiPRi8ZJXlr5wybFwALKedT0381AES75iVGTpQf3FXoj5+6qgx/0U7jOyOwRBfbdVfopdNauKdqPF4J5McoG379poQ/k9lN0CWsEg7oRfUT31XZOhABv2cjgGPycs/toY4lVNJE12jEMhg4sSJHSS/gvowhMX7myaTgV26dLlwXTR0sMrGrlWkqLaGJ2rV2Fqrx0ZSLv7h4xUp2/kyCM6qK4U6/GYN7InKc6zy9N1xxx37aaJ4SMr6Gwop+SdLWZsymHIZrTekkBdIEd5eJmHF2GKLLR5W3qDAKBzKr0mlourMXxaFlZAtnuLDMSbD86VWoPtWtKXT6j2B1QFFRolYPVW/Uc2aNePK+gr/WFDyuRK/1AYvd5oUPHvRUNtx/kOdq/hhEpFc0u9TH92o9oQJZkXQCv6L6j5E3qnIAKpnUbWZv2cK0JFiK8nmDkYIq4w5TGAhsBIwGYm/Im2nfqr/lFq1ar2XSQ5QuRvIyJqpHRu5DPXRWE3SWb1gfLVj66f8zen+TF+8rXaeqclydIZthWjUqNEQ5RnnvqKdmoiy7ZThl9BRAv1ZP1NXeD6RDt24+eab55yQ1wWssrFru7mzVskdtFKVYqup/hypDrxKg1XoZ5655SQD/0Sr6GuaZV/WyvWKjH4kF4l0Rj9VKxwXVoyvZEw3dO/efaX3VA3uo2riGINionQZ5V+i+gbjlkI21k6iphVSE8FUbd+fVh3yKW8SUnb+qyxcC0CBJG+hVov3VLdhGZYCobzcggx/iJjBTzqThpWRCVQrIseacLtKDhezXlHf3CxDnwVPYSB5GFX2P9FUR25JZsd4/PjxbVWPcEGSNojGaJVc4U4MIEN91lp1Czsh2q7dzMSaNWvme1V12LBh7TQJ1qINGfnzqlatOkztyTb6rbfe6qtjRHulFWF7rbSZ2qldoW14oV971Q5sovL/il/5GeP1JCt7gVftbDh//vxw8ZO6qE7ztUN6UXpWaB36N2KVjJ0rnN9///0+GmweZEGBfylduvSLWnFXaCSFBedCKVVnDVxJwhqkOdryP6+t+YuBoZBAObWizJVCLLPyZQo6WytJuK89duzYbeVUYXWmHYr/XlthVsUVQqvkxnJ4gCfsFlTPn2UsK10ZP/30040xAvzUReD+9GeNGzcOKzYrppSzEoopP/RdgwYNHtBKlL14VxhINs8Y8L9qYYJTeLEm5ew9aBnZJkorkUnL09jxrPpKd2M6W2/C/X2OFuSljjL27zQ5T8+wBHz99ded1S/VMOKMwU/QKvx8Jjk8R6C+7yqeyvQfkEz+Zz1P5+u6H374YbUPPvig1uuvv77Z888/3+GVV17p8Oqrr+7w0ksv7SZ3V23/uXOzk/rzcGWtSzshYbHkZHdkmYmJB7lCuhaPMewGMsnrLFbJ2HXeayCl3EyDyN9yEvWtlDI7mKuLMWPGdEQhUQRIK+6Pkv+0Bmy5e6grwvDhw4vJMMtrwMNDLRp0LsyMrVSpUnjiTds8rozz98PBIDQxfF+5cuWVnuO0lW0uxSxH25ErGeO1moYryyuCJsjNlK82KyJlql1MEtkjyahRozoqvTqKiYKq7e9pS7vS3UISUuoycvhTxSBHmKdVMNxnl4GUV5+w6oar2KJf1R9fFOZKtMalnerHk5Ch/vLP0Kqe7xyutCKaEFrLLUn/wKuJhn9jzZ7rVYedtCsM53TSmTzUjxXeeeedG4cMGXLHM888c9vgwYPvlpHfLcO/SbuA2994441b33zzzf/JvUXh22Tsd2tROFsyqtJflKX6cL0le91BR6JWkp99ek+7r29l7OvkOT3GKhm7ZuZWcqqjtHS0BvMHGWOhzlkrgwZnPSlVV8muSFgGwX3U76WM3waGVQCrpLbptbx6CD9L1tf169efxeohhWNnErbUKIpWuO85WmR4c4L66RzYQt6SKCl5pUTfyWAmLuMoGDzWK6UOKw0kjNeKmn2UV6tdO9U1XE9QfeZVrFjxSy66hcRVgI4CjbWqBjmMj2iyjDKUM2nSpK2VVg9/pg4zcl1gywXl3UJ5ymUmTgx+nOSGW26G+pW33OpjXPQPbpUqVT6L+1Xba56uq6Q2+hgU5MnPBNBR9e0qd0e5bRXPI7lcoG2ouHqiOvLXkdza8pclH2VkdPEn9Wd4KEYTZ+lZs2Y1UHpR+kA8i9Wfn2lyLfRx6N+KVTJ2Ke1m6tywxRYWq0PnSknXyEsJXImfNm1aAw1QOLdKKbgfOnWzzTZbpa0s0KSxO8phpdKAj61Tp877pEnhdpYTVgWg9BmbbLLJSlfn7777rvLs2bObIQ9I9kKuC0iZV9h+9dF62hFtpvpkn8jj2QDtJH4iLEPnb48bK95nzoXa4hd4t6EgcMSSUbZT/YJRAk3G36vdwQi0td1aZXAMCROB+neydiUrfSmFx1g1Li00zn7ijEl4rAw53xOJks8DVeFJNdooP6t/9t0HxRVROxsqnseIw/33zKQ5Vf5vFc/DR1MUniX6VWH06zf8as8CpS2SGHZ48i5ZLBkLxTJPE/t49dd7HTt2DGOourbSDiccM6mrMJNdm8LZ6wbrKgpt7CiTOpZz0kYokzqbC1VFtbIve3h5NcEWVPLDrTcGSgrAletfV3WQOB//+OOPvZSvAnKkLPOknN/ofByUXlv47VT3SjYI8UyqVavW8BBYASSzjXYb1dktoKjKx8q40otKOovW106Ch3xCWAo6V0b2qbfP2uK3Ul3qUVeUU3VbKiNdpWML4Gq+JpUOkhOuhKucOdWqVXu3adOmE5lQZIxbKD70L1AZ41X/CZlggZCxd9QKXFf9mInJWxTX32D3on7hhaFg7Doa8Shr9nahzvPlNb41MXB46H/5x7Zq1epcHVlOaNeu3f/JPXGrrbY6oXXr1ue1aNHigpYtW56p9DOVdiz36jXx/6dNmzanK43Hn89T2hnivXi77ba7Xu0OA6rJnHcawoNP9KfGa7z6YaUvRK0LKLSxaytURAPE6iSdCTMzF8FKyAiyT2MVFlIGttDJB3pY2Xg2PSiC0nl5phK3yZYlFw5vv/32SVJ0zsjhfCk545o1a/actsW/fvvtt1VkENzyCedW8SwtU6bMNzrPh1V2RZBRdlCe8MAKyiqaoGPBu5nkAiEjbKO+2tjGLBk/S/lGZpJRzg5qbzWMIJO+kY4gVTPJhYIm4kqff/75fqpTPWRQPxnzZ2p3uGctQ6yi83owANdD7kxNctkr9wXhiy++2EH9WCXTl+SdVrVq1XxP3HE9QOf1pmpDuNUFqV9HiT97BFObykpGWNVl9FzgY0L4pmfPnrfvtttuz+++++7PyX1y1113fWivvfa6qlevXv8VXaP067t3734v7t57733xnnvueY3iLxddKbppn332uWPLLbcMLyOpvA0mT568peoRyqGtKmO06rvO3m6LUWhj15nnN9kIrxguySg75+oGo0ePbplhWSG4v/rQQw+ddfPNNw8QDbn99tsHyr1y0KBBm5MuebNE4dl2IGVdX6t9o8x1gkLh4YcfPmrcuHH7yCArMmmofnPKli07VLuP50iXYbVUXDUmk4wyTNfq9hETQRBQAFSn9XUebivFKUr9UGa2slplcr5VFkPnfLbw4dNM5CtWrNiPMvbs9lnpbdRuHjUOfSpFLant+Ob0V4ZlheAK9xtvvHGszss8DlycSUOGPVU7mYe0IoaLUto+15L80vhpN+Wo7Rto7Hitt0A899xzHWXETHK82BSMR/Ufp/rnu4UlQ65LGaQjW2XN0VHlky222IKtd4D6a67KXsBkqW4M12SYAD777LNwl2Jl4AnGF154odvAgQP7PvvsswfL7T1gwIBumeSA4cOHb6r6hg9a0p8qa77G/5M/cv3j34hCG7sG8jeurGrg59GRDKzcelpR+owaNap6hi0nxFP1lVdeuVqrxLHaTu4uZe6srWX76dOnb6qzXziTa2s2Q2evUQwQYcoQbSplOEyre2XiCoLqtMHdd999is79PGfti1CLpWDvsMXzRSLN+qz4YXufIZ7uWunbTsOGDdtME09t/OQT5vBOO54V4Z133imuSaKpDCBcIZeyL5URfO430T755BNeBMqeL5kQgHYCbV977bX9Q2AFePXVV+s89dRTZ2vlPkztrkp+5V2oc/qzMvR7M2wYFbuvYhiiJzpNCPVlGJsu41ge3AIbMWIEL5iEh5uoHyhfvvxn2j5nr3wDTaLbqF/D9QDqoPZM0lY/u3sBGoNJKn8y6cijzapLQx1zTlTcCt/RYHcnfTlL43CxDPo85bnoww8/PEntaphhCdBEvy1HrUwdoCmFvQi5LmCVLtBpdX9Lgz7JyqnB20jb4i5Sugt54SLDloWMvNTzzz/fXTPyXdru99RqXVN5eKGFlXuczmh3tm/fPntulJI+LwUYx6qMfK0AJSR/V+U/T8qX73FIQzN+q2uuueYGyT9BsgOP3N+0wn2olfc6b/G45iDD21JySyidKOrwY+3atVd6N4H7tsoXttasTGo/V6NX+okl8VbWlrUGbcko30wZe/YWECu4zsPVUH6Ai3yhjo4Nx9x///1HJ9+MA7zy++CDD+6vyeQ6TZjHa1LjSjV9xhdrXtUE9x8eUArMgpSf51ehUA+MAUOT7AM0Rtm3/gz16Ravv/76xdot8CZaMfiBDGmmjnPLTY46qmwjuaXZVVB/9S/XQZbj0wT5nmTNZFVHpvq/rIz4gHvuuecSnrHIsGWR0Z99Bg8e/IgM/kTJbaU+4mr8xpqkJ3Tq1OmeDGuA+pMXssq5P8U/rjAXX9cVrNKLMHS+Ov6aWbNmHaztXHgZhI7VasJLMLyV9bXc2RrEX7USltTMW0MK01CKxb3zDTO885R1+DbbbHPNDjvs8HRGdAAXkh544IHrZAD7SnnKWTFVzgzl5W26z1XGT5L1q4yopFbF2iqjifiaaGDLUB/xz5f/nQ4dOvx3p512yt4e+vjjjytr+zdYyojBI3O+lO+mfv36nZ5hKRA6bvxPCn08ykxeuS/usssuB63sMVa1ZXcp6U2qOwqKgX3apUuX3jLGcMFIu5GLtQ0/TfXl6brwbAEuvLjqq/HqqxHa8Xwtg56puA3V3o3Vp5vKYPggQ1X1dTAw0WKdg1/o2rXrSa1bt843gclwN9eEeb/qzVN6weCB6jNRk887kv+lyl6gvtuA7bgm2NZKbibZRTWObMGpC3X6umPHjgerX7NX2bnVpe30K5K1ZSaKuw0PnXbaab0zwSw0udTjZRp529NWZGbAA0+fazy+VJlz1ZSSIj4XVUs7EL7IU1V9FPjFxzv0L+24445Ha3uefVeful988cVviLd9pq+p933nnHNOnwzLOo9VWtm5zSRFukkd/4YGfhGGSKcqXFruVjp/HqQt3ZHffvvtMdoy95kzZ85uSmskheXVTj6BNKFSpUrPSOGPSRo6YDWS/Fs0WDzCyXvhwdglo7zC20oJD9NW7fTvvvvu7AkTJpwsg99fPG1FZaTAaM54TQiDOnfufFxs6EBb3S1Ux7B6oGiSOVXKtdKrtFLQklo9s69KCgtZ3QrzvLp2BNyqLGvjksvHOr4PAUHpW0pu1tClzAtEMwhTlibOmuq23dWXJ6vd54v/bG29j1Y7dlJaeGkGXhn+fG2bX+jevfuxSUMHMtBPtZ19W7J/9YQluays1WRMPTVm54gu1O7ofMk/XPVsLeIzYvRTGGPqU7JkyYlVq1bNtz1XvjaanMNdiky9qUvOl3bY/jdq1OgB1WMMhku/0Abl5as37dW+vpr8TpTMvlql99bE004yw44K2eIbKwO/RYZ+QGzo4I033uBR4HAhlLqKZmlSWOldlnUJq2TsQIb6mc6D56jzMdag8HQu0GCsL5IObcQZlYtZS6SIs0RfSsmeqV+//oVSyKPj96uT2HXXXT+VUlwi78NSolFStgUMIJDLp4VKYUBs8TW4JMyQonym+gyUIp3RrVu3o7bddtuwdY8xZswY3v7igwW/SM505R0hZVjpY77a+m+iSYsPWv6KwqlO32sLmW8iyQV2QVqZ6kipl2I0yjdHk8QXvi/PsUerZvaRT9Vrto4xN7Rt2/YQlfOa8oTJFFJ/Mk7c8lQ3Lrt1JSPFYH9T3k/Vn5dqXA5r1qxZzltp4lksnms06b6sCXIeBiaZXq2Rh3wN3Qacb37TDmG4jj9naWXkAx7B2FXWEuX/2tc/DBnnzuIpRxuBZE5W/7wZAjlw4IEH3q5xuk4y2V4r67JrAdQJ0LZMf4S4jDtdu48hMvLeBx10UL9cF9y0K2ynvioBf6bOoxo0aPBWJjmFsErb+BhS1qrvvfceH4vYSdvKelJCVk1un/FRRgxjipRnvFaDr7WCviklfleKku9Z6hVh2LBhpbWq7qDtc2fJ45luvpBSUjK5vz8HpZIy8sLL5zKiES1atBi+opdGrr322t1lIHw0gyfMeG5++Nlnn53zo4cxBg4cuJnOk3uofdzW4h3tr3RWvG1lK7uODDVGjBjRS/k2V90rq74zmzZt+mDPnj3Dl10ee+yx0zQhXCRFLoZyK/1jTXQH6njz1XPPPdf2s88+O159215pdcXD11WCEmcMfGr58uW/1yr7svr0vsK+ycXz51wQ005hO9WLh47KM5FQviZkHuT5XmfcF9S+m/mYpo4v52t13U7pJVT2ZE0mt+yxxx4vL5O2DLfccsvZXFeRt7T6hp3DR5p4TvekVhC0Em/50UcfHc7dCMnnmgMf3gh1oZ0iXpv+WTvBzzR5PN6yZctBK3q099Zbbz1cO7BdJKKUxnia3A+1o+FFouxZYV3HHzZ2g7OwDLK2tl2crYprduVCEC968Fz0GA3YFCnPsidY/gC45aJBrCqFqiGDCB9xlILO0rlwshRyhnYBOT82WBBUPRRqlR9aUT5WPfqLDx4u28qsBJT11VdflZQRrCejWS+ejGQkA3QU6SXFzMTkvbj33nv3spFwFtZqtbn6lodEqsowuU32i/r0W3YIMoAvxbvC12oLwptvvtlUW+XWmqTZeZRRHebpePEJr6xqB5CVSd9rQimuspeKbwNNKst9bpljjhy+2cd7CEs0NvNXZugxtGDU0xFlC40vX5LleXbGd6aM/Gu19TuN8bdq60r/WIJbkNpJFZfehQlBbWFHWKhxWlew2saeYtUxfPjwOi+88MKz2lJzDz5sW6Xcdx5//PFH/5GJKEWKwmCVz+wpVh8TJ05sNWfOnOqcmznrakWbraPOF6mhp1ibSI39L4DOqTwrX5qzKRekdM6dpK15+vz2PxicXjPevy3SbfxqgHP1Bx980Pr111/f+bvvvms6evToptqac4GI78vN3WSTTb5u3br18I4dOz635557Zm8DXXbZZXfovHyEFCTccitatOhr3bt331tn3XwXMFEgzp3CBnJ5AyyEM8lZfPTRR7V1NGir82/HCRMm1Jw3bx4PDi2pXLnytC222OL9HXfc8fm2bduu9I84eGru888/b/Xuu+/uIDm1pk+fzrMOS0qUKDG/fPny01u1ajW8Xbt2fF1old8NT7YlE50PX331VaUvv/yygeqw5WeffdZy2rRpFdRPpdVHCytUqDB90003Ha12vK0+HeEPf/yV4KWrV155petrr72206RJk6rtvPPOz/33v/+9NpNcIMg3YsSIzUaOHNlG7W0hvWkyY8aM8JSoxu232rVrf0s7NXY8j/JO06ZNV/ktyFxIjf0P4Lbbbuv04osv7jV06NCeM2fO5D5wvn6UMqPcmVDAEg3ei4cddtjtckc888wzN4uHb8RzS25p1apVb/2///u/4zK8AW+++WbDK6+88nLxhCfYtAvgIxt8N33e0Ucffdsuu+zy8YABA9o/8cQTvQcPHryfjIK7DLnGc2nZsmWn77PPPg+edtpplzbM8e84Tz311NaPP/74oVLaXX7++Wc+SFmgXmgXsqBTp06DVYcb9tprrxV+YOPpp59ud//99x/JhTcuMCovr64ywc064ogjbt91113DM/Zvv/12nSeffPLgl19+eTcZOu+yr2jHuVTG8PW+++57X+/eve9r0aJFvr/gygUu3skIjx43blyT4sWLh8e9DfXppGOPPfZ+tSl7YfLBBx/cUX2yu8aIuyA8HxIuzpYsWXLeJZdccqnKn3PyySef+thjj/X96aefeDyb/lp68cUXH3feeefdiowkaJPGapshQ4Z0Uz/vPnbsWP5MBRSkO+FHC8Zn+++//219+/bN96nsFGsZUoLWW2211QCdtbnazGDwGm5wTRqsfEScFMa8/MHjNzLs0RdeeOH8c845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',
                                                width: 70,
                                                height: 70,
                                                padding: 10
                                            },
                                            {
                                                width: '*',
                                                text: ''
                                            }

                                        ],
                                    }, ]

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
                                                },
                                                {
                                                    text: 'Página ' + currentPage +
                                                        ' de ' + pageCount,
                                                    alignment: 'center',
                                                    margin: [0, 10]
                                                }
                                            ],
                                            margin: [10, 0]
                                        };
                                    };
                                    // Ocultar la columna "Acción" en el PDF


                                }
                            },
                            {
                                extend: 'print',
                                text: 'Imprimir',
                                customize: function(win) {
                                        // Ocultar la columna "Acción" en la impresión
                                        $(win.document.body).find('table').find('th:eq(4),td:eq(4)')
                                            .remove();

                                        // Obtener la fecha
                                        var now = obtenerFechaHora();

                                        // Agregar la fecha en el lado contrario de la paginación
                                        var pageInfo = $(win.document.body).find('div').filter(
                                            function() {
                                                return $(this).text().match(
                                                /Página \d+ de \d+/);
                                            });

                                        if (pageInfo.length > 0) {
                                            var pageDiv = pageInfo.first();
                                            pageDiv.html(pageDiv.html() + ' - ' + now);
                                        } else {
                                            $(win.document.body).find('div').last().append('<div>' +
                                                now + '</div>');
                                        }

                                        // Agregar una imagen en formato data:image/png;base64
                                        var base64Image =
                                            'data:image/png;base64,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X5LleXbGd6aM/Gu19TuN8bdq60r/WIJbkNpJFZfehQlBbWFHWKhxWlew2saeYtUxfPjwOi+88MKz2lJzDz5sW6Xcdx5//PFH/5GJKEWKwmCVz+wpVh8TJ05sNWfOnOqcmznrakWbraPOF6mhp1ibSI39L4DOqTwrX5qzKRekdM6dpK15+vz2PxicXjPevy3SbfxqgHP1Bx980Pr111/f+bvvvms6evToptqac4GI78vN3WSTTb5u3br18I4dOz635557Zm8DXXbZZXfovHyEFCTccitatOhr3bt331tn3XwXMFEgzp3CBnJ5AyyEM8lZfPTRR7V1NGir82/HCRMm1Jw3bx4PDi2pXLnytC222OL9HXfc8fm2bduu9I84eGru888/b/Xuu+/uIDm1pk+fzrMOS0qUKDG/fPny01u1ajW8Xbt2fF1old8NT7YlE50PX331VaUvv/yygeqw5WeffdZy2rRpFdRPpdVHCytUqDB90003Ha12vK0+HeEPf/yV4KWrV155petrr72206RJk6rtvPPOz/33v/+9NpNcIMg3YsSIzUaOHNlG7W0hvWkyY8aM8JSoxu232rVrf0s7NXY8j/JO06ZNV/ktyFxIjf0P4Lbbbuv04osv7jV06NCeM2fO5D5wvn6UMqPcmVDAEg3ei4cddtjtckc888wzN4uHb8RzS25p1apVb/2///u/4zK8AW+++WbDK6+88nLxhCfYtAvgIxt8N33e0Ucffdsuu+zy8YABA9o/8cQTvQcPHryfjIK7DLnGc2nZsmWn77PPPg+edtpplzbM8e84Tz311NaPP/74oVLaXX7++Wc+SFmgXmgXsqBTp06DVYcb9tprrxV+YOPpp59ud//99x/JhTcuMCovr64ywc064ogjbt91113DM/Zvv/12nSeffPLgl19+eTcZOu+yr2jHuVTG8PW+++57X+/eve9r0aJFvr/gygUu3skIjx43blyT4sWLh8e9DfXppGOPPfZ+tSl7YfLBBx/cUX2yu8aIuyA8HxIuzpYsWXLeJZdccqnKn3PyySef+thjj/X96aefeDyb/lp68cUXH3feeefdiowkaJPGapshQ4Z0Uz/vPnbsWP5MBRSkO+FHC8Zn+++//219+/bN96nsFGsZUoLWW2211QCdtbnazGDwGm5wTRqsfEScFMa8/MHjNzLs0RdeeOH8c845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';

                                        // Crea un elemento de imagen y establece su fuente
                                        var img = new Image();
                                        img.src = base64Image;
                                        img.width = 50;
                                        img.style.position = 'absolute';
                                        img.style.right =
                                        '5px'; // Ajusta la posición horizontal según tus necesidades
                                        img.style.top =
                                        '5px'; // Ajusta la posición vertical según tus necesidades

                                        // Agregar la imagen al encabezado
                                        win.document.body.insertBefore(img, win.document.body
                                            .firstChild);
                                    }

                            },
                            {
                                extend: 'excelHtml5',
                                text: 'Excel',
                                title: 'Reporte de Personas Imperio Informatico',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                                }

                            }
                        ]
                    },
                    {
                        extend: 'colvis',
                        text: 'Columnas visibles', // Botón de columnas visible
                        columns: ':not(.no-export)'
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




        <
        script >
            function actualizar() {
                var nombreApellido = document.getElementById("nombre_apellido").value;
                var nombre = nombreApellido.split(' ')[0];
                var apellido = nombreApellido.split(' ')[1];
            }
    </script>

    <script>
        function validateDNI(input) {
            const value = input.value;
            const maxLength = 13;

            if (value.length > maxLength) {
                input.value = value.slice(0, maxLength);
            }

            if (value.length === maxLength) {
                input.setCustomValidity(""); // Limpiar el mensaje de error personalizado
            } else {
                input.setCustomValidity("El DNI debe tener 13 dígitos.");
            }
        }
    </script>


    <script>
        function validateRTN(input) {
            const value = input.value;
            const maxLength = 14;

            if (value.length > maxLength) {
                input.value = value.slice(0, maxLength);
            }

            if (value.length === maxLength) {
                input.setCustomValidity(""); // Limpiar el mensaje de error personalizado
            } else {
                input.setCustomValidity("El RTN debe tener 14 dígitos.");
            }
        }
    </script>

    <script>
        function validateNUMERO(input) {
            const value = input.value;
            const maxLength = 8;

            if (value.length > maxLength) {
                input.value = value.slice(0, maxLength);
            }
        }
    </script>

    <script>
        setTimeout(function() {
            $('.alert').alert('close'); // Cierra automáticamente todas las alertas después de 5 segundos
        }, 5000); // 5000 ms = 5 segundos
    </script>

    <script>
        function cleanInputValue(inputElement) {
            var inputValue = inputElement.value;
            var cleanValue = inputValue.replace(/[^a-z A-Z]/g, "");
            if (cleanValue !== inputValue) {
                inputElement.value = cleanValue;
            }
        }

        var alphanumericInputs = document.querySelectorAll(".alphanumeric-input");
        alphanumericInputs.forEach(function(input) {
            input.addEventListener("input", function() {
                cleanInputValue(this);
            });
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stop
