<?php

namespace App\Http\Controllers\ModuloPlanillas;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Http\Response;

class VacacionesEmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtenter el token generado y guardado en la sesión
        $sessionToken = $request->session()->get('generated_token');
        $response = Http::get('http://localhost:3000/SHOW_VACACIONES_EMPLEADOS/GET',[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
    
        // Convierte los datos JSON a un array asociativo
        $VacacionesEm = json_decode($data, true);

        return view('modplanilla.vacacionesempleado')->with('ResulVacacionesEm', $VacacionesEm); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {   
      
        $UpdVaca = Http::put('http://localhost:3000/UPT_VACACIONES_EMPLEADOS/UPDATE/'.$request->input("COD_VACACIONES"),[
            "COD_VACACIONES" => $request->input('COD_VACACIONES'),
            "DIAS_USADOS" => $request->input("DIAS_USADOS"),
        ],);
        
        return redirect(route('VacacionesEmpleados.index'))->with('success', 'La actualización de las vacaciones se ha realizado con éxito.');
    }

}
