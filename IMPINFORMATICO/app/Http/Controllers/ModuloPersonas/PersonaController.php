<?php

namespace App\Http\Controllers\ModuloPersonas;

use Illuminate\Support\Facades\Http;
//use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
        ])->get('http://localhost:3000/SHOW_PERSONA/GETALL_PERSONA/1');
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
    public function manejarDatos2(Request $request)
    {
        
        $request->validate([
            'DNI_PERSONA' => 'required|unique:personas,DNI_PERSONA',
            'NUM_TELEFONO' => 'required|unique:personas,NUM_TELEFONO',
        ], [
            'DNI_PERSONA.unique' => 'El DNI ya está registrado en el sistema.',
            'DNI_PERSONA.required' => 'El DNI es obligatorio.',
            'NUM_TELEFONO.unique' => 'El número de teléfono ya está registrado en el sistema.',
            'NUM_TELEFONO.required' => 'El número de teléfono es obligatorio.',
        ]);
        

        $sessionToken = $request->session()->get('generated_token');
        // Obtener datos del formulario de Datos Personales
        $datosPersonales = $request->only(['NOM_PERSONA', 'APE_PERSONA', 'DNI_PERSONA', 'TIP_TELEFONO','NUM_TELEFONO', 'SEX_PERSONA'
        , 'FEC_NAC_PERSONA', 'LUG_NAC_PERSONA', 'IND_CIVIL', 'CORREO_ELECTRONICO', 'DES_CORREO', 'COD_MUNICIPIO', 'DES_DIRECCION']);
    
           
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
         
         return redirect(route('Persona.index'))->with('success', 'Datos ingresados con éxito.');
     
    }

    public function insPersonas(Request $request)
    {
                // Obtenter el token generado y guardado en la sesión
                $sessionToken = $request->session()->get('generated_token');
                $response1 = Http::get('http://localhost:3000/SHOW_EMPLEADO/GETALL_EMPLEADO/1');
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
               return view('modpersonas.inspersona')->with('ResulEmpleado', $Empleado)->with('ResulMunicipio', $Municipio)->with('ResulSucursal', $Sucursal)->with('ResulDeptoEmpresa', $DeptoEmpresa)->with('ResulPersona', $Persona); 
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
        $request->validate([
            'DNI_PERSONA' => 'required|string|max:15',
        ]);
    
        // Verificar si ya existe una persona con el mismo DNI
        $existingPersona = DB::table('personas')
            ->where('DNI_PERSONA', $request->input('DNI_PERSONA'))
            ->where('COD_PERSONA', '!=', $request->input('COD_PERSONA')) // Excluir el registro actual
            ->first();
    
        // Si existe, mostrar mensaje de error y redirigir
        if ($existingPersona) {
            return redirect()->back()->withErrors(['DNI_PERSONA' => 'Ya existe una persona con este DNI.']);
        }

    // Obtenter el token generado y guardado en la sesión
    $sessionToken = $request->session()->get('generated_token');
    
        // Obtén el valor del campo concatenado
    $nombreApellido = $request->input('nombre_apellido');

    // Divide el nombre y el apellido
    list($nombre, $apellido) = explode(' ', $nombreApellido, 2);

        // Convertir la fecha de nacimiento a una instancia de Carbon
        $fechaNacimiento = Carbon::parse($request->input("FEC_NAC_PERSONA"));

        // Calcular la edad
        $edad = $fechaNacimiento->age;

        $upd_persona = Http::put('http://localhost:3000/UPD_PERSONA/PERSONA/'.$request->input("COD_PERSONA"),[
            "COD_PERSONA" => $request->input('COD_PERSONA'),
            "NOM_PERSONA" => $nombre, // Usar el nombre dividido
            "APE_PERSONA" => $apellido, // Usar el apellido dividido
            "DNI_PERSONA" => $request->input("DNI_PERSONA"),
            "RTN_PERSONA" => $request->input("RTN_PERSONA"),
            "TIP_TELEFONO" => $request->input("TIP_TELEFONO"),
            "NUM_TELEFONO" => $request->input("NUM_TELEFONO"),
            "SEX_PERSONA" => $request->input("SEX_PERSONA"),
            "EDAD_PERSONA" => $edad,
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