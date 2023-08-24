<?php
namespace App\Http\Controllers\ModuloPersonas;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Http\Response;

class CorreoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtenter el token generado y guardado en la sesión
        $sessionToken = $request->session()->get('generated_token');
        $response = Http::get('http://localhost:3000/SHOW_CORREO/GETALL_CORREO/2',[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response1 = Http::get('http://localhost:3000/SHOW_PERSONA/GETALL_PERSONA/2', [
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        $data1 = $response1->getBody()->getContents(); // Obtiene el cuerpo de la respuesta


        // Convierte los datos JSON a un array asociativo
        $Correo = json_decode($data, true);
        $Persona = json_decode($data1, true);
  
        return view('modpersonas.correo')->with('ResulCorreo', $Correo)->with('ResulPersona', $Persona); 
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
    
    public function update(Request $request)
    {
        // Obtenter el token generado y guardado en la sesión
        $sessionToken = $request->session()->get('generated_token');
        $upd_Correo= Http::put('http://localhost:3000/UPD_CORREO/CORREO/'.$request->input("COD_CORREO"),[
            "COD_CORREO" => $request->input('COD_CORREO'),
            "COD_PERSONA" => $request->input("COD_PERSONA"),
            "CORREO_ELECTRONICO" => $request->input("CORREO_ELECTRONICO"),
            "DES_CORREO" => $request->input("DES_CORREO"),
        ],[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        
        return redirect(route('Correo.index'))->with('success', 'La actualización se ha realizado con éxito.');

    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
