<?php

namespace App\Http\Controllers\ModuloPlanillas;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\Response;

class DeduccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         // Obtenter el token generado y guardado en la sesión
         $sessionToken = $request->session()->get('generated_token');
         $response = Http::get('http://localhost:3000/SHOW_DEDUCCIONES/DEDUCCIONES',[
             'headers' => [
                 'Authorization' => 'Bearer ' . $sessionToken,
             ],
         ]);
         $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
     
         // Convierte los datos JSON a un array asociativo
         $Deduccion = json_decode($data, true);
     
         return view('modplanilla.deduccion')->with('ResulDeduccion', $Deduccion);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}