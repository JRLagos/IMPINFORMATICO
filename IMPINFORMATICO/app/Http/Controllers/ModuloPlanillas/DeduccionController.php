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

    public function indexIhss(Request $request)
    {
         // Obtenter el token generado y guardado en la sesión
         $sessionToken = $request->session()->get('generated_token');
         $response = Http::get('http://localhost:3000/GET_IHSS/SELECT_IHSS',[
             'headers' => [
                 'Authorization' => 'Bearer ' . $sessionToken,
             ],
         ]);
         $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
     
         // Convierte los datos JSON a un array asociativo
         $Ihss = json_decode($data, true);
     
         return view('modplanilla.ihss')->with('ResulIhss', $Ihss);
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
      
        // Obtenter el token generado y guardado en la sesión
        $sessionToken = $request->session()->get('generated_token');
        $Deduccion = $request->all();

        $res = Http::post("http://localhost:3000/INSERTAR_DEDUCCION/INSERT", $Deduccion,[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);

        return redirect(route('Deducciones.index'))->with('success', 'Datos ingresados con éxito.');
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
        $upd_municipio = Http::put('http://localhost:3000/ACTUALIZAR_DEDUCCION/UPDATE/'.$request->input("COD_DEDUCCION"),[
            "COD_DEDUCCION" => $request->input('COD_DEDUCCION'),
            "DEDUCCION" => $request->input("DEDUCCION"),
            "DES_DEDUCCION" => $request->input("DES_DEDUCCION"),
            "VALOR_DEDUCCION" => $request->input("VALOR_DEDUCCION"),
        ]);
        
        return redirect(route('Deducciones.index'))->with('success', 'La actualización se ha realizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
