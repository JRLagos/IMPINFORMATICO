<?php

namespace App\Http\Controllers\ModuloSeguridad;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ObjetosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::get('http://localhost:3000/SHOW_OBJETOS/SEGURIDAD_OBJETOS');
        $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
    
        // Convierte los datos JSON a un array asociativo
        $Objetos = json_decode($data, true);
    
        return view('modseguridad.objetos')->with('ResulObjetos', $Objetos);
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
        $Roles = $request->all();
        $response = Http::get('http://localhost:3000/SHOW_OBJETOS/SEGURIDAD_OBJETOS');
        $responseJs=$response->json();

        foreach($responseJs as $registros){
            if($registros['NOM_OBJETO']==$Roles['NOM_OBJETO']){

                return redirect(route('Objetos.index'))->withErrors(['Mensaje'=>'Registro ya existente']);
            }
        }

        $res = Http::post("http://localhost:3000/INS_OBJETO/SEGURIDAD_OBJETOS", $Roles);

        return redirect(route('Objetos.index'));
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
        $upt_objetos = Http::put('http://localhost:3000/UPT_OBJETOS/SEGURIDAD_OBJETOS/'.$request->input("COD_OBJETO"),[
            "COD_OBJETO" => $request->input('COD_OBJETO'),
            "NOM_OBJETO" => $request->input('NOM_OBJETO'),
            "DES_OBJETO" => $request->input('DES_OBJETO'),
            "TIP_OBJETO" => $request->input('TIP_OBJETO'),
        ]);
        
        return redirect(route('Objetos.index'));
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
