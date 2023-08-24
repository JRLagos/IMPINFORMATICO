<?php

namespace App\Http\Controllers\ModuloPersonas;

use Illuminate\Support\Facades\Http;
//use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\Response;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtenter el token generado y guardado en la sesión
        $sessionToken = $request->session()->get('generated_token');

        $response1 = Http::withHeaders([
            'Authorization' => $sessionToken,
        ])->get('http://localhost:3000/SHOW_PERSONA/GETALL_PERSONA/2');
        $data1 = $response1->getBody()->getContents(); // Obtiene el cuerpo de la respuesta


        $response2 = Http::withHeaders([
            'Authorization' => $sessionToken,
        ])->get('http://localhost:3000/SHOW_MUNICIPIO/GETALL_MUNICIPIO/2');
        $data2 = $response2->getBody()->getContents(); // Obtiene el cuerpo de la respuesta


        $response3 = Http::withHeaders([
            'Authorization' => $sessionToken,
        ])->get('http://localhost:3000/SHOW_SUCURSAL/GETALL_SUCURSAL/0');
        $data3 = $response3->getBody()->getContents(); // Obtiene el cuerpo de la respuesta


        $response4 = Http::withHeaders([
            'Authorization' => $sessionToken,
        ])->get('http://localhost:3000/SHOW_DEPTO_EMPRESA/GETALL_DEPTO_EMPRESA/0');
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
                // Obtenter el token generado y guardado en la sesión
                $sessionToken = $request->session()->get('generated_token');

                $Persona = $request->all();
                
                $res = Http::withHeaders([
                    'Authorization' => $sessionToken,
                ])->post('http://localhost:3000/INS_EMPLEADO/EMPLEADO_SIN_USUARIO');
        
                return redirect(route('Persona.index'))->with('success', 'Datos ingresados con éxito.');
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
    public function update(Request $request)
    {
    // Obtenter el token generado y guardado en la sesión
    $sessionToken = $request->session()->get('generated_token');
    
        // Obtén el valor del campo concatenado
    $nombreApellido = $request->input('nombre_apellido');

    // Divide el nombre y el apellido
    list($nombre, $apellido) = explode(' ', $nombreApellido, 2);


        $upd_persona = Http::put('http://localhost:3000/UPD_PERSONA/PERSONA/'.$request->input("COD_PERSONA"),[
            "COD_PERSONA" => $request->input('COD_PERSONA'),
            "NOM_PERSONA" => $nombre, // Usar el nombre dividido
            "APE_PERSONA" => $apellido, // Usar el apellido dividido
            "DNI_PERSONA" => $request->input("DNI_PERSONA"),
            "RTN_PERSONA" => $request->input("RTN_PERSONA"),
            "TIP_TELEFONO" => $request->input("TIP_TELEFONO"),
            "NUM_TELEFONO" => $request->input("NUM_TELEFONO"),
            "SEX_PERSONA" => $request->input("SEX_PERSONA"),
            "EDAD_PERSONA" => $request->input("EDAD_PERSONA"),
            "FEC_NAC_PERSONA" => $request->input("FEC_NAC_PERSONA"),
            "LUG_NAC_PERSONA" => $request->input("LUG_NAC_PERSONA"),
            "IND_CIVIL" => $request->input("IND_CIVIL"),
        ],[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        
        return redirect(route('Persona.index'))->with('success', 'La actualización se ha realizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
