@extends('adminlte::page')

  @section('title', 'Personas')

  @section('content_header')

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />



  <h1>Personas</h1>
  <div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <button class="btn btn-dark me-md-2" data-bs-toggle="modal" data-bs-target="#addPersona" type="button"> Agregar Persona</button>
</div>
  @stop


    @section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
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
                        <h4>Ingresar nueva persona</h4>

                    <form action="{{route('Post-Persona.store')}}" method="post" class="was-validated">
                    @csrf
                    
                 

                        <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="NOM_PERSONA" required>                   
                    </div>
                     
                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Apellido</label>
                    <input type="text" class="form-control" name="APE_PERSONA" required>                   
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">DNI</label>
                    <input type="number" class="form-control" name="DNI_PERSONA" required>
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">RTN</label>
                    <input type="number" class="form-control" name="RTN_PERSONA" required>
                    </div>
 
                   <div class="mb-3 mt-3">
                   <label for="TIP_TELEFONO" class="form-label">Tipo de Télefono</label>
                   <select class="form-control" name="TIP_TELEFONO" required>
                   <option value="" selected disabled>Seleccione una opción</option>
                   <option value="FIJO">FIJO</option>
                   <option value="CELULAR">CELULAR</option>
                   </select>
                   <div class="valid-feedback"></div>
                   </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Número Teléfono</label>
                    <input type="number" class="form-control" name="NUM_TELEFONO" required>
                    </div>
                    
                    <div class="mb-3 mt-3">
                   <label for="SEX_PERSONA" class="form-label">Sexo Persona</label>
                   <select class="form-control" name="SEX_PERSONA" required>
                   <option value="" selected disabled>Seleccione una opción</option>
                   <option value="MASCULINO">MASCULINO</option>
                   <option value="FEMENINO">FEMENINO</option>
                   </select>
                   <div class="valid-feedback"></div>
                   </div>
                    
                    
                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Edad Persona</label>
                    <input type="number" class="form-control" name="EDAD_PERSONA" required>
                    </div>
                    
                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Fecha Nacimiento Persona</label>
                    <input type="date" class="form-control" max="<?= date('Y-m-d'); ?>" name="FEC_NAC_PERSONA" required>
                    </div>
                    
                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Lugar Nacimiento Persona</label>
                    <input type="text" class="form-control" name="LUG_NAC_PERSONA" required>                   
                    </div>
                     
                  <div class="mb-3 mt-3">
                   <label for="IND_CIVIL" class="form-label">ESTADO CIVIL</label>
                   <select class="form-control" name="IND_CIVIL" required>
                   <option value="" selected disabled>Seleccione una opción</option>
                   <option value="SOLTERO">SOLTERO</option>
                   <option value="CASADO">CASADO</option>
                   <option value="UNION LIBRE">UNION LIBRE</option>
                   <option value="VIUDO">VIUDO</option>
                   </select>
                   <div class="valid-feedback"></div>
                   </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Peso Persona</label>
                    <input type="num" class="form-control" name="PES_PERSONA" required>                   
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Estatura Persona</label>
                    <input type="num" class="form-control" name="EST_PERSONA" required>                   
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Foto Persona</label>
                    <input type="text" class="form-control" name="FOTO_PERSONA" required>                   
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Correo Electronico</label>
                    <input type="text" class="form-control" name="CORREO_ELECTRONICO" required>                   
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Descripción Correo</label>
                    <input type="text" class="form-control" name="DES_CORREO" required>                   
                    </div>
                     
                   <div class="mb-3 mt-3">
                   <label for="NIV_ESTUDIO" class="form-label">Nivel de Estudio</label>
                   <select class="form-control" name="NIV_ESTUDIO" required>
                   <option value="" selected disabled>Seleccione una opción</option>
                   <option value="primaria">PRIMARIA</option>
                   <option value="secundaria">SECUNDARIA</option>
                   <option value="universitario">UNIVERSITARIO</option>
                   </select>
                   <div class="valid-feedback"></div>
                   </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Nombre Centro de Estudio</label>
                    <input type="text" class="form-control" name="NOM_CENTRO_ESTUDIO" required>                   
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Municipio</label>
                    <select class="form-control js-example-basic-single"  name="COD_MUNICIPIO" id="COD_MUNICIPIO">
                    <option> Seleccionar Municipio </option>
                    @foreach ($ResulMunicipio as $Municipio)
                    <option value="{{ $Municipio['COD_MUNICIPIO'] }}">{{ $Municipio['NOM_MUNICIPIO'] }}</option>
                    @endforeach
                    </select>
                    </div>
                    
                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Direccion</label>
                    <input type="text" class="form-control" name="DES_DIRECCION" required>                   
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
                    <option> Seleccionar Dpertamento Empresa </option>
                    @foreach ($ResulDeptoEmpresa as $DeptoEmpresa)
                    <option value="{{ $DeptoEmpresa['COD_DEPTO_EMPRESA'] }}">{{ $DeptoEmpresa['NOM_DEPTO_EMPRESA'] }}</option>
                    @endforeach
                    </select>
                    </div>
                    
                    <div class="mb-3 mt-3">
                   <label for="TIP_CONTRATO" class="form-label">Tipo de Contrato</label>
                   <select class="form-control" name="TIP_CONTRATO" required>
                   <option value="" selected disabled>Seleccione una opción</option>
                   <option value="TEMPORAL">Temporal</option>
                   <option value="PERMANENTE">Permanente</option>
                   </select>
                   <div class="valid-feedback"></div>
                   </div>

                    
                   <div class="mb-3 mt-3">
                   <label for="PUE_TRA_EMPLEADO" class="form-label">Puesto Trabajo del Empleado</label>
                   <select class="form-control" name="PUE_TRA_EMPLEADO" required>
                   <option value="" selected disabled>Seleccione una opción</option>
                   <option value="GERENTE">Gerente</option>
                   <option value="ADMINISTRADOR">Administrador</option>
                   <option value="JEFE DE PLANTA">Jefe de Planta</option>
                   </select>
                   <div class="valid-feedback"></div>
                   </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Fecha Ingreso</label>
                    <input type="date" class="form-control" max="<?= date('Y-m-d'); ?>" name="FEC_INGRESO" required>
                    </div>
                    
                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Fecha Egreso</label>
                    <input type="date" class="form-control" max="<?= date('Y-m-d'); ?>" name="FEC_EGRESO" required>
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Número Seguro Social</label>
                    <input type="num" class="form-control" name="NUM_SEG_SOCIAL" required>                   
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Salario Base Empleado</label>
                    <input type="num" class="form-control" name="SAL_BAS_EMPLEADO" required>                   
                    </div>
                    
                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Nombre del Banco</label>
                    <input type="text" class="form-control" name="NOM_BANCO" required>                   
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Descripción Banco</label>
                    <input type="text" class="form-control" name="DES_BANCO" required>                   
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Número de Cuenta Banco</label>
                    <input type="num" class="form-control" name="NUM_CTA_BANCO" required>                   
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
  <table id="persona" class="table table-striped table-bordered table-condensed table-hover">
    <thead class="bg-dark">
    <tr> 
        <th style="text-align: center;">#</th>
        <th style="text-align: center;">NOMBRE COMPLETO</TH>
        <th style="text-align: center;">DNI</th>
        <th style="text-align: center;">RTN</th>
        <th style="text-align: center;">ESTADO CIVIL</th>
       <!-- <th>TIPO TELÉFONO</th> -->
        <th style="text-align: center;">NÚMERO TELÉFONO</th>
        <th style="text-align: center;">SEXO</th>
        <th style="text-align: center;">EDAD</th>
        <th style="text-align: center;">FECHA NACIMIENTO</th>
        <th style="text-align: center;">LUGAR NACIMIENTO</th>
        <th style="text-align: center;">CORREO ELECTRONICO</th>
        <th style="text-align: center;">ACCION</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($ResulPersona as $Persona)
        <tr>
        <td>{{ $loop->iteration }}</td>
          <td style="text-align: center;">{{ $Persona['NOMBRE_COMPLETO'] }}</td>
          <td style="text-align: center;">{{ $Persona['DNI_PERSONA'] }}</td>
          <td style="text-align: center;">{{ $Persona['RTN_PERSONA'] }}</td>
          <td style="text-align: center;">{{ $Persona['IND_CIVIL'] }}</td>
     <!-- <td>{{ $Persona['TIP_TELEFONO'] }}</td> -->
          <td style="text-align: center;">{{ $Persona['NUM_TELEFONO'] }}</td>
          <td style="text-align: center;">{{ $Persona['SEX_PERSONA'] }}</td>
          <td style="text-align: center;">{{ $Persona['EDAD_PERSONA'] }}</td>
          <td style="text-align: center;">{{ date('d-m-Y', strtotime($Persona['FEC_NAC_PERSONA'])) }}</td>
          <td style="text-align: center;">{{ $Persona['LUG_NAC_PERSONA'] }}</td>
          <td style="text-align: center;">{{ $Persona['CORREO_ELECTRONICO'] }}</td>
          <td>
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
  <script>
    $('#persona').DataTable({
      responsive: true,
      autWidth: false,

      "language": {
              "lengthMenu": "Mostrar  _MENU_  Registros Por Página",
              "zeroRecords": "Nada encontrado - disculpas",
              "info": "Pagina _PAGE_ de _PAGES_",
              "infoEmpty": "No records available",
              "infoFiltered": "(Filtrado de _MAX_ registros totales)",

              'search' : 'Buscar:',
              'paginate' : {
                'next': 'Siguiente',
                'previous' : 'Anterior'
              }

          }
    });

    </script>

    <script>
    $(document).ready(function() {
      $('.js-example-basic-single').select2({});
  });
</script>

    </script>
    @stop