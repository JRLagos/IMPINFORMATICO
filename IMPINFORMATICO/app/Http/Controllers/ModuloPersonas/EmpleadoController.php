<?php

namespace App\Http\Controllers\ModuloPersonas;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\Response;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtenter el token generado y guardado en la sesión
        $sessionToken = $request->session()->get('generated_token');
        $response1 = Http::get('http://localhost:3000/SHOW_EMPLEADO/GETALL_EMPLEADO/2');
        $data1 = $response1->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response2 = Http::get('http://localhost:3000/SHOW_MUNICIPIO/GETALL_MUNICIPIO/2');
        $data2 = $response2->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response3 = Http::get('http://localhost:3000/SHOW_SUCURSAL/GETALL_SUCURSAL/0');
        $data3 = $response3->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response4 = Http::get('http://localhost:3000/SHOW_DEPTO_EMPRESA/GETALL_DEPTO_EMPRESA/0');
        $data4 = $response4->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response5 = Http::get('http://localhost:3000/SHOW_PERSONA/GETALL_PERSONA/2');
        $data5 = $response1->getBody()->getContents(); // Obtiene el cuerpo de la respuesta

        // Convierte los datos JSON a un array asociativo
        $Empleado = json_decode($data1, true);
        $Municipio = json_decode($data2, true);
        $Sucursal = json_decode($data3, true);
        $DeptoEmpresa = json_decode($data4, true);
        $Persona = json_decode($data5, true);
       return view('modpersonas.empleado')->with('ResulEmpleado', $Empleado)->with('ResulMunicipio', $Municipio)->with('ResulSucursal', $Sucursal)->with('ResulDeptoEmpresa', $DeptoEmpresa)->with('ResulPersona', $Persona); 
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
    public function manejarDatos(Request $request)
    {
        $sessionToken = $request->session()->get('generated_token');
        // Obtener datos del formulario de Datos Personales
        $datosPersonales = $request->only(['NOM_PERSONA', 'APE_PERSONA', 'DNI_PERSONA', 'TIP_TELEFONO','NUM_TELEFONO', 'SEX_PERSONA'
        , 'FEC_NAC_PERSONA', 'LUG_NAC_PERSONA', 'IND_CIVIL', 'CORREO_ELECTRONICO', 'DES_CORREO', 'NIV_ESTUDIO', 'NOM_CENTRO_ESTUDIO', 'COD_MUNICIPIO', 'DES_DIRECCION']);
    

        // Calcular la edad
       $fechaNacimiento = new \DateTime($datosPersonales['FEC_NAC_PERSONA']);
       $hoy = new \DateTime();
       $edad = $hoy->diff($fechaNacimiento)->y;
       $datosPersonales['EDAD_PERSONA'] = $edad;

        // Obtener datos del formulario de Información Laboral
        $infoLaboral = $request->only(['COD_SUCURSAL', 'COD_DEPTO_EMPRESA', 'TIP_CONTRATO', 'PUE_TRA_EMPLEADO', 'FEC_INGRESO', 'NUM_SEG_SOCIAL'
        , 'SAL_BAS_EMPLEADO', 'NOM_BANCO', 'DES_BANCO', 'NUM_CTA_BANCO']);
    
        // Combinar ambos conjuntos de datos en un solo array
        $empleadoData = array_merge($datosPersonales, $infoLaboral);
    
        // Realizar la solicitud HTTP con los datos combinados
        $res = Http::post("http://localhost:3000/INS_EMPLEADO/EMPLEADO_SIN_USUARIO", $empleadoData, [
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
         
         return redirect(route('Empleado.index'))->with('success', 'Datos ingresados con éxito.');
     
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
        $upd_empleado = Http::put('http://localhost:3000/UPD_EMPLEADO/EMPLEADO/'.$request->input("COD_EMPLEADO"),[
            "COD_EMPLEADO" => $request->input('COD_EMPLEADO'),
            "COD_SUCURSAL" => $request->input("COD_SUCURSAL"),
            "COD_DEPTO_EMPRESA" => $request->input("COD_DEPTO_EMPRESA"),
            "TIP_CONTRATO" => $request->input("TIP_CONTRATO"),
            "PUE_TRA_EMPLEADO" => $request->input("PUE_TRA_EMPLEADO"),
            "FEC_INGRESO" => $request->input("FEC_INGRESO"),
            "NUM_SEG_SOCIAL" => $request->input("NUM_SEG_SOCIAL"),
            "SAL_BAS_EMPLEADO" => $request->input("SAL_BAS_EMPLEADO"),
        ],[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        
        return redirect(route('Empleado.index'))->with('success', 'La actualización se ha realizado con éxito.');

    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
