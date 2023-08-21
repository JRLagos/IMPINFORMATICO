<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function generarReporte(Request $request)
    {
        // Configuración del informe Bold Reports
        $reportDesigner = new ReportDesigner();
        $reportDesigner->setReportPath('http://localhost:51430/reporting/site/site1/reports/b59a7d46-4c34-416e-b226-1fd7787d1177/PRUEBA/Prueba?showmyreports=1');
        
        // Otros ajustes de configuración si es necesario
        
        // Generar y mostrar el informe
        return $reportDesigner->exportReport();
    }
}
