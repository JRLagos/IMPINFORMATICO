<?php

namespace App\Http\Controllers\ModuloSeguridad;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParametrosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response1 = Http::get('http://localhost:3000/SHOW_PARAMETROS/SEGURIDAD_PARAMETROS');
        $data1 = $response1->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response2 = Http::get('http://localhost:3000/SHOW_USUARIOS/GETALL_USUARIOS');
        $data2 = $response2->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
    
        // Convierte los datos JSON a un array asociativo
        $Parametros = json_decode($data1, true);
        $Usuarios = json_decode($data2, true);
    
        return view('modseguridad.parametros')->with('ResulParametros', $Parametros)->with('ResulUsuario', $Usuarios);
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
        $Parametros = $request->all();

        $res = Http::post("http://localhost:3000/INS_PARAMETROS/SEGURIDAD_PARAMETROS", $Parametros);

        return redirect(route('Parametros.index'));
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
        $upt_parametros = Http::put('http://localhost:3000/UPT_PARAMETROS/SEGURIDAD_PARAMETROS/'.$request->input("COD_PARAMETRO"),[
            "COD_PARAMETRO" => $request->input('COD_PARAMETRO'),
            "DES_PARAMETRO" => $request->input('DES_PARAMETRO'),
            "DES_VALOR" => $request->input('DES_VALOR'),
            "FEC_CREACION" => $request->input('FEC_CREACION'),
            "FEC_MODIFICACION" => $request->input('FEC_MODIFICACION'),
        ]);
        
        return redirect(route('Parametros.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
