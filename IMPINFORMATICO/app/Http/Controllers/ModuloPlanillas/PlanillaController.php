<?php

namespace App\Http\Controllers\ModuloPlanillas;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\Response;

class PlanillaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtenter el token generado y guardado en la sesión
        $sessionToken = $request->session()->get('generated_token');
        $response1 = Http::get('http://localhost:3000/SHOW_PLANILLA/PLANILLA_ORDINARIA',[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        $data1 = $response1->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response2 = Http::get('http://localhost:3000/SHOW_EMPLEADO/GETALL_EMPLEADO/2',[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        $data2 = $response2->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
      
        // Convierte los datos JSON a un array asociativo
        $Planilla = json_decode($data1, true);
        $Empleado = json_decode($data2, true);
    
        return view('modplanilla.planilla')->with('ResulPlanilla', $Planilla)->with('ResulEmpleado', $Empleado);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $sessionToken = $request->session()->get('generated_token');
    
    // Obtén la lista de empleados seleccionados desde el formulario
    $empleadosSeleccionados = $request->input('COD_EMPLEADO');

    try {
        // Itera sobre la lista de empleados y genera la planilla para cada uno
        foreach ($empleadosSeleccionados as $empleadoSeleccionado) {
            // Crea un array con los datos de la planilla para el empleado actual
            $planillaData = [
                'COD_EMPLEADO' => $empleadoSeleccionado,
                'TIPO_PLANILLA' => $request->input('TIPO_PLANILLA'),
                // Otros campos de la planilla...
            ];

            // Realiza la solicitud HTTP para almacenar la planilla
            $res = Http::post("http://localhost:3000/INS_PLANILLA/PLANILLA", $planillaData, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $sessionToken,
                ],
            ]);

            if (!$res->successful()) {
                $errorResponse = $res->json(); // Ajusta según la estructura de tu respuesta JSON
                
                // Log del error
                \Log::error('Error al generar planilla para el empleado ' . $empleadoSeleccionado . ': ' . $errorResponse['error'] ?? 'Error desconocido en la solicitud HTTP.');
                
                // Lanza una excepción específica para manejar errores HTTP
                throw new \RuntimeException('Error al generar planilla para el empleado ' . $empleadoSeleccionado . ': ' . $errorResponse['error'] ?? 'Error desconocido en la solicitud HTTP.');
            }
        }

        // Si llega aquí, todas las solicitudes fueron exitosas
        return redirect(route('Planilla.index'))->with('success', 'Planillas generadas con éxito');
    } catch (\RuntimeException $e) {
        // Manejo de errores específicos de la solicitud HTTP
        return redirect(route('Planilla.index'))->with('error', $e->getMessage());
    } catch (\Exception $e) {
        // Manejo de errores generales
        \Log::error('Error general al generar planillas: ' . $e->getMessage());
        return redirect(route('Planilla.index'))->with('error', 'Error general al generar planillas');
    }
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
