<?php

namespace App\Http\Controllers\ModuloPlanillas;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\Response;

class VacacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtenter el token generado y guardado en la sesión
        $sessionToken = $request->session()->get('generated_token');
        $response1 = Http::get('http://localhost:3000/SHOW_VACACIONES/GETALL_VACACIONES',[
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
        $Vacaciones = json_decode($data1, true);
        $Empleado = json_decode($data2, true);
    
        return view('modplanilla.vacaciones')->with('ResulVacaciones', $Vacaciones)->with('ResulEmpleado', $Empleado);
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
        $Vacaciones = $request->all();

        $res = Http::post("http://localhost:3000/INS_VACACIONES/VACACIONES", $Vacaciones,[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);

        return redirect(route('Vacaciones.index'));
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
    public function update(Request $request)
    {
        $upt_Vacaciones = Http::put('http://localhost:3000/UPT_VACACIONES/VACACIONES/'.$request->input("COD_VACACIONES"),[
            "COD_VACACIONES" => $request->input('COD_VACACIONES'),
            "COD_EMPLEADO" => $request->input("COD_EMPLEADO"),
            "VACACIONES_ACU" => $request->input("VACACIONES_ACU"),
            "VACACIONES_USA" => $request->input("VACACIONES_USA"),
        ],[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        
        return redirect(route('Vacaciones.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
