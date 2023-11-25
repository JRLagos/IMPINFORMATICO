<?php

namespace App\Http\Controllers\ModuloSeguridad;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::get('http://localhost:3000/SHOW_USUARIOS/GETALL_USUARIOS');
        $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response2 = Http::get('http://localhost:3000/SHOW_ROLES');
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
        // Obtenter el token generado y guardado en la sesión
        $sessionToken = $request->session()->get('generated_token');
        $Usuario = $request->all();

        $res = Http::post("http://localhost:3000/INS_USUARIO/USUARIO", $Usuario,[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);

        return redirect(route('Usuario.index'))->with('success', 'Datos ingresados con éxito.');
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
