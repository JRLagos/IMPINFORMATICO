<?php

namespace App\Http\Controllers\ModuloSeguridad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class ContraPerfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
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
        //
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
    public function UpdPerfilContra(Request $request) {
        $ContraPerfil=session('credenciales');

        // Recuperar los valores del formulario
        $CONTRASENA = Hash::make($request->input('CONTRASENA')); // Hashear la contraseña
    
 
 
        // Validar los campos del formulario
        $validator = Validator::make($request->all(), [
            'CONTRASENA' => ['required', 'string', 'min:5', 'max:12']
           // Asegúrate de ajustar el nombre del campo en el formulario
            // ... otras reglas de validación para otros campos ...
        ]);
   
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
 
   
        // Realizar el request HTTP
        $urlUpUsu = 'http://localhost:3000/USUARIOS';
   
        $responseUpdateUsu = Http::put($urlUpUsu, [
            "COD_ROL" => $ContraPerfil["COD_ROL"],
            "NOM_USUARIO" => $ContraPerfil["NOM_USUARIO"],
            "CONTRASENA" => $CONTRASENA,
            "ESTADO" => $ContraPerfil["IND_USUARIO"],
            "PRE_CONTESTADAS" =>$ContraPerfil["PRE_CONTESTADAS"],
            "COR_ELECTRONICO" =>$ContraPerfil["EMAIL"],
        ]);
   
       // Procesar la respuesta según tus necesidades
       if ($responseUpdateUsu->successful()) {
       // El request se realizó correctamente
       return redirect(route('Perfil.index'))->with('success', 'Actualización exitosa');
    } else {
    // El request falló
    return redirect(route('Perfil.index'))->with('error', 'Error al actualizar');
}

}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
