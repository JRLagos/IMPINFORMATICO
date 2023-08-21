@extends('adminlte::page')

  @section('title', 'Personas')

  @section('content_header')

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />



<div class="d-grid gap-2 d-md-flex justify-content-between align-items-center">
    <h1><b>Registro de Personas</b></h1>
  <button class="btn btn-dark btn-lg" data-bs-toggle="modal" data-bs-target="#addPersona" type="button"><b>Agregar Empleado</b></button>
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
       
    <!-- Modal para agregar un nuevo producto -->
    <div class="modal fade bd-example-modal-sm" id="addPersona" tabindex="-1" >
    <div class="modal-dialog">
      <div class="modal-content">
                    <div class="modal-header">
                    <h3>Personas</h3>
                    <button class="btn btn-close " data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <h4>Ingresar nuevo registro</h4>

                    <form action="{{route('Post-Persona.store')}}" method="post" class="was-validated">
                    @csrf
                    

                        <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Nombre</label>
                    <input type="text" class="form-control alphanumeric-input"  name="NOM_PERSONA" required minlength="3" maxlength="50">
                    <div class="invalid-feedback">
                      Por favor, ingresa un nombre válido (al menos 3 caracteres).
                    </div>                     
                    </div>
                     
                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Apellido</label>
                    <input type="text" class="form-control alphanumeric-input"  name="APE_PERSONA" required minlength="5" maxlength="50">                   
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">DNI</label>
                    <input type="number"  class="form-control" name="DNI_PERSONA" required  oninput="validateDNI(this)">
                    <div class="invalid-feedback">
                      Por favor, ingresa un DNI válido de 13 digitos.
                    </div>   
                    </div>
                  
                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">RTN</label>
                    <input type="number"  class="form-control" name="RTN_PERSONA" required  oninput="validateRTN(this)">
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
                    <input type="number" class="form-control" name="NUM_TELEFONO" required  oninput="validateNUMERO(this)">
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
                    <input type="number" id="tentacles"  min="18" max="55" class="form-control" name="EDAD_PERSONA" required>
                    </div>
                    
                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Fecha Nacimiento Persona</label>
                    <input type="date" class="form-control" max="<?= date('Y-m-d'); ?>" name="FEC_NAC_PERSONA" required>
                    </div>
                    
                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Lugar Nacimiento Persona</label>
                    <input type="text" class="form-control alphanumeric-input" name="LUG_NAC_PERSONA" required minlength="3" maxlength="50">                   
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
                    <label for="dni" class="form-label">Correo Electronico</label>
                    <input type="email" id="email" pattern=".+@gmail\.com]-.+@hotmail\.com-.+@outlook\.com" size="30" class="form-control alphanumeric-input" name="CORREO_ELECTRONICO" required>                   
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Descripción Correo</label>
                    <input type="text" class="form-control alphanumeric-input" name="DES_CORREO" required minlength="7" maxlength="50">                   
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
                    <input type="text" class="form-control alphanumeric-input" name="NOM_CENTRO_ESTUDIO" required minlength="4" maxlength="50">                   
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Municipio</label>
                    <select class="form-control js-example-basic-single"  name="COD_MUNICIPIO" id="COD_MUNICIPIO">
                    <option value="" selected disabled> Seleccionar Municipio </option>
                    @foreach ($ResulMunicipio as $Municipio)
                    <option value="{{ $Municipio['COD_MUNICIPIO'] }}">{{ $Municipio['NOM_MUNICIPIO'] }}</option>
                    @endforeach
                    </select>
                    </div>
                    
                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Direccion</label>
                    <input type="text" class="form-control" name="DES_DIRECCION" required minlength="3" maxlength="50">                   
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Sucursal</label>
                    <select class="form-control js-example-basic-single"  name="COD_SUCURSAL" id="COD_SUCURSAL">
                    <option> Seleccionar Sucursal </option>
                    @foreach ($ResulSucursal as $Sucursal)
                    <option value="{{ $Sucursal['COD_SUCURSAL'] }}">{{ $Sucursal['NOM_SUCURSAL'] }}</option>
                    @endforeach
                    </select>
                    </div>
                    
                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Departamento Empresa</label>
                    <select class="form-control js-example-basic-single"  name="COD_DEPTO_EMPRESA" id="COD_DEPTO_EMPRESA">
                    <option value="" selected disabled> Seleccionar Departamento Empresa </option>
                    @foreach ($ResulDeptoEmpresa as $DeptoEmpresa)
                    <option value="{{ $DeptoEmpresa['COD_DEPTO_EMPRESA'] }}">{{ $DeptoEmpresa['NOM_DEPTO_EMPRESA'] }}</option>
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
                    <input type="date" class="form-control" max="<?= date('Y-m-d'); ?>" name="FEC_INGRESO" required>
                    </div>
                    
                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Fecha Egreso</label>
                    <input type="date" class="form-control"  name="FEC_EGRESO" required>
                    </div>


                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Número Seguro Social</label>
                    <input type="number" class="form-control" name="NUM_SEG_SOCIAL" required  oninput="validateSEGURO(this)">
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
                    <input type="text" class="form-control" name="NOM_BANCO" required minlength="5" maxlength="50">                   
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Descripción Banco</label>
                    <input type="text" class="form-control alphanumeric-input" name="DES_BANCO" required minlength="5" maxlength="50">                   
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Número de Cuenta Banco</label>
                    <input type="number" class="form-control" name="NUM_CTA_BANCO" required oninput="validateCUENTA(this)">
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

  
    @if(session('success'))
        <div class="alert alert-warning alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif    

  

   <!-- /.card-header -->
 <div class="table-responsive p-0">
 <br>
  <table id="persona" class="table table-striped table-bordered table-condensed table-hover">
    <thead class="bg-dark">
    <tr> 
        <th style="text-align: center;">#</th>
        <th style="text-align: center;">Nombre Completo</TH>
        <th style="text-align: center;">DNI Persona</th>
        <th style="text-align: center;">RTN Persona</th>
       <th style="text-align: center;">Tipo Teléfono</th> 
        <th style="text-align: center;">Número Teléfono</th>
        <th style="text-align: center;">Sexo</th>
        <th style="text-align: center;">Edad</th>
        <th style="text-align: center;">Fecha Nacimiento</th>
        <th style="text-align: center;">Lugar Nacimiento</th>
        <th style="text-align: center;">Estado Civil</th>
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
          <td style="text-align: center;">{{ $Persona['RTN_PERSONA'] }}</td>
          <td style="text-align: center;">{{ $Persona['TIP_TELEFONO'] }}</td> 
          <td style="text-align: center;">{{ $Persona['NUM_TELEFONO'] }}</td>
          <td style="text-align: center;">{{ $Persona['SEX_PERSONA'] }}</td>
          <td style="text-align: center;">{{ $Persona['EDAD_PERSONA'] }}</td>
          <td style="text-align: center;">{{ date('d-m-Y', strtotime($Persona['FEC_NAC_PERSONA'])) }}</td>
          <td style="text-align: center;">{{ $Persona['LUG_NAC_PERSONA'] }}</td>
          <td style="text-align: center;">{{ $Persona['IND_CIVIL'] }}</td>
          <td style="text-align: center;">
                <button value="Editar" title="Editar" class="btn btn-warning" type="button" data-toggle="modal" data-target="#UpdPersona-{{$Persona['COD_PERSONA']}}">
                  <i class='fas fa-edit' style='font-size:15px;'></i>
                </button>
              </td>
            </tr>
        <!-- Modal for editing goes here -->

  <div class="modal fade bd-example-modal-sm" id="UpdPersona-{{$Persona['COD_PERSONA']}}" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><b>Editar Persona</b></h4>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        
            <div class="modal-body">
              <h4><p>Ingresar nuevos datos</p></h4>
              <hr>
                <form action="{{route('Upd-Persona.update')}}" method="post" class="was-validated">
                @csrf

                    <input type="hidden" class="form-control" name="COD_PERSONA"  value="{{$Persona['COD_PERSONA']}}">

                  <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Nombre Completo</label>
                    <input type="text" class="form-control alphanumeric-input" pattern=".{3,}" name="nombre_apellido" value="{{$Persona['NOMBRE_COMPLETO']}}" required maxlength="50">                   
                  </div>
 

                  <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">DNI Persona</label>
                    <input type="number" class="form-control"  name="DNI_PERSONA" value="{{$Persona['DNI_PERSONA']}}" required>
                    <span class="validity"></span>
                  </div>

  
                  <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">RTN Persona</label>
                    <input type="number" class="form-control"  name="RTN_PERSONA" value="{{$Persona['RTN_PERSONA']}}" required>
                    <span class="validity"></span>
                  </div>

                  <div class="mb-3 mt-3">
                    <label for="TIP_TELEFONO" class="form-label">Tipo de Télefono</label>
                    <select class="form-control" name="TIP_TELEFONO" required>
                    <option value="" style="display: none;" disabled>Seleccione una opción</option>
                    <option value="Fijo" {{ $Persona['TIP_TELEFONO'] === 'Fijo' ? 'selected' : '' }}>Fijo</option>
                    <option value="Celular" {{ $Persona['TIP_TELEFONO'] === 'Celular' ? 'selected' : '' }}>Celular</option>
                  </select>
                 <div class="valid-feedback"></div>
                 </div>

                  
                   <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Número Télefono</label>
                    <input type="number" class="form-control" name="NUM_TELEFONO" value="{{$Persona['NUM_TELEFONO']}}" required oninput="validateNUMERO(this)">
                  </div> 
                  
                  <div class="mb-3 mt-3">
                    <label for="TIP_TELEFONO" class="form-label">SEXO</label>
                    <select class="form-control" name="SEX_PERSONA" required>
                    <option value="" style="display: none;" disabled>Seleccione una opción</option>
                    <option value="Masculino" {{ $Persona['SEX_PERSONA'] === 'Masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="Femenino" {{ $Persona['SEX_PERSONA'] === 'Femenino' ? 'selected' : '' }}>Femenino</option>
                  </select>
                 <div class="valid-feedback"></div>
                 </div>

                  
                   <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Edad</label>
                    <input type="number" class="form-control" name="EDAD_PERSONA" value="{{$Persona['EDAD_PERSONA']}}" required>
                  </div> 
                    
                  <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Fecha Nacimiento</label>
                    <input type="date" class="form-control"  max="<?= date('Y-m-d'); ?>" name="FEC_NAC_PERSONA" value="{{date('Y-m-d',strtotime($Persona['FEC_NAC_PERSONA']))}}" required>
                  </div>
                    
                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Lugar Nacimiento Persona</label>
                    <input type="text" class="form-control alphanumeric-input" name="LUG_NAC_PERSONA"  value="{{$Persona['LUG_NAC_PERSONA']}}" required minlength="3" maxlength="50">                   
                    </div>
                     
                  <div class="mb-3 mt-3">
                   <label for="IND_CIVIL" class="form-label">Estado Civil</label>
                   <select class="form-control" name="IND_CIVIL" required>
                   <option value="" style="display: none;" disabled>Seleccione una opción</option>
                   <option value="Soltero" {{ $Persona['IND_CIVIL'] === 'Soltero' ? 'selected' : '' }}>Soltero</option>
                   <option value="Casado" {{ $Persona['IND_CIVIL'] === 'Casado' ? 'selected' : '' }}>Casado</option>
                   <option value="Union Libre" {{ $Persona['IND_CIVIL'] === 'Union_Libre ' ? 'selected' : '' }}>Union Libre</option>
                   <option value="Divorciado" {{ $Persona['IND_CIVIL'] === 'Divorciado' ? 'selected' : '' }}>Divorciado</option>
                   <option value="Viudo" {{ $Persona['IND_CIVIL'] === 'Viudo' ? 'selected' : '' }}>Viudo</option>
                   </select>
                   <div class="valid-feedback"></div>
                   </div>
               
                  <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal"><b>CERRAR</b></button>
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
                    title: 'IMPINFORMATICO | Personas',
                    orientation: 'landscape',
                    customize: function(doc) {
                        var now = obtenerFechaHora();
                        var titulo = "Personas ";
                        var descripcion =
                            "Informacion Personal de los Empleados";

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
                        // Ocultar la columna número 12
                        table.column(12).visible(false);
                        // Imprimir
                        $.fn.dataTable.ext.buttons.print.action(e, dt, node, config);
                        // Restablecer la visibilidad de la columna después de imprimir
                        table.column(12).visible(true);
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    title: 'Personas IMPINFORMATICO',
                    messageTop: 'Personas con sus respectivos datos personales.',
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

    <script>
    $(document).ready(function() {
      $('.js-example-basic-single').select2({});
  });

<script>
  function cleanInputValue(inputElement) {
    var inputValue = inputElement.value;
    var cleanValue = inputValue.replace(/[^a-z A-Záéíóú]/g, "");
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


<script>
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
    setTimeout(function(){
        $('.alert').alert('close'); // Cierra automáticamente todas las alertas después de 5 segundos
    }, 5000); // 5000 ms = 5 segundos
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stop