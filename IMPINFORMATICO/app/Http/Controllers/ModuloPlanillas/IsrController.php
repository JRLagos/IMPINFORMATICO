<?php

namespace App\Http\Controllers\ModuloPlanillas;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IsrController extends Controller
{
    // ... Other methods ...

    public function index(Request $request)
    {
        $sessionToken = $request->session()->get('generated_token');

    $responses = [
        Http::get('http://localhost:3000/GET_ISR/GET', ['headers' => ['Authorization' => 'Bearer ' . $sessionToken]]),
        Http::get('http://localhost:3000/GET_GASTOS_MEDICOS/GET', ['headers' => ['Authorization' => 'Bearer ' . $sessionToken]]),
    ];

    $data1 = $responses[0]->getBody()->getContents();
    $data2 = $responses[1]->getBody()->getContents();

    $Isr = json_decode($data1, true);
    $Edad = json_decode($data2, true);

    return view('modplanilla.isr')->with('ResulIsr', $Isr)->with('ResulEdad', $Edad);
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
        $Isr = $request->all();
        $Edad = $request->all();

        // Realiza la primera solicitud HTTP POST
        $resEdad = Http::post("http://localhost:3000/INS_GASTOS_MEDICOS/INSERTAR", $Edad);

        // Realiza la segunda solicitud HTTP POST
        $resIsr = Http::post("http://localhost:3000/INS_ISR/INSERTAR", $Isr);

        // Verifica si ambas solicitudes fueron exitosas
        if ($resEdad->successful() && $resIsr->successful()) {
            // Redirige a la vista de índice con un mensaje de éxito
            return redirect(route('isr.index'))->with('success', 'Datos ingresados con éxito.');
        } else {
            // Si alguna de las solicitudes no fue exitosa, maneja el error
            return redirect(route('isr.index'))->with('error', 'Error al procesar la solicitud.');
        }
    } catch (\Exception $e) {
        // Maneja cualquier excepción inesperada
        return redirect(route('isr.index'))->with('error', 'Error inesperado: ' . $e->getMessage());
    }
}


public function update(Request $request)
    {
        $upd_isr = Http::put('http://localhost:3000/UPT_ISR/ACTUALIZAR/'.$request->input("COD_ISR"),[
            "COD_ISR" => $request->input('COD_ISR'),
            "DESDE" => $request->input("DESDE"),
            "HASTA" => $request->input("HASTA"),
            "PORCENTAJE" => $request->input("PORCENTAJE"),
        ]
        );

        $upd_edad = Http::put('http://localhost:3000/UPD_GASTOS_MEDICOS/ACTUALIZAR/'.$request->input("COD_EDAD"),[
            "COD_EDAD" => $request->input('COD_EDAD'),
            "DESDE" => $request->input("DESDE"),
            "HASTA" => $request->input("HASTA"),
            "GASTOS_MEDICOS" => $request->input("GASTOS_MEDICOS"),
        ]
        );
        
        return redirect(route('isr.index'))->with('success', 'La actualización se ha realizado con éxito.');
    }
    // ... Other methods ...
}
