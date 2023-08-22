<?php

namespace App\Http\Controllers\ModuloPersonas;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


class BancoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::get('http://localhost:3000/SHOW_BANCO/GETALL_BANCO/2');
        $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response2 = Http::get('http://localhost:3000/SHOW_EMPLEADO/GETALL_EMPLEADO/2');
        $data2 = $response2->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
  
        // Convierte los datos JSON a un array asociativo
        $Banco = json_decode($data, true);
        $Empleado = json_decode($data2, true);
        
        return view('modpersonas.banco')->with('ResulBanco', $Banco)->with('ResulEmpleado', $Empleado);
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
    public function update(Request $request)
    {
        $upd_Banco = Http::put('http://localhost:3000/UPD_BANCO/BANCO/'.$request->input("COD_BANCO"),[
            "COD_BANCO" => $request->input('COD_BANCO'),
            "COD_EMPLEADO" => $request->input("COD_EMPLEADO"),
            "NOM_BANCO" => $request->input("NOM_BANCO"),
            "DES_BANCO" => $request->input("DES_BANCO"),
            "NUM_CTA_BANCO" => $request->input("NUM_CTA_BANCO"),
        ]);
        
        return redirect(route('Banco.index'))->with('success', 'La actualización se ha realizado con éxito.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
