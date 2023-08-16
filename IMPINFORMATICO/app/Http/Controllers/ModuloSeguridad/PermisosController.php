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