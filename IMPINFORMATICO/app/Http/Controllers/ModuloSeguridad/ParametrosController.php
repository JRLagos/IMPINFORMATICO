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

        $response1 = Http::get('http://localhost:3000/SHOW_PARAMETROS/SEGURIDAD_PARAMETROS');
        $response1Json = $response1->json();

    // Acceder al valor de "DES_PARAMETRO" de la variable $Parametros
    $desParametro = $Parametros['DES_PARAMETRO'];

    // Verificar si el valor de "DES_PARAMETRO" está en la columna correspondiente del JSON
    $parametroExistente = collect($response1Json)->where('DES_PARAMETRO', $desParametro)->first();

    // Si $parametroExistente tiene un valor, significa que ya existe en la base de datos
    if ($parametroExistente) {
        return redirect(route('Parametros.index'))->with('error', 'El valor introducido ya existe en la base de datos.');
    }


    $res = Http::post("http://localhost:3000/INS_PARAMETROS/SEGURIDAD_PARAMETROS", $Parametros);


    // Continuar con el flujo normal si no hay coincidencia

    return redirect(route('Parametros.index'))->with('success', 'Parametro almacenado exitosamente.');

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
    $updateParametros = [
        "COD_PARAMETRO" => $request->input('COD_PARAMETRO'),
        "DES_PARAMETRO" => $request->input('DES_PARAMETRO'),
        "DES_VALOR" => $request->input('DES_VALOR'),
        "FEC_CREACION" => $request->input('FEC_CREACION'),
        "FEC_MODIFICACION" => $request->input('FEC_MODIFICACION'),
    ];

    // Obtener todos los parámetros existentes
    $response = Http::get('http://localhost:3000/SHOW_PARAMETROS/SEGURIDAD_PARAMETROS');
    $existingParametros = $response->json();

    // Verificar si el nuevo valor de DES_PARAMETRO ya existe en la base de datos
    $newDesParametro = $updateParametros['DES_PARAMETRO'];
    $existingDesParametros = array_column($existingParametros, 'DES_PARAMETRO');

    if (in_array($newDesParametro, $existingDesParametros)) {
        // El nuevo valor ya existe, lanzar un error o realizar la acción necesaria
        return redirect(route('Parametros.index'))->with('error', 'El nuevo valor de DES_PARAMETRO ya existe');
    }

    // Si no hay conflictos, realizar la actualización
    $uptParametros = Http::put(
        'http://localhost:3000/UPT_PARAMETROS/SEGURIDAD_PARAMETROS/'.$request->input("COD_PARAMETRO"),
        $updateParametros
    );

    return redirect(route('Parametros.index'))->with('success', 'Operación realizada con éxito');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
