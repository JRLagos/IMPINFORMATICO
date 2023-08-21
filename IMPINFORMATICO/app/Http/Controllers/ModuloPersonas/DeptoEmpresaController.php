<?php

namespace App\Http\Controllers\ModuloPersonas;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class DeptoEmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::get('http://localhost:3000/SHOW_DEPTO_EMPRESA/GETALL_DEPTO_EMPRESA/2');
        $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
    
        // Convierte los datos JSON a un array asociativo
        $DeptoEmpresa = json_decode($data, true);

        return view('modpersonas.deptoempresa')->with('ResulDeptoEmpresa', $DeptoEmpresa); 
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
        {
            $DeptoEmpresa = $request->all();
    
            $res = Http::post("http://localhost:3000/INS_DEPTO_EMPRESA/DEPARTAMENTOS_EMPRESA", $DeptoEmpresa);
    
            return redirect(route('DeptoEmpresa.index'))->with('success', 'Datos ingresados con éxito.');
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
    public function update(Request $request)
    {
        $upd_municipio = Http::put('http://localhost:3000/UPD_DEPTO_EMPRESA/DEPARTAMENTO EMPRESA/'.$request->input("COD_DEPTO_EMPRESA"),[
            "COD_DEPTO_EMPRESA" => $request->input('COD_DEPTO_EMPRESA'),
            "NOM_DEPTO_EMPRESA" => $request->input("NOM_DEPTO_EMPRESA"),
            "DES_DEPTO_EMPRESA" => $request->input("DES_DEPTO_EMPRESA"),
        ]);
        
        return redirect(route('DeptoEmpresa.index'))->with('success', 'La actualización se ha realizado con éxito.');

    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
