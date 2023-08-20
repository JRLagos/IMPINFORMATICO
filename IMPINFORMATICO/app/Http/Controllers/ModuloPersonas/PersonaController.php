<?php

namespace App\Http\Controllers\ModuloPersonas;

use Illuminate\Support\Facades\Http;
//use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response1 = Http::get('http://localhost:3000/SHOW_PERSONA/GETALL_PERSONA/2');
        $data1 = $response1->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response2 = Http::get('http://localhost:3000/SHOW_MUNICIPIO/GETALL_MUNICIPIO/2');
        $data2 = $response2->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response3 = Http::get('http://localhost:3000/SHOW_SUCURSAL/GETALL_SUCURSAL/0');
        $data3 = $response3->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response4 = Http::get('http://localhost:3000/SHOW_DEPTO_EMPRESA/GETALL_DEPTO_EMPRESA/0');
        $data4 = $response4->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        // Convierte los datos JSON a un array asociativo
        $Persona = json_decode($data1, true);
        $Municipio = json_decode($data2, true);
        $Sucursal = json_decode($data3, true);
        $DeptoEmpresa = json_decode($data4, true);
        return view('modpersonas.persona')->with('ResulPersona', $Persona)->with('ResulMunicipio', $Municipio)->with('ResulSucursal', $Sucursal)->with('ResulDeptoEmpresa', $DeptoEmpresa);
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
                $Persona = $request->all();
        
                $res = Http::post("http://localhost:3000/INS_EMPLEADO/EMPLEADO_SIN_USUARIO", $Persona);
        
                return redirect(route('Persona.index'));
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
