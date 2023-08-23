@extends('adminlte::page')

@section('title', 'Bold Report')

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

    <h1>Mis Reportes</h1>
@stop

@section('css')
    <link href="https://cdn.boldreports.com/5.2.26/content/material/bold.reports.all.min.css" rel="stylesheet" />
@endsection


@section('content')
    <div style="height: 600px; width: 950px;">
        <iframe
            src='http://localhost:51430/reporting/site/site1/reports/b59a7d46-4c34-416e-b226-1fd7787d1177/PRUEBA/IMPERIO%20INFORMATICO'
            id='reportvisor' width='100%' height='620px' allowfullscreen frameborder='0'></iframe>
    </div>
@endsection

@section('footer')
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.1.0
    </div>
    <strong>Copyright &copy; 2023 <a href="">IMPERIO IMFORMATICO</a>.</strong> All rights reserved.
@stop

@section('js')
    <script src="https://cdn.boldreports.com/external/jquery-1.10.2.min.js" type="text/javascript"></script>

    <!--Render the gauge item. Add this script only if your report contains the gauge report item. -->
    <script src="https://cdn.boldreports.com/5.2.26/scripts/common/ej2-base.min.js"></script>
    <script src="https://cdn.boldreports.com/5.2.26/scripts/common/ej2-data.min.js"></script>
    <script src="https://cdn.boldreports.com/5.2.26/scripts/common/ej2-pdf-export.min.js"></script>
    <script src="https://cdn.boldreports.com/5.2.26/scripts/common/ej2-svg-base.min.js"></script>
    <script src="https://cdn.boldreports.com/5.2.26/scripts/data-visualization/ej2-lineargauge.min.js"></script>
    <script src="https://cdn.boldreports.com/5.2.26/scripts/data-visualization/ej2-circulargauge.min.js"></script>

    <!--Render the map item. Add this script only if your report contains the map report item.-->
    <script src="https://cdn.boldreports.com/5.2.26/scripts/data-visualization/ej2-maps.min.js"></script>

    <!-- Report Viewer component script-->
    <script src="https://cdn.boldreports.com/5.2.26/scripts/common/bold.reports.common.min.js"></script>
    <script src="https://cdn.boldreports.com/5.2.26/scripts/common/bold.reports.widgets.min.js"></script>

    <!--Render the chart item. Add this script only if your report contains the chart report item.-->
    <script src="https://cdn.boldreports.com/5.2.26/scripts/data-visualization/ej.chart.min.js"></script>
    <script src="https://cdn.boldreports.com/5.2.26/scripts/bold.report-viewer.min.js"></script>

    <script type="text/javascript">
        $('#reportvisor').boldReportViewer({
            serviceAuthorizationToken: "bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJlbWFpbCI6Im1hcmlvdmFyZWxhMDE4QGdtYWlsLmNvbSIsIm5hbWVpZCI6IjEiLCJ1bmlxdWVfbmFtZSI6IjBhZDhhZGI3LWEzNzQtNDA0OS1hNTAxLWIwZWQ3MGIwNzdiOSIsIklQIjoiOjoxIiwiaXNzdWVkX2RhdGUiOiIxNjkyMzU4NjQwIiwibmJmIjoxNjkyMzU4NjQwLCJleHAiOjE2OTYyNDY2NDAsImlhdCI6MTY5MjM1ODY0MCwiaXNzIjoiaHR0cDovL2xvY2FsaG9zdDo1MTQzMC9yZXBvcnRpbmcvc2l0ZS9zaXRlMSIsImF1ZCI6Imh0dHA6Ly9sb2NhbGhvc3Q6NTE0MzAvcmVwb3J0aW5nL3NpdGUvc2l0ZTEifQ.j6TJxH70FyioCJrfV3ftvJA80cT_mVnephQ9tSluxbM",
            reportServiceUrl: "https://demos.boldreports.com/services/api/ReportViewer",
            reportPath: 'http://localhost:51430/reporting/site/site1/reports/b59a7d46-4c34-416e-b226-1fd7787d1177/PRUEBA/IMPERIO%20INFORMATICO',
        });
    </script>
@stop
