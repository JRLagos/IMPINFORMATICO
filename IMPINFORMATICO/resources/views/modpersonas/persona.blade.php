@extends('adminlte::page')

  @section('title', 'Personas')

  @section('content_header')

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />



  <h1>Registro de Personas</h1>
  <div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <button class="btn btn-dark me-md-2" data-bs-toggle="modal" data-bs-target="#addPersona" type="button"> Agregar Persona</button>
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
                    <input type="text" class="form-control alphanumeric-input" name="NOM_PERSONA" required>                   
                    </div>
                     
                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Apellido</label>
                    <input type="text" class="form-control alphanumeric-input"  name="APE_PERSONA" required>                   
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">DNI</label>
                    <input type="number" class="form-control" pattern="[0-9]{4}-[0-9]{4}-[0-9]{5}" id="dni" name="DNI_PERSONA" required>
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">RTN</label>
                    <input type="number" class="form-control" name="RTN_PERSONA" required>
                    </div>
 
                   <div class="mb-3 mt-3">
                   <label for="TIP_TELEFONO" class="form-label">Tipo de Télefono</label>
                   <select class="form-control" name="TIP_TELEFONO" required>
                   <option value="" selected disabled>Seleccione una opción</option>
                   <option value="FIJO">Fijo</option>
                   <option value="CELULAR">Celular</option>
                   </select>
                   <div class="valid-feedback"></div>
                   </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Número Teléfono</label>
                    <input type="tel" class="form-control"  name="NUM_TELEFONO" required>
                    </div>
                    
                   <div class="mb-3 mt-3">
                   <label for="SEX_PERSONA" class="form-label">Sexo Persona</label>
                   <select class="form-control" name="SEX_PERSONA" required>
                   <option value="" selected disabled>Seleccione una opción</option>
                   <option value="MASCULINO">Masculino</option>
                   <option value="FEMENINO">Femenino</option>
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
                    <input type="text" class="form-control alphanumeric-input" name="LUG_NAC_PERSONA" required>                   
                    </div>
                     
                  <div class="mb-3 mt-3">
                   <label for="IND_CIVIL" class="form-label">Estado Civil</label>
                   <select class="form-control" name="IND_CIVIL" required>
                   <option value="" selected disabled>Seleccione una opción</option>
                   <option value="SOLTERO">Soltero</option>
                   <option value="CASADO">Casado</option>
                   <option value="UNION LIBRE">Unión Libre</option>
                   <option value="VIUDO">Viudo</option>
                   </select>
                   <div class="valid-feedback"></div>
                   </div>


                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Correo Electronico</label>
                    <input type="text" class="form-control" name="CORREO_ELECTRONICO" required>                   
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Descripción Correo</label>
                    <input type="text" class="form-control alphanumeric-input" name="DES_CORREO" required>                   
                    </div>
                     
                   <div class="mb-3 mt-3">
                   <label for="NIV_ESTUDIO" class="form-label">Nivel de Estudio</label>
                   <select class="form-control" name="NIV_ESTUDIO" required>
                   <option value="" selected disabled>Seleccione una opción</option>
                   <option value="primaria">Primaria</option>
                   <option value="secundaria">Secundaria</option>
                   <option value="universitario">Universitario</option>
                   </select>
                   <div class="valid-feedback"></div>
                   </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Nombre Centro de Estudio</label>
                    <input type="text" class="form-control alphanumeric-input" name="NOM_CENTRO_ESTUDIO" required>                   
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
                    <input type="text" class="form-control alphanumeric-input" name="DES_DIRECCION" required>                   
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
                    <option> Seleccionar Departamento Empresa </option>
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
                    <input type="number" class="form-control" name="NUM_SEG_SOCIAL" required>                   
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Salario Base Empleado</label>
                    <input type="number" class="form-control" name="SAL_BAS_EMPLEADO" required>                   
                    </div>
                    
                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Nombre del Banco</label>
                    <input type="text" class="form-control" name="NOM_BANCO" required>                   
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Descripción Banco</label>
                    <input type="text" class="form-control alphanumeric-input" name="DES_BANCO" required>                   
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Número de Cuenta Banco</label>
                    <input type="number" class="form-control" name="NUM_CTA_BANCO" required>                   
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
       <th style="text-align: center;">TIPO TELÉFONO</th> 
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
          <td style="text-align: center;">{{ $Persona['TIP_TELEFONO'] }}</td> 
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
   <!-- botones -->
   <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
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
          dom: '<"top"Bl>frt<"bottom"ip><"clear">',
          buttons: [{
              extend: 'collection',
              className: 'custom-html-collection',
              text: 'Opciones', // Cambia el texto de la colección de botones
              buttons: [{
                      extend: 'pdf',
                      orientation: 'landscape',
                      title: 'IMPINFORMATICO | Personas',
                      customize: function(doc) {
                          var now = obtenerFechaHora();
                          var titulo = "Reporte de Personas";
                          var descripcion =
                              "Personas que hay en la empresa actualmente.";

                          // Encabezado
                          doc['header'] = function(currentPage, pageCount) {
                              return {
                                  text: titulo,
                                  fontSize: 18,
                                  alignment: 'center',
                                  margin: [0, 10]
                              };
                          };

                          // Pie de Página
                          doc['footer'] = function(currentPage, pageCount) {
                              return {
                                  columns: [{
                                          text: 'imperioinformatico',
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

                          // Contenido
                          doc.content.unshift({
                              text: descripcion,
                              alignment: 'left',
                              margin: [10, 0, 10, 10]
                          });
                      }
                  },
                  'csv',
                  'excel',
                  'columnsToggle'
              ],
          }],
          responsive: true,
          autoWidth: false,
          language: {
              lengthMenu: "Mostrar _MENU_ Registros Por Página",
              zeroRecords: "Nada encontrado - disculpas",
              info: "Página _PAGE_ de _PAGES_",
              infoEmpty: "No hay registros disponibles",
              infoFiltered: "(Filtrado de _MAX_ registros totales)",
              search: 'Buscar:',
              paginate: {
                  next: 'Siguiente',
                  previous: 'Anterior'
              }
          }
      });

      table.buttons().container()
          .appendTo('#departamento_wrapper .col-md-6:eq(0)');
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