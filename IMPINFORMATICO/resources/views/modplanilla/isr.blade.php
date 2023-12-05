@extends('adminlte::page')

@section('title', 'Isr')

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
            return isset($objeto['NOM_OBJETO']) && $objeto['NOM_OBJETO'] === 'VACACIONES';
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
        <h1><b>Tabla Progresiva ISR 2023</b></h1>
        <button class="btn btn-success active text-light btn-lg" data-bs-toggle="modal" data-bs-target="#addisr"
            type="button"><b>Agregar</b></button>
    </div>

@stop


@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
@endsection


@section('content')

    <!-- Modal para agregar un nueva Vacaciones -->
    <div class="modal fade bd-example-modal-sm" id="addisr" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3><b>Nueva Rango ISR</b></h3>
                    <button class="btn btn-close " data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('Post-isr.store') }}" method="post" class="was-validated">
                        @csrf

                        <div class="mb-3 mt-3">
                            <label for="dni" class="form-label">Desde</label>
                            <input type="number" class="form-control" step="any" name="DESDE"
                                placeholder="Inserte el rango inferior." required>
                            <span class="validity"></span>
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="dni" class="form-label">Hasta</label>
                            <input type="number" class="form-control" step="any" name="HASTA"
                                placeholder="Inserte el rango superior.." required>
                            <span class="validity"></span>
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="dni" class="form-label">Tasa</label>
                            <input type="number" class="form-control" step="any" name="PORCENTAJE"
                                placeholder="Ingrese el porcentaje en entero o decimal." required>
                            <span class="validity"></span>
                        </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger " data-bs-dismiss="modal"><b>CERRAR</b></button>
                    <button class="btn btn-primary" data-bs="modal"><b>ACEPTAR</b></button>
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
        <table id="isr" class="table table-striped table-bordered table-condensed table-hover">
            <thead class="bg-cyan active">
                <tr>
                    <th style="text-align: center;">#</th>
                    <TH style="text-align: center;">Desde</TH>
                    <th style="text-align: center;">Hasta</th>
                    <th style="text-align: center;">Tasa</th>
                    <th style="text-align: center;">Acción</th>
                </tr>
            </thead>
            <tbody>


            @php
            // Verificar si el usuario tiene permiso de lectura para este objeto
            $permisoLectura = tienePermiso($permisosFiltrados, 'PER_CONSULTAR');
            @endphp

            @if ($permisoLectura)
                @foreach ($ResulIsr as $Isr)
                    <tr>
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td style="text-align: center;">L.{{ number_format($Isr['DESDE'], 2, ',', '.') }}</td>
                        <td style="text-align: center;">L.{{ number_format($Isr['HASTA'], 2, ',', '.') }}</td>
                        <td style="text-align: center;"> {{ number_format($Isr['PORCENTAJE'] * 100, 2, '.', ',') }}%</td>
                        <td style="text-align: center;">
                            <button value="Editar" title="Editar" class="btn btn-warning" type="button"
                                data-toggle="modal" data-target="#Uptisr-{{ $Isr['COD_ISR'] }}">
                                <i class='fas fa-edit' style='font-size:20px;'></i>
                            </button>
                        </td>
                    </tr>
                    <!-- Modal for editing goes here -->
                    <div class="modal fade bd-example-modal-sm" id="Uptisr-{{ $Isr['COD_ISR'] }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"><b>Editar Rango</b></h4>
                                    <button type="button" class="btn-close" data-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <form action="{{ route('Upd-isr.update') }}" method="post"
                                        class="was-validated">
                                        @csrf

                                        <input type="hidden" class="form-control" name="COD_ISR"
                                            value="{{ $Isr['COD_ISR'] }}">

                                        <div class="mb-3 mt-3">
                                            <label for="dni" class="form-label">Desde</label>
                                            <input type="number" class="form-control alphanumeric-input" name="DESDE"
                                                value="{{ $Isr['DESDE'] }}" required step="any"
                                                placeholder="Escriba aquí.">
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="dni" class="form-label">Hasta</label>
                                            <input type="number" class="form-control alphanumeric-input" name="HASTA"
                                                value="{{ $Isr['HASTA'] }}" required step="any"
                                                placeholder="Escriba aquí.">
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="dni" class="form-label">Tasa</label>
                                            <input type="number" class="form-control alphanumeric-input"
                                                name="PORCENTAJE" value="{{ number_format($Isr['PORCENTAJE'] * 100, 2, '.', ',') }}" required
                                                step="any" placeholder="Escriba aquí.">
                                        </div>


                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal"><b>CERRAR</b></button>
                                            <button type="submit" class="btn btn-primary"><b>ACEPTAR</b></button>
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
    </div>
    <!-- Espacio entre las tablas -->
    <div style="margin-bottom: 20px;"></div>

    <div class="d-grid gap-2 d-md-flex justify-content-between align-items-center">
        <h3><b>Rango de Gastos Medicos</b></h3>
        <button class="btn btn-success active text-light btn-lg" data-bs-toggle="modal" data-bs-target="#addedad"
            type="button"><b>Agregar</b></button>
    </div>

    <!-- Modal para agregar un nuevo gasto medico -->
    <div class="modal fade bd-example-modal-sm" id="addedad" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3><b>Nueva Rango Gastos Medicos</b></h3>
                    <button class="btn btn-close " data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('Post-isr.store') }}" method="post" class="was-validated">
                        @csrf

                        <div class="mb-3 mt-3">
                            <label for="dni" class="form-label">Desde</label>
                            <input type="number" class="form-control" name="DESDE"
                                placeholder="Inserte el rango inferior." required>
                            <span class="validity"></span>
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="dni" class="form-label">Hasta</label>
                            <input type="number" class="form-control" name="HASTA"
                                placeholder="Inserte el rango superior." required>
                            <span class="validity"></span>
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="dni" class="form-label">Gastos Medicos</label>
                            <input type="number" class="form-control" step="any" name="GASTOS_MEDICOS"
                                placeholder="Ingrese el monto" required>
                            <span class="validity"></span>
                        </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger " data-bs-dismiss="modal"><b>CERRAR</b></button>
                    <button class="btn btn-primary" data-bs="modal"><b>ACEPTAR</b></button>
                </div>
                </form>

            </div>
        </div>
    </div>
    </div>

    <div class="table-responsive p-0">
        <br>
        <table id="edad" class="table table-striped table-bordered table-condensed table-hover">
            <thead class="bg-cyan active">
                <tr>
                    <th style="text-align: center;">#</th>
                    <TH style="text-align: center;">Desde</TH>
                    <th style="text-align: center;">Hasta</th>
                    <th style="text-align: center;">Gastos Medicos</th>
                    <th style="text-align: center;">Accion</th>
                </tr>
            </thead>
            <tbody>



                @foreach ($ResulEdad as $Edad)
                    <tr>
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td style="text-align: center;">{{ $Edad['DESDE'] }} Años</td>
                        <td style="text-align: center;">{{ $Edad['HASTA'] }} Años</td>
                        <td style="text-align: center;"> L.{{ number_format($Edad['GASTOS_MEDICOS'], 2, '.', ',') }}</td>
                        <td style="text-align: center;">
                        @php
                      $permisoEditar = tienePermiso($permisosFiltrados, 'PER_ACTUALIZAR');
                    @endphp
                            <button value="Editar" title="Editar" class="btn @if (!$permisoEditar) btn-secondary disabled @else btn-warning @endif" type="button"
                                data-toggle="modal" data-target="#Uptedad-{{ $Edad['COD_EDAD'] }}">
                                <i class='fas fa-edit' style='font-size:20px;'></i>
                            </button>
                        </td>
                    </tr>
                    <!-- Modal for editing goes here -->
                    <div class="modal fade bd-example-modal-sm" id="Uptedad-{{ $Edad['COD_EDAD'] }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"><b>Editar Gastos Medicos</b></h4>
                                    <button type="button" class="btn-close" data-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <form action="{{ route('Upd-isr.update') }}" method="post"
                                        class="was-validated">
                                        @csrf

                                        <input type="hidden" class="form-control" name="COD_EDAD"
                                            value="{{ $Edad['COD_EDAD'] }}">

                                            <div class="mb-3 mt-3">
                                                <label for="dni" class="form-label">Desde</label>
                                                <!-- Añade el atributo required para hacer este campo obligatorio -->
                                                <input type="number" class="form-control alphanumeric-input" name="DESDE"
                                                    value="{{ $Edad['DESDE'] }}" required step="any" placeholder="Escriba aquí.">
                                            </div>
                                            
                                            <div class="mb-3 mt-3">
                                                <label for="dni" class="form-label">Hasta</label>
                                                <!-- Añade el atributo required para hacer este campo obligatorio -->
                                                <input type="number" class="form-control alphanumeric-input" name="HASTA"
                                                    value="{{ $Edad['HASTA'] }}" required step="any" placeholder="Escriba aquí.">
                                            </div>
                                            
                                            <div class="mb-3 mt-3">
                                                <label for="dni" class="form-label">Gastos Medicos</label>
                                                <!-- Añade el atributo required para hacer este campo obligatorio -->
                                                <input type="number" class="form-control alphanumeric-input" name="GASTOS_MEDICOS"
                                                    value="{{ $Edad['GASTOS_MEDICOS'] }}" required step="any" placeholder="Escriba aquí.">
                                            </div>
                                            

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal"><b>CERRAR</b></button>
                                            <button type="submit" class="btn btn-primary"><b>ACEPTAR</b></button>
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
    <strong>Copyright &copy; 2023 <a href="https://www.unah.edu.hn" target="_blank">UNAH</a>.</strong> <b>All rights
        reserved.</b>

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
            // Configuración para la primera tabla (isr1)
            var table1 = $('#isr').DataTable({
                responsive: true,
                autWidth: true,
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
                    // ... (otras configuraciones específicas para isr1)
                }
            });

            // Configuración para la segunda tabla (isr2)
            var table2 = $('#edad').DataTable({
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
                    // ... (otras configuraciones específicas para isr2)
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({});
        });
    </script>

    <script>
        setTimeout(function() {
            $('.alert').alert('close'); // Cierra automáticamente todas las alertas después de 5 segundos
        }, 5000); // 5000 ms = 5 segundos
    </script>

@stop
