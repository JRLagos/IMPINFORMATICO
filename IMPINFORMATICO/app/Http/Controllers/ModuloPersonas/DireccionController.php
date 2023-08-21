<?php

namespace App\Http\Controllers\ModuloPersonas;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DireccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::get('http://localhost:3000/SHOW_DIRECCION/GETALL_DIRECCION');
        $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response1 = Http::get('http://localhost:3000/SHOW_PERSONA/GETALL_PERSONA/2');
        $data1 = $response1->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response2 = Http::get('http://localhost:3000/SHOW_MUNICIPIO/GETALL_MUNICIPIO/2');
        $data2 = $response2->getBody()->getContents(); // Obtiene el cuerpo de la respuesta

    
        // Convierte los datos JSON a un array asociativo
        $Direccion = json_decode($data, true);
        $Persona = json_decode($data1, true);
        $Municipio = json_decode($data2, true);
    
        return view('modpersonas.direccion')->with('ResulDireccion', $Direccion)->with('ResulPersona', $Persona)->with('ResulMunicipio', $Municipio);
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
        $upd_Direccion = Http::put('http://localhost:3000/UPD_DIRECCION/DIRECCION/'.$request->input("COD_DIRECCION"),[
            "COD_DIRECCION" => $request->input('COD_DIRECCION'),
            "COD_PERSONA" => $request->input("COD_PERSONA"),
            "COD_MUNICIPIO" => $request->input("COD_MUNICIPIO"),
            "DES_DIRECCION" => $request->input("DES_DIRECCION"),
        ]);
        
        return redirect(route('Direcciones.index'))->with('success', 'La actualización se ha realizado con éxito.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
