@extends('adminlte::page')

  @section('title', 'Estadisticas')

  @section('content_header')

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />


  <h1>Estadisticas</h1>
  <div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <button class="btn btn-primary me-md-2" data-bs-toggle="modal" data-bs-target="#addHoraExtra" type="button"> Agregar Estadistica</button>
</div>
  @stop


    @section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
    @endsection


  @section('content')
  @can('crear-horaextra')
  
  @endcan



  <!--Tabla Producto -->

 <!-- /.card-header -->
 <div class="table-responsive p-0">
 <br>
  <table id="estadistica" class="table table-striped table-bordered table-condensed table-hover">
    <thead class="bg-dark">
    <tr> 
        <th>#</th>
        <TH>Usuario</TH>
        <TH>Tipo </TH>
        <TH>Titulo</TH>
        <TH>Formato</TH>
        <TH>E-Mail</TH>
        <TH>Fecha</TH>
        <TH>Estado</TH>
        <th>Accion</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($ResulEstadistica as $Estadistica)
        <tr>
        <td>{{ $loop->iteration }}</td>
          <td>{{ $Estadistica['NOM_USUARIO'] }}</td>
          <td>{{ $Estadistica['NOM_TIP_ESTADISTICA'] }}</td>
          <td>{{ $Estadistica['TIT_ESTADISTICA'] }}</td>
          <td>{{ $Estadistica['FOR_ESTADISTICA'] }}</td>
          <td>{{ $Estadistica['EMAIL'] }}</td>
          <td>{{ $Estadistica['HOR_FEC_ESTADISTICA'] }}</td>
          <td>{{ $Estadistica['IND_ESTADISTICA'] }}</td>
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
    $('#estadistica').DataTable({
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
    @stop