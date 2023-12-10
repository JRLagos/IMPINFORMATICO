<?php

namespace App\Http\Controllers\ModuloSeguridad;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::get('http://localhost:3000/SHOW_ROLES/SEGURIDAD_ROLES');
        $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
    
        // Convierte los datos JSON a un array asociativo
        $Roles = json_decode($data, true);
    
        return view('modseguridad.roles')->with('ResulRoles', $Roles);
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
        // Obtener todos los roles existentes
    $rolesExist = Http::get("http://localhost:3000/SHOW_USUARIOS/SEGURIDAD_ROLES")->json();

    // Obtener el nuevo rol a agregar
    $newRole = $request->all();
    

    // Verificar si el nuevo rol ya existe
    foreach ($rolesExist as $existingRole) {
        if (strtoupper($existingRole['NOM_ROL']) === strtoupper($newRole['NOM_ROL'])) {
            // El rol ya existe, redirigir con un mensaje de error
            return redirect(route('Roles.index'))->with('roleExistsError', true);
        }
    }

    // El rol no existe, proceder con la inserción
    $res = Http::post("http://localhost:3000/INS_ROL/SEGURIDAD_ROLES", $newRole);

    // Redirigir a la página de roles
    return redirect(route('Roles.index'));
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
        $rolesExist = Http::get("http://localhost:3000/SHOW_USUARIOS/SEGURIDAD_ROLES")->json();
        // Obtener el nuevo rol a agregar
        $newRole = $request->all();

        // Verificar si el nuevo rol ya existe
    foreach ($rolesExist as $existingRole) {
        if (strtoupper($existingRole['NOM_ROL']) === strtoupper($newRole['NOM_ROL'])) {
            // El rol ya existe, redirigir con un mensaje de error
            if($newRole['COD_ROL']==$existingRole['COD_ROL']){break;}
            
            return redirect(route('Roles.index'))->with('roleExistsError', true);
        }
    }

        $upt_HoraExtra = Http::put('http://localhost:3000/UPT_ROLES/SEGURIDAD_ROLES/'.$request->input("COD_ROL"),[
            "COD_ROL" => $request->input('COD_ROL'),
            "NOM_ROL" => $request->input("NOM_ROL"),
            "DES_ROL" => $request->input("DES_ROL"),
        ]);
        
        return redirect(route('Roles.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
