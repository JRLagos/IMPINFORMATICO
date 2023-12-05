<?php

namespace App\Http\Controllers\ModuloSeguridad;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermisosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response1 = Http::get('http://localhost:3000/SHOW_PERMISOS/SEGURIDAD_PERMISOS');
        $data1 = $response1->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response2 = Http::get('http://localhost:3000/SHOW_ROLES/SEGURIDAD_ROLES');
        $data2 = $response2->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response3 = Http::get('http://localhost:3000/SHOW_OBJETOS/SEGURIDAD_OBJETOS');
        $data3 = $response3->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
    
        // Convierte los datos JSON a un array asociativo
        $Permisos = json_decode($data1, true);
        $Roles = json_decode($data2, true);
        $Objetos = json_decode($data3, true);
    
        return view('modseguridad.permisos')->with('ResulPermisos', $Permisos)->with('ResulRoles', $Roles)->with('ResulObjetos', $Objetos);
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
        $Permisos = $request->all();
        $response1 = Http::get('http://localhost:3000/SHOW_PERMISOS/SEGURIDAD_PERMISOS');
        $response1Js=$response1->json();

        foreach($response1Js as $registros){
            if($registros['COD_ROL']==$Permisos['COD_ROL'] && $registros['COD_OBJETO']=$Permisos['COD_OBJETO']){

                return redirect(route('Permisos.index'))->withErrors(['Mensaje'=>'Registro ya existente']);
            }
        }

   

        // Verificar y asignar valores para cada permiso
    // Limpiar el arreglo manteniendo solo los valores con "1"
    foreach (['PER_INSERTAR', 'PER_ELIMINAR', 'PER_ACTUALIZAR', 'PER_CONSULTAR'] as $permiso) {
        if (!isset($Permisos[$permiso]) && isset($Permisos['permisoHidden_' . $permiso])) {
            $Permisos[$permiso] = $Permisos['permisoHidden_' . $permiso];
        }
    }

    // Limpiar el arreglo eliminando claves no necesarias
    unset(
        $Permisos['permisoHidden_PER_INSERTAR'],
        $Permisos['permisoHidden_PER_ELIMINAR'],
        $Permisos['permisoHidden_PER_ACTUALIZAR'],
        $Permisos['permisoHidden_PER_CONSULTAR']
    );


        $res = Http::post("http://localhost:3000/INS_PERMISOS/SEGURIDAD_PERMISOS", $Permisos);

        return redirect(route('Permisos.index'));
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

        
        $upt_persmisos = Http::put('http://localhost:3000/UPT_PERMISOS/SEGURIDAD_PERMISOS/'.$request->input("COD_ROL"),[
            "COD_PARAMETRO" => $request->input('COD_OBJETO'),
            "PER_INSERTAR" => $request->input('PER_INSERTAR'),
            "PER_ELIMINAR" => $request->input('PER_ELIMINAR'),
            "PER_ACTUALIZAR" => $request->input('PER_ACTUALIZAR'),
            "PER_CONSULTAR" => $request->input('PER_CONSULTAR'),
        ]);
        
        return redirect(route('Permisos.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
