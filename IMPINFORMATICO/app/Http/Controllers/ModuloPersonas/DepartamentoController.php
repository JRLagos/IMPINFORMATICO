<?php

namespace App\Http\Controllers\ModuloPersonas;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::get('http://localhost:3000/SHOW_DEPARTAMENTO/GETALL_DEPARTAMENTO/2');
        $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
    
        // Convierte los datos JSON a un array asociativo
        $Departamento = json_decode($data, true);
    
        return view('modpersonas.departamento')->with('ResulDepartamento', $Departamento);
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
        $Departamento = $request->all();

        $res = Http::post("http://localhost:3000/INS_DEPARTAMENTO/DEPARTAMENTO", $Departamento);

        return redirect(route('Departamento.index'));
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
        $upt_departamento = Http::put('http://localhost::3000/UPT_DEPARTAMENTO/'.$request->input("COD_DEPARTAMENTO"),[
            "NOM_DEPARTAMENTO" => $request->input("NOM_DEPARTAMENTO"),
        ]);
        
        return redirect(route('Departamento.index')->with('agregado','El asiento fue agregado correctamente'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
