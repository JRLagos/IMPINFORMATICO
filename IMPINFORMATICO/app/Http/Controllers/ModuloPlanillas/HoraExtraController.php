<?php

namespace App\Http\Controllers\ModuloPlanillas;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HoraExtraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response1 = Http::get('http://localhost:3000/SHOW_HORA_EXTRA/GETALL_HORA_EXTRA');
        $data1 = $response1->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response2 = Http::get('http://localhost:3000/SHOW_EMPLEADO/GETALL_EMPLEADO/2');
        $data2 = $response2->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
    
        // Convierte los datos JSON a un array asociativo
        $HoraExtra = json_decode($data1, true);
        $Empleado = json_decode($data2, true);
    
        return view('modplanilla.horaextra')->with('ResulHoraExtra', $HoraExtra)->with('ResulEmpleado', $Empleado);

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
        $HoraExtra = $request->all();

        $res = Http::post("http://localhost:3000/INS_HORA_EXTRA/HORA_EXTRA", $HoraExtra);

        return redirect(route('HoraExtra.index'));
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
        //DD($request);
        $COD_HOR_EXTRA = $request->id;
        $reponse = http::put('http://localhost:3000/UPT_HORA_EXTRA', [
            "PI_COD_HOR_EXTRA"=> $COD_PRODUCTO,
            "PI_COD_EMPLEADO"=> $request->get("COD_EMPLEADO"),
            "PV_DES_HOR_EXTRA"=> $request->get("DES_HOR_EXTRA"),
            "PI_CANT_HOR_EXTRA"=> $request->get("CANT_HOR_EXTRA"),
            "PDATE_FEC_HOR_EXTRA"=> $request->get("FEC_HOR_EXTRA")
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
