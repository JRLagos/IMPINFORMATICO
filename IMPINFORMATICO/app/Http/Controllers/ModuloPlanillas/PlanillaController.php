<?php

namespace App\Http\Controllers\ModuloPlanillas;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\Response;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class PlanillaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtenter el token generado y guardado en la sesión
        $sessionToken = $request->session()->get('generated_token');
        $response1 = Http::get('http://localhost:3000/SHOW_PLANILLA/SELECT_PLANILLA_ORDINARIA',[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        $data1 = $response1->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        // Convierte los datos JSON a un array asociativo
        $Planilla = json_decode($data1, true);
    
        return view('modplanilla.planilla')->with('ResulPlanilla', $Planilla);
    }

    public function indexAguinaldo(Request $request)
    {
        // Obtenter el token generado y guardado en la sesión
        $sessionToken = $request->session()->get('generated_token');
        $response1 = Http::get('http://localhost:3000/SHOW_PLANILLA/SELECT_PLANILLA_AGUINALDO',[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        $data1 = $response1->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        // Convierte los datos JSON a un array asociativo
        $PlanillaAguinaldo = json_decode($data1, true);
    
        return view('modplanilla.planillaAguinaldo')->with('ResulPlanillaAguinaldo', $PlanillaAguinaldo);
    }

    public function indexVacaciones(Request $request)
    {
        // Obtenter el token generado y guardado en la sesión
        $sessionToken = $request->session()->get('generated_token');
        $response1 = Http::get('http://localhost:3000/SHOW_PLANILLA/SELECT_PLANILLA_VACACIONES',[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        $data1 = $response1->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        // Convierte los datos JSON a un array asociativo
        $PlanillaVacaciones = json_decode($data1, true);
    
        return view('modplanilla.planillaVacaciones')->with('ResulPlanillaVacaciones', $PlanillaVacaciones);
    }

    public function indexCatorceavo(Request $request)
    {
        // Obtenter el token generado y guardado en la sesión
        $sessionToken = $request->session()->get('generated_token');
        $response1 = Http::get('http://localhost:3000/SHOW_PLANILLA/SELECT_PLANILLA_CATORCEAVO',[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        $data1 = $response1->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        // Convierte los datos JSON a un array asociativo
        $PlanillaCatorceavo = json_decode($data1, true);
    
        return view('modplanilla.planillaCatorceavo')->with('ResulPlanillaCatorceavo', $PlanillaCatorceavo);
    }

    /**
     * Store a newly created resource in storage.
     */

     public function store(Request $request)
{
    // Validar los datos del formulario si es necesario

    // Extract data from the request
    $nombrePlanilla = $request->input('NOMBRE_PLANILLA');
    $desPlanilla = $request->input('DES_PLANILLA');
    $tipoPlanilla = $request->input('TIPO_PLANILLA');
    $fecInicial = $request->input('FEC_INICIAL');
    $fecFinal = $request->input('FEC_FINAL');
    $periodo = $request->input('PERIODO');

    if ($tipoPlanilla == 'ORDINARIA' && ($periodo == 'QUINCENAL' || $periodo == 'MENSUAL')) {
        $diasDiferencia = (new \DateTime($fecFinal))->diff(new \DateTime($fecInicial))->days;
        
        if (($periodo == 'QUINCENAL' && $diasDiferencia > 15) || ($periodo == 'MENSUAL' && $diasDiferencia > 30)) {
            // La diferencia de días excede el límite permitido, almacenar un mensaje de error

            $errorMessage = ($periodo == 'QUINCENAL')
                ? 'La diferencia de días no puede ser mayor a 15 en el periodo quincenal. Vuelva a ingresar los datos válidos.'
                : 'La diferencia de días no puede ser mayor a 30 en el periodo mensual. Vuelva a ingresar los datos válidos.';
    
            // Retornar la vista con el mensaje de error y los datos antiguos
            return redirect()->route('generar.planilla')
                ->withErrors([$errorMessage])
                ->withInput();
        }
    } elseif ($tipoPlanilla == 'AGUINALDO') {
        // Si es planilla de AGUINALDO, las fechas deben ser el 1 de enero y el 31 de diciembre del presente año
        $year = date('Y');
    
        // Validar que las fechas coincidan con el rango esperado
        if ($fecInicial != "$year-01-01" || $fecFinal != "$year-12-31") {
            // Las fechas no son correctas para la planilla de AGUINALDO
            $errorMessage = 'Las fechas para la planilla de AGUINALDO deben ser el 1 de enero y el 31 de diciembre del presente año.';
            return redirect()->route('generar.planilla')
                ->withErrors([$errorMessage])
                ->withInput();
        }
    } elseif ($tipoPlanilla == 'CATORCEAVO') {
        // Obtener el año actual
        $currentYear = date('Y');
    
        // Calcular la fecha inicial: 1 de junio del año anterior
        $fechaInicial = ($currentYear - 1) . '-06-01';
    
        // Calcular la fecha final: 31 de mayo del año actual
        $fechaFinal = $currentYear . '-06-30';
    
        // Validar que las fechas coincidan con el rango esperado
        if ($fecInicial != $fechaInicial || $fecFinal != $fechaFinal) {
            // Las fechas no son correctas para la planilla de CATORCEAVO
            $errorMessage = 'Las fechas para la planilla de CATORCEAVO deben ser el 1 de junio del año anterior y el 3 de junio del presente año.';
            return redirect()->route('generar.planilla')
                ->withErrors([$errorMessage])
                ->withInput();
        }
    }

    // Obtener la cadena de códigos de empleados desde el campo oculto
    $codigosEmpleadosString = $request->input('codigosEmpleados', '');

    // Decodificar la cadena JSON a un array de códigos de empleados
    $codEmpleadoArray = json_decode($codigosEmpleadosString, true);

    // Loop para enviar cada COD_EMPLEADO a la API
    foreach ($codEmpleadoArray as $codEmpleadoItem) {
        $url = '';
        
        if ($tipoPlanilla == 'ORDINARIA' && ($periodo == 'QUINCENAL' || $periodo == 'MENSUAL')) {
            $url = 'http://localhost:3000/INS_PLANILLA/INS_PLANILLA_ORDINARIA';
        } elseif ($tipoPlanilla == 'VACACIONES') {
            $url = 'http://localhost:3000/INS_PLANILLA/INS_PLANILLA_VACACIONES';
        } elseif ($tipoPlanilla == 'AGUINALDO') {
            $url = 'http://localhost:3000/INS_PLANILLA/INS_PLANILLA_AGUINALDO';
        } elseif ($tipoPlanilla == 'CATORCEAVO') {
            $url = 'http://localhost:3000/INS_PLANILLA/INS_PLANILLA_CATORCEAVO';
        } else {
            // Manejar otro tipo de planilla o mostrar un mensaje de error
            // Puedes personalizar esta parte según tus necesidades
            echo "Tipo de planilla no válido";
            continue; // Saltar a la siguiente iteración del bucle
        }
        $response = Http::post($url, [
            "COD_EMPLEADO" => $codEmpleadoItem,
            "NOMBRE_PLANILLA" => $nombrePlanilla,
            "DES_PLANILLA" => $desPlanilla,
            "TIPO_PLANILLA" => $tipoPlanilla,
            "FEC_INICIAL" => $fecInicial,
            "FEC_FINAL" => $fecFinal,
        ]);

        // Puedes verificar la respuesta de la API si es necesario
        // $apiResponse = $response->json();
    }

    if ($tipoPlanilla == 'ORDINARIA') {
        return redirect()->route('Planilla.index');
    } elseif ($tipoPlanilla == 'VACACIONES') {
        return redirect()->route('PlanillaVacaciones.index');
    } elseif ($tipoPlanilla == 'AGUINALDO') {
        return redirect()->route('PlanillaAguinaldo.index');
    } elseif ($tipoPlanilla == 'CATORCEAVO') {
        return redirect()->route('PlanillaCatorceavo.index');
    }
    // Retornar una respuesta JSON o redirigir según sea necesario
    
}


    /**
     * Display the specified resource.
     */
    public function guardarSelecciones(Request $request)
{
    // 1. Validar la solicitud
    $request->validate([
        'selecciones' => 'required|array',
    ]);

    // 2. Procesar las selecciones
    $selecciones = $request->input('selecciones');

    // 3. Hacer cualquier lógica adicional, como guardar en la base de datos, etc.

    // 4. Pasar solo las selecciones a la vista

    
    info('Empleados seleccionados:', $selecciones);

    // Redirige a la vista de generar planilla con los empleados seleccionados
    return redirect()->route('generar.planilla')->with('empleadosSeleccionados', $selecciones);

}

    public function showGenerarPlanilla(Request $request)
    {
        $sessionToken = $request->session()->get('generated_token');
        $response2 = Http::get('http://localhost:3000/SHOW_EMPLEADO/GETALL_EMPLEADO/2',[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        $data2 = $response2->getBody()->getContents(); // Obtiene el cuerpo de la respuesta  

        $Empleado = json_decode($data2, true);

        return view('modplanilla.GenerarPlanilla')->with('ResulEmpleado', $Empleado);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}