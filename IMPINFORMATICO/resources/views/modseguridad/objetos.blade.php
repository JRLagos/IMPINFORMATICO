@extends('adminlte::page')

  @section('title', 'Objetos')

  @section('content_header')

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
        return isset($objeto['NOM_OBJETO']) && $objeto['NOM_OBJETO'] === 'OBJETOS';
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
          <h1><b>Objetos</b></h1>
          @php
            $permisoInsertar = tienePermiso($permisosFiltrados, 'PER_INSERTAR');
          @endphp
          <button class="btn @if (!$permisoInsertar) btn-secondary disabled @else btn-warning @endif btn-dark btn-lg" data-bs-toggle="modal" data-bs-target="#addObjeto"
              type="button"><b>Agregar Objeto</b></button>
      </div>
  @stop


    @section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
    @endsection


  @section('content')

  <!-- Modal para agregar un nuevo producto -->
  <div class="modal fade bd-example-modal-sm" id="addObjeto" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">


                    <div class="modal-header">
                    <h3>Objetos</h3>
                    <button class="btn btn-close " data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <h4>Ingresar Objetos</h4>

                    <form action="{{route('Post-Objetos.store')}}" method="post" class="was-validated">
                    @csrf
                    
                        <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Nombre Objeto</label>
                    <input type="text" class="form-control alphanumeric-input" pattern="[A-Za-z].{3,}" name="NOM_OBJETO" required minlength="4" maxlength="30"/>
                    <span class="validity"></span>
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Descripcion Objeto</label>
                    <input type="text" class="form-control alphanumeric-input" pattern="[A-Za-z].{3,}" name="DES_OBJETO" required minlength="4" maxlength="100"/>
                    <span class="validity"></span>
                    </div>

                    <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">Tipo Objeto</label>
                    <input type="text" class="form-control alphanumeric-input" pattern="[A-Za-z].{3,}" name="TIP_OBJETO" required minlength="4" maxlength="30"/>
                    <span class="validity"></span>
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
  <table id="rol" class="table table-striped table-bordered table-condensed table-hover">
    <thead class="bg-dark">

    <tr>
            <th style="text-align: center;">#</th>
            <th style="text-align: center;">Nombre</th>
            <th style="text-align: center;">Descripcion</th>
            <th style="text-align: center;">Tipo</th>
            <th style="text-align: center;">Accion</th>
    </tr>
        </thead>
        <tbody>

        @php
            // Verificar si el usuario tiene permiso de lectura para este objeto
            $permisoLectura = tienePermiso($permisosFiltrados, 'PER_CONSULTAR');
            @endphp

            @if ($permisoLectura)


            @foreach($ResulObjetos as $Objetos)
                <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td style="text-align: center;">{{$Objetos['NOM_OBJETO']}}</td>
                    <td style="text-align: center;">{{$Objetos['DES_OBJETO']}}</td>
                    <td style="text-align: center;">{{$Objetos['TIP_OBJETO']}}</td>
                    <td style="text-align: center;">
                    @php
                      $permisoEditar = tienePermiso($permisosFiltrados, 'PER_ACTUALIZAR');
                    @endphp
                        <button value="Editar" title="Editar" class="btn @if (!$permisoEditar) btn-secondary disabled @else btn-warning @endif" type="button" data-toggle="modal" data-target="#Objeto-edit-{{$Objetos['COD_OBJETO']}}">
                            <i class='fas fa-edit' style='font-size:20px;'></i>
                        </button>
                    </td>
                </tr>

                <div class="modal fade bd-example-modal-sm" id="Objeto-edit-{{$Objetos['COD_OBJETO']}}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Editar Objeto</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h4>Ingresar Nuevos Datos</h4>
                                <form action="{{route('Upt-Objetos.update')}}" method="post" class="was-validated">
                                    @csrf
                                        <input type="hidden" class="form-control" name="COD_OBJETO"  value="{{$Objetos['COD_OBJETO']}}">

                                        <div class="mb-3 mt-3">
                                        <label for="dni" class="form-label">Noimbre del Objeto</label>
                                        <input type="text" class="form-control alphanumeric-input" id="NOM_OBJETO" name="NOM_OBJETO" pattern="[A-Z a-z].{3,}" value="{{$Objetos['NOM_OBJETO']}}" required maxlength="30">
                                        </div>

                                        <div class="mb-3 mt-3">
                                        <label for="dni" class="form-label">Descripcion del Objeto</label>
                                        <input type="text" class="form-control alphanumeric-input" id="DES_OBJETO" name="DES_OBJETO" pattern="[A-Z a-z].{3,}" value="{{$Objetos['DES_OBJETO']}}" required maxlength="30">
                                        </div>

                                        <div class="mb-3 mt-3">
                                        <label for="dni" class="form-label">Tipo de Objeto</label>
                                        <input type="text" class="form-control alphanumeric-input" id="TIP_OBJETO" name="TIP_OBJETO" pattern="[A-Z a-z].{3,}" value="{{$Objetos['TIP_OBJETO']}}" required maxlength="30">
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
            @endif
        </tbody>
    </table>

  @stop

  @section('footer')

  <div class="float-right d-none d-sm-block">
    <b>Version</b> 3.1.0
  </div>
  <strong>Copyright &copy; 2023 <a href="">IMPERIO INFORMATICO</a>.</strong> All rights reserved.

  @stop



  @section('js')

  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>
  <script>
    $('#rol').DataTable({
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
    @stop