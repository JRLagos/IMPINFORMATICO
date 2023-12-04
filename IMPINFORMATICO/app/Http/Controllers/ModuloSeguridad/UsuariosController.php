<?php

namespace App\Http\Controllers\ModuloSeguridad;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::get('http://localhost:3000/SHOW_USUARIOS/GETALL_USUARIOS');
        $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response2 = Http::get('http://localhost:3000/SHOW_ROLES/SEGURIDAD_ROLES');
        $data2 = $response2->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
    
        // Convierte los datos JSON a un array asociativo
        $Usuario = json_decode($data, true);
        $Rol = json_decode($data2, true);

        return view('modseguridad.usuario')->with('ResulUsuario', $Usuario)->with('ResulRol', $Rol);;
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
        //Datos de la tabla usuarios para validar la existencia previa 
        $CreExist = Http::get("http://localhost:3000/SHOW_USUARIOS/GETALL_USUARIOS")->json();
        // Obtener los datos del formulario
    $usuarioData = $request->only([
        'NOM_USUARIO', 'COD_ROL', 'CONTRASENA', 'EMAIL', 'IND_USUARIO'
    ]);

    foreach ($CreExist as $existente){
        if($usuarioData['NOM_USUARIO']==$existente['NOM_USUARIO'] || $usuarioData['EMAIL'] == $existente['EMAIL'])
        {
            return redirect(route('Usuarios.index'))->with('error','Registro repetido');
        }
    }

    $hashedPassword = Hash::make($usuarioData['CONTRASENA']);

    $usuarioData['CONTRASENA'] = $hashedPassword;


    // Realizar la solicitud HTTP sin incluir el token
    $res = Http::post("http://localhost:3000/INS_USUARIO/USUARIO", [
        "NOM_ROL" => null,
"DES_ROL" => null,
"COD_ROL" => $usuarioData['COD_ROL'],
"NOM_USUARIO" => $usuarioData['NOM_USUARIO'],
"CONTRASENA" => $usuarioData['CONTRASENA'],
"IND_USUARIO" => $usuarioData['IND_USUARIO'],
"PRE_CONTESTADAS" => 0,
"EMAIL" => $usuarioData['EMAIL'],
"COD_USUARIO" => null,
"CONTRASENA_HIST" => null,
"NOM_OBJETO" => null,
"DES_OBJETO" => null,
"TIP_OBJETO" => null,
"COD_OBJETO" => null,
"PER_INSERTAR" => null,
"PER_ELIMINAR" => null,
"PER_ACTUALIZAR" => null,
"PER_CONSULTAR" => null,
"DES_PARAMETRO" => null,
"DES_VALOR" => null,
"COD_PARAMETRO" => null,
"FEC_CREACION" => null,
"FEC_MODIFICACION" => null,
"DES_PREGUNTA" => null,
"COD_PREGUNTA" => null,
"DES_RESPUESTA" => null,
"NOM_PERSONA" => '.',
"APE_PERSONA" => '.',
"DNI_PERSONA" => 1,
"RTN_PERSONA" => 1,
"TIP_TELEFONO" => 'FIJO',
"NUM_TELEFONO" => 0,
"SEX_PERSONA" => 'MASCULINO',
"EDAD_PERSONA" => 17,
"FEC_NAC_PERSONA" => '1111-01-01',
"LUG_NAC_PERSONA" => 'no sé',
"IND_CIVIL" => 'SOLTERO',
"PES_PERSONA" => 0,
"EST_PERSONA" => 0,
"FOTO_PERSONA" => null,
"CORREO_ELECTRONICO" => $usuarioData['EMAIL'],
"DES_CORREO" => null,
"NIV_ESTUDIO" => null,
"NOM_CENTRO_ESTUDIO" => 'nada',
"COD_MUNICIPIO" => null,
"DES_DIRECCION" => 'nada'
    ]);

    // Verificar si la solicitud HTTP fue exitosa
    if ($res->successful()) {
        // Redirigir con un mensaje de éxito
        return redirect(route('Usuarios.index'))->with('success', 'Datos ingresados con éxito.');
    } else {
        // Manejar el caso en que la solicitud no fue exitosa
        // Puedes agregar lógica adicional o redirigir con un mensaje de error
        return redirect(route('Usuarios.index'))->with('error', 'Error al ingresar los datos.');
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
