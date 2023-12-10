@extends('adminlte::page')
@section('title', 'Persona')

@section('content_header')
    <h4><b>Registro de Datos</b></h4>

    <style>
        label.form-label {
            font-weight: normal;
        }
    </style>
@stop

@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form id="formularioPrincipal" action="{{ route('Post-Persona.store') }}" method="post" class="was-validated">
 @csrf

    <!-- Sección de Información Personal -->
    <div class="card">
        <div class="card-header"><b>INFORMACION PERSONAL</b></div>
        <div class="card-body">
            <!-- Primera Fila -->
            <div class="row">
                <div class="col-md-4">
                    <label for="nombre" class="form-label" style="font-weight: normal;">Nombre</label>
                    <x-adminlte-input type="text" class="form-control alphanumeric-input" name="NOM_PERSONA" placeholder="Ingrese su Nombre aquí" required minlength="3" maxlength="50"/>
                </div>
                <div class="col-md-4">
                    <label for="apellido" class="form-label" style="font-weight: normal;">Apellido</label>
                    <x-adminlte-input type="text" class="form-control alphanumeric-input" name="APE_PERSONA" placeholder="Ingrese su Apellido aquí" required minlength="3" maxlength="50"/>
                </div>
                
                <div class="col-md-4">
                    <label for="dni" class="form-label" style="font-weight: normal;">DNI</label>
                    <x-adminlte-input type="number" class="form-control" name="DNI_PERSONA" placeholder="Ingrese su DNI de 13 dígitos" required oninput="validateDNI(this)"/>
                    <div class="invalid-feedback">Por favor, ingresa un DNI válido de 13 dígitos.</div>
                   </div>
                </div>
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

            

            <!-- Segunda Fila -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="fechaNacimiento" class="form-label" style="font-weight: normal;">Fecha Nacimiento</label>
                    <input type="date" class="form-control" max="<?= date('Y-m-d') ?>" name="FEC_NAC_PERSONA" required>
                </div>
                <div class="col-md-4">
                    <label for="lugarNacimiento" class="form-label" style="font-weight: normal;">Lugar Nacimiento</label>
                    <input type="text" class="form-control alphanumeric-input" name="LUG_NAC_PERSONA" required minlength="3" maxlength="50">
                </div>
                <div class="col-md-4">
                    <label for="SEX_PERSONA" class="form-label" style="font-weight: normal;">Sexo</label>
                    <select class="form-control" name="SEX_PERSONA" required>
                        <option value="" selected disabled>Seleccione una opción</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>
                </div>
            </div>

            <!-- Tercera Fila -->
            <div class="row mb-3">
                <div class="col-md-4 mb-6">
                    <label for="numeroTelefono" class="form-label" style="font-weight: normal;">Número Teléfono</label>
                    <input type="number" class="form-control" name="NUM_TELEFONO" required oninput="validateNUMERO(this)">
                </div>
                <script>
                                function validateNUMERO(input) {
                                    const value = input.value;
                                    const maxLength = 8;

                                    if (value.length > maxLength) {
                                        input.value = value.slice(0, maxLength);
                                    }

                                    if (value.length === maxLength) {
                                        input.setCustomValidity(""); // Limpiar el mensaje de error personalizado
                                    } else {
                                        input.setCustomValidity("El NUMERO debe tener 8 dígitos.");
                                    }
                                }
                            </script>

                
                <div class="col-md-4">
                    <label for="email" class="form-label" style="font-weight: normal;">Correo Electrónico</label>
                    <input type="email" id="email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$" size="30" class="form-control" name="CORREO_ELECTRONICO" required>
                </div>

                <div class="col-md-4">
                                <label for="dni" class="form-label" style="font-weight: normal;">Municipio</label>
                                <select class="form-control js-example-basic-single" name="COD_MUNICIPIO"
                                    id="COD_MUNICIPIO" required>
                                    <option value="" selected disabled> Seleccionar Municipio </option>
                                    @foreach ($ResulMunicipio as $Municipio)
                                        <option value="{{ $Municipio['COD_MUNICIPIO'] }}">{{ $Municipio['NOM_MUNICIPIO'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="direccion" class="form-label" style="font-weight: normal;">Dirección</label>
                    <input type="text" class="form-control" name="DES_DIRECCION" id="direccionInput" required minlength="3" maxlength="50">
                    <p id="direccionError" style="color: red; font-size: 14px;"></p>
                </div>
            </div>
        </div>
    </div>



<!-- Sección de Información Laboral -->
<div class="card">
    <div class="card-header"><b>INFORMACION LABORAL</b></div>
      <div class="card-body">
        <!-- Campos de información laboral -->
         <!-- Primera Fila -->
        <div class="row mb-3">
        <div class="col-md-4">
              <label for="nombre" style="font-weight: normal;">Sucursal</label>
              <select class="form-control js-example-basic-single" name="COD_SUCURSAL"
                                    id="COD_SUCURSAL" required>
                                    <option value="" selected disabled> Seleccionar Sucursal </option>
                                    @foreach ($ResulSucursal as $Sucursal)
                                        <option value="{{ $Sucursal['COD_SUCURSAL'] }}">{{ $Sucursal['NOM_SUCURSAL'] }}
                                        </option>
                                    @endforeach
                 </select>
                </div>   

                <div class="col-md-4">
                             <label for="nombre" style="font-weight: normal;">Departamento Empresa</label>
                               <select class="form-control js-example-basic-single" name="COD_DEPTO_EMPRESA"
                                    id="COD_DEPTO_EMPRESA" required>
                                    <option value="" selected disabled> Seleccionar Departamento Empresa </option>
                                    @foreach ($ResulDeptoEmpresa as $DeptoEmpresa)
                                        <option value="{{ $DeptoEmpresa['COD_DEPTO_EMPRESA'] }}">
                                            {{ $DeptoEmpresa['NOM_DEPTO_EMPRESA'] }}</option>
                                    @endforeach
                                </select>
                </div>          
            
            <div class="col-md-4">
                <label for="TIP_CONTRATO" class="form-label" style="font-weight: normal;">Tipo de Contrato</label>
                <select class="form-control" name="TIP_CONTRATO" required>
                    <option value="" selected disabled>Seleccione una opción</option>
                    <option value="Temporal">Temporal</option>
                    <option value="Permanente">Permanente</option>
                </select>
            </div>
        </div>
          
         <!-- Segunda Fila -->
         <div class="row">
               <div class="col-md-6">
                                <label for="PUE_TRA_EMPLEADO" class="form-label" style="font-weight: normal;">Puesto Trabajo del Empleado</label>
                                <select class="form-control" name="PUE_TRA_EMPLEADO" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Gerente">Gerente</option>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Jefe de Planta">Jefe de Planta</option>
                                    <option value="Conserje">Conserje</option>
                                    <option value="Guardia">Guardia</option>
                                    <option value="Jefe de Sucursal">Jefe de Sucursal</option>
                                    <option value="Contador">Contador</option>
                                    <option value="Gerente de RRHH">Gerente de RRHH</option>
                                    <option value="Especialista en Marketing">Especialista en Marketing</option>
                                    <option value="Gerente de Ventas">Gerente de Ventas</option>
                                    <option value="Gerente de TI">Gerente de TI</option>
                                    <option value="Abogado Comporativo">Abogado Corporativo</option>
                                </select>
                                <div class="valid-feedback"></div>
                            </div>

                       <div class="col-md-6">
                          <label for="nombre" class="form-label" style="font-weight: normal;">Fecha Ingreso</label>
                          <input type="date" class="form-control" min="2015-01-01" max="<?= date('Y-m-d') ?>" name="FEC_INGRESO" required>                                  
                       </div> 
                  </div> 
    </div>
</div>

                
    
        <!-- Sección de Información Bancaria y Seguro Social -->
        <div class="card mt-3">
            <div class="card-header"><b>INFORMACION BANCARIA Y SEGURO SOCIAL</b></div>
            <div class="card-body">
                <!-- Campos de información bancaria y seguro social -->
                <!-- Número Seguro Social, Salario Base, Nombre del Banco, Descripción Banco, Número de Cuenta -->
                <!-- ... -->
                <div class="row mb-3">
                <div class="col-md-4">
                                <label for="dni" class="form-label" style="font-weight: normal;">Número Seguro Social</label>
                                <input type="number" class="form-control" name="NUM_SEG_SOCIAL" required
                                    oninput="validateSEGURO(this)">
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

                           <div class="col-md-4">
                                <label for="dni" class="form-label" style="font-weight: normal;">Salario Base Empleado</label>
                                <input type="number" class="form-control" name="SAL_BAS_EMPLEADO" required>
                            </div>

                            
                            <div class="col-md-4">
                                <label for="dni" class="form-label" style="font-weight: normal;">Nombre del Banco</label>
                                <input type="text" class="form-control" name="NOM_BANCO" required minlength="5"
                                    maxlength="50">
                            </div>
                </div>

                 <div class="row">      
                     <div class="col-md-6">
                                <label for="dni" class="form-label" style="font-weight: normal;">Descripción Banco</label>
                                <input type="text" class="form-control alphanumeric-input" name="DES_BANCO" required
                                    minlength="5" maxlength="50">
                      </div>

                      <div class="col-md-6">
                                <label for="dni" class="form-label" style="font-weight: normal;">Número Cuenta de Banco</label>
                                <input type="number" class="form-control" name="NUM_CTA_BANCO" required
                                    oninput="validateCUENTA(this)">
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
                </div>
            </div>
        </div>

        <!-- Botones del formulario -->
    <div class="mt-3 d-flex justify-content-start">
                    <!-- Botón Regresar -->
    <button class="btn btn-danger mr-2" style="margin-bottom: 5px; type="button" >
    <a href="{{ route('Persona.index') }}" class="text-white">REGRESAR</a></button>      
    <!-- Botón Guardar -->
    <button class="btn btn-primary mr-2" type="submit" form="formularioPrincipal" style="margin-bottom: 5px;">GUARDAR</button>
    </form>
</div>

@stop

@section('footer')
<div class="float-right d-none d-sm-block">
        <b>Version</b> 3.1.0
    </div>
     <strong>Copyright &copy; 2023 <a href="https://www.unah.edu.hn" target="_blank">UNAH</a>.</strong> <b>All rights
        reserved.
@stop
