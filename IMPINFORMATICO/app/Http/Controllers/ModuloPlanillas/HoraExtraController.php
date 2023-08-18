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
    public function update(Request $request)
    {
        $upt_HoraExtra = Http::put('http://localhost:3000/UPT_HORA_EXTRA/HORA_EXTRA/'.$request->input("COD_HOR_EXTRA"),[
            "COD_HOR_EXTRA" => $request->input('COD_HOR_EXTRA'),
            "COD_EMPLEADO" => $request->input("COD_EMPLEADO"),
            "DES_HOR_EXTRA" => $request->input("DES_HOR_EXTRA"),
            "CANT_HOR_EXTRA" => $request->input("CANT_HOR_EXTRA"),
            "FEC_HOR_EXTRA" => $request->input("FEC_HOR_EXTRA"),
        ]);
        
        return redirect(route('HoraExtra.index'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
