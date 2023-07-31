<?php

namespace App\Http\Controllers\HoraExtra;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HoraExtraController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $response = Http::get('http://localhost:3000/SHOW_HORA_EXTRA/GETALL_HORA_EXTRA/2');
        $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
    
        // Convierte los datos JSON a un array asociativo
        $HoraExtra = json_decode($data, true);
    
        return view('horaextra.index')->with('ResulHoraExtra', $HoraExtra);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $horaExtra = $request->all();

        $res = Http::post("http://localhost:3000/INS_HORA_EXTRA/HORA_EXTRA", $horaExtra);

        return redirect(route('horaextra.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, INT $PI_COD_HOR_EXTRA)
    {
        $miData = $req->all();
        return $PI_COD_HOR_EXTRA;   
        return $miData;

        $res = Http::put("http://localhost:3000/UPT_HORA_EXTRA/HORA_EXTRA/$PI_COD_HOR_EXTRA", $miData);

        return redirect(route('horaextra.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
