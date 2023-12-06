<?php

namespace App\Http\Controllers\ModuloPersonas;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\Response;

class MunicipioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtenter el token generado y guardado en la sesión
        $sessionToken = $request->session()->get('generated_token');
        $response1 = Http::get('http://localhost:3000/SHOW_MUNICIPIO/GETALL_MUNICIPIO/0');
        $data1 = $response1->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response2 = Http::get('http://localhost:3000/SHOW_DEPARTAMENTO/DEPARTAMENTO_ACTIVO');
        $data2 = $response2->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
    
        // Convierte los datos JSON a un array asociativo
        $Municipio = json_decode($data1, true);
        $Departamento = json_decode($data2, true);
    
        return view('modpersonas.municipio')->with('ResulMunicipio', $Municipio)->with('ResulDepartamento', $Departamento);
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
        $request->validate([
            'NOM_MUNICIPIO' => 'required|unique:municipios,NOM_MUNICIPIO|max:50 ',
        ], [
            'NOM_MUNICIPIO.unique' => 'El municipio ya existe en la base de datos.',
            'NOM_MUNICIPIO.required' => 'El nombre del departamento es obligatorio.',
        ]);
        // Obtenter el token generado y guardado en la sesión
        $sessionToken = $request->session()->get('generated_token');
        $Municipio = $request->all();

        $res = Http::post("http://localhost:3000/INS_MUNICIPIO/MUNICIPIO", $Municipio,[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);

        return redirect(route('Municipio.index'))->with('success', 'Datos ingresados con éxito.');
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
        $upd_municipio = Http::put('http://localhost:3000/UPD_MUNICIPIO/MUNICIPIO/'.$request->input("COD_MUNICIPIO"),[
            "COD_MUNICIPIO" => $request->input('COD_MUNICIPIO'),
            "COD_DEPARTAMENTO" => $request->input("COD_DEPARTAMENTO"),
            "NOM_MUNICIPIO" => $request->input("NOM_MUNICIPIO"),
        ]);
        
        return redirect(route('Municipio.index'))->with('success', 'La actualización se ha realizado con éxito.');
    }

    public function desactivar(Request $request)
    {
         // Obtenter el token generado y guardado en la sesión
         $sessionToken = $request->session()->get('generated_token');
        $desact_departamento = Http::put('http://localhost:3000/ACT_DESACT_MUNICIPIO/ELIMINAR_MUNICIPIO/'.$request->input("COD_MUNICIPIO"),[
            "COD_MUNICIPIO" => $request->input('COD_MUNICIPIO'),
        ],[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        
        return redirect(route('Municipio.index'))->with('success', 'La actualización se ha realizado con éxito.');
    }

    public function activar(Request $request)
    {
         // Obtenter el token generado y guardado en la sesión
         $sessionToken = $request->session()->get('generated_token');
        $act_departamento = Http::put('http://localhost:3000/ACT_DESACT_MUNICIPIO/ACTIVAR_MUNICIPIO/'.$request->input("COD_MUNICIPIO"),[
            "COD_MUNICIPIO" => $request->input('COD_MUNICIPIO'),
        ],[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        
        return redirect(route('Municipio.index'))->with('success', 'La actualización se ha realizado con éxito.');
    }
    public function indexEliminados(Request $request)
    {
         // Obtenter el token generado y guardado en la sesión
         $sessionToken = $request->session()->get('generated_token');
        $response = Http::get('http://localhost:3000/SHOW_DEPTO_EMPRESA/GETALL_MUNICIPIO2/0',[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
    
        // Convierte los datos JSON a un array asociativo
        $MunicipioEliminado = json_decode($data, true);
    
        return view('modpersonas.municipioseliminados')->with('ResulMunicipioEliminado', $MunicipioEliminado);
    }
}
