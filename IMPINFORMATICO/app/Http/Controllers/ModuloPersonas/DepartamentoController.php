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
        $response = Http::get('http://localhost:3000/SHOW_DEPARTAMENTO/DEPARTAMENTO_ACTIVO');
        $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
    
        // Convierte los datos JSON a un array asociativo
        $Departamento = json_decode($data, true);
    
        return view('modpersonas.departamento')->with('ResulDepartamento', $Departamento);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function indexEliminados()
    {
        $response = Http::get('http://localhost:3000/SHOW_DEPARTAMENTO/DEPARTAMENTO_ELIMINADO');
        $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
    
        // Convierte los datos JSON a un array asociativo
        $DepartamentoEliminado = json_decode($data, true);
    
        return view('modpersonas.departamentosEliminados')->with('ResulDepartamentoEliminado', $DepartamentoEliminado);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $Departamento = $request->all();

        $res = Http::post("http://localhost:3000/INS_DEPARTAMENTO/DEPARTAMENTO", $Departamento);

        return redirect(route('Departamento.index'))->with('success', 'Registro ingresado con éxito.');
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
    public function activar(Request $request)
    {
        $act_departamento = Http::put('http://localhost:3000/ACT_DESACT_DEPARTAMENTO/ACTIVAR_DEPARTAMENTO/'.$request->input("COD_DEPARTAMENTO"),[
            "COD_DEPARTAMENTO" => $request->input('COD_DEPARTAMENTO'),
        ]);
        
        return redirect(route('Departamento.index'))->with('success', 'La actualización se ha realizado con éxito.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $upt_departamento = Http::put('http://localhost:3000/UPD_DEPARTAMENTO/DEPARTAMENTO/'.$request->input("COD_DEPARTAMENTO"),[
            "COD_DEPARTAMENTO" => $request->input('COD_DEPARTAMENTO'),
            "NOM_DEPARTAMENTO" => $request->input("NOM_DEPARTAMENTO"),
        ]);
        
        return redirect(route('Departamento.index'))->with('success', 'La actualización se ha realizado con éxito.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function desactivar(Request $request)
    {
        $desact_departamento = Http::put('http://localhost:3000/ACT_DESACT_DEPARTAMENTO/ELIMINAR_DEPARTAMENTO/'.$request->input("COD_DEPARTAMENTO"),[
            "COD_DEPARTAMENTO" => $request->input('COD_DEPARTAMENTO'),
        ]);
        
        return redirect(route('Departamento.index'))->with('success', 'La actualización se ha realizado con éxito.');
    }
}
