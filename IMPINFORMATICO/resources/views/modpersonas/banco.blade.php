@extends('adminlte::page')

  @section('title', 'Banco')

  @section('content_header')

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />



<div class="d-grid gap-2 d-md-flex justify-content-between align-items-center">
    <h1><b>Registro de Bancos</b></h1>
</div>

  @stop


    @section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
    @endsection


  @section('content')

      
    @if(session('success'))
        <div class="alert alert-warning alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif  
   <!-- /.card-header -->
 <div class="table-responsive p-0">
 <br>
  <table id="Banco" class="table table-striped table-bordered table-condensed table-hover">
    <thead class="bg-dark">
    <tr> 
        <th style="text-align: center;">#</th>
        <th style="text-align: center;">Nombre Empleado</th>
        <th style="text-align: center;">Nombre Banco</th>
        <th style="text-align: center;">Descripción</th>
        <th style="text-align: center;">Número de Cuenta</th>
        <th>Accion</th>
      </tr>
    </thead>
    <tbody>

      @foreach ($ResulBanco as $Banco) 
      <tr>
        <td style="text-align: center;">{{ $loop->iteration }}</td>
        <td style="text-align: center;">{{ $Banco['NOMBRE_COMPLETO'] }}</td>
        <td style="text-align: center;">{{ $Banco['NOM_BANCO'] }}</td>
        <td style="text-align: center;">{{ $Banco['DES_BANCO'] }}</td>
        <td style="text-align: center;">{{ $Banco['NUM_CTA_BANCO'] }}</td>
        <td style="text-align: center;">
                <button value="Editar" title="Editar" class="btn btn-warning" type="button" data-toggle="modal" data-target="#UpdBanco-{{$Banco['COD_BANCO']}}">
                  <i class='fas fa-edit' style='font-size:20px;'></i>
                </button>
              </td>
            </tr>
                <!-- Modal for editing goes here -->
  <div class="modal fade bd-example-modal-sm" id="UpdBanco-{{$Banco['COD_BANCO']}}" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><b>Editar Banco</b></h4>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        
            <div class="modal-body">
              <h4><p>Ingresar nuevos datos</p></h4>
              <hr>
                <form action="{{route('Upd-Banco.update')}}" method="post" class="was-validated">
                @csrf

                    <input type="hidden" class="form-control" name="COD_BANCO"  value="{{$Banco['COD_BANCO']}}">

                  <div class="mb-3 mt-3">
                      <label for="dni" class="form-label">Nombre Empleado</label>
                      <select class="form-control js-example-basic-single"  name="COD_EMPLEADO" id="COD_EMPLEADO">
                        <option value="{{$Banco['COD_EMPLEADO']}}" style="display: none;">{{ $Banco['NOMBRE_COMPLETO'] }}</option>
                        <option disabled >¡No se puede seleccionar otro Empleado!</option>
                      </select>
                    </div>

                  <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Nombre Banco</label>
                    <input type="text" class="form-control alphanumeric-input" pattern=".{3,}" name="NOM_BANCO" value="{{$Banco['NOM_BANCO']}}" required maxlength="255">                   
                  </div>

                  <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Descripción</label>
                    <input type="text" class="form-control alphanumeric-input" pattern=".{3,}" name="DES_BANCO" value="{{$Banco['DES_BANCO']}}" required maxlength="255">                   
                  </div>

                  <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Numero de Cuenta</label>
                    <input type="number" class="form-control"  name="NUM_CTA_BANCO" value="{{$Banco['NUM_CTA_BANCO']}}" required oninput="validateCUENTA(this)">
                    <div class="invalid-feedback">
                      Por favor, ingresa un Número válido de 8 dígitos.
                    </div>  
                    <span class="validity"></span>
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
    $('#Banco').DataTable({
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
    <script>
    $(document).ready(function() {
      $('.js-example-basic-single').select2({});
  });
</script>
<script>
    setTimeout(function(){
        $('.alert').alert('close'); // Cierra automáticamente todas las alertas después de 5 segundos
    }, 5000); // 5000 ms = 5 segundos
</script>

    </script>
    @stop