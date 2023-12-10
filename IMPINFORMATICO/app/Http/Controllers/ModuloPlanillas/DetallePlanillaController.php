<?php

namespace App\Http\Controllers\ModuloPlanillas;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\Response;

class DetallePlanillaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtenter el token generado y guardado en la sesión
        $sessionToken = $request->session()->get('generated_token');
        $response1 = Http::get('http://localhost:3000/SHOW_DETALLE_PLANILLA/SELECT_DETALLE_PLANILLA',[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        $data1 = $response1->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        // Convierte los datos JSON a un array asociativo
        $DetallePlanilla = json_decode($data1, true);
    
        return view('modplanilla.detallePlanilla')->with('ResulDetallePlanilla', $DetallePlanilla);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        // Obtenter el token generado y guardado en la sesión
        $sessionToken = $request->session()->get('generated_token');
        $DetallePlanilla = $request->all();

        $res = Http::post("http://localhost:3000/INS_DETALLE_PLANILLA/INS_DETALLE_PLANILLA", $DetallePlanilla,[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);

        

        return redirect(route('DetallePlanilla.index'))->with('success', 'Datos ingresados con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $ID_PLANILLA)
{
    // Obtener el token generado y guardado en la sesión
    $sessionToken = $request->session()->get('generated_token');

    // Realizar la solicitud HTTP
    $response = Http::get('http://localhost:3000/SHOW_DETALLE_PLANILLA/SELECT_PLANILLAS_POR_DETALLE/' . $ID_PLANILLA, [
        'headers' => [
            'Authorization' => 'Bearer ' . $sessionToken,
        ],
    ]);

    $data1 = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
    // Convierte los datos JSON a un array asociativo
    $DetallePlanillaUno = json_decode($data1, true);


    return view('modplanilla.planillaCatorceavo')->with('ResulDetallePlanillaUno', $DetallePlanillaUno);
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
