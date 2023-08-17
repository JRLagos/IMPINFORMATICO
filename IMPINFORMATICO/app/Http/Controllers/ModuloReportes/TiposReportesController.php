<?php

namespace App\Http\Controllers\ModuloReportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TiposReportesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::get('http://localhost:3000/Reportes?accion=TIPOS_REPORTES');
        $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
    
        // Convierte los datos JSON a un array asociativo
        $TipReportes  = json_decode($data, true);
    
        return view('modreportes.tiporeportes')->with('ResulTipReportes', $TipReportes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $usuario = $request->session()->get('usuario');

                    // Obtener todos los usuarios desde la API
                    $url = 'http://localhost:3000/SHOW_USUARIOS/GETALL_USUARIOS';
                    $response = Http::get($url);
                    $jsonContent = $response->json();
                    // Buscar el código de usuario correspondiente al nombre de usuario en $jsonContent
                    $codigoUsuario = null;
                    foreach ($jsonContent as $user) {
                        if ($user['NOM_USUARIO'] === $usuario) {
                            $codigoUsuario = $user['COD_USUARIO'];
                            break;
                        }
                    }

                    // Asignar el código de usuario a $Reportes
                    $TipReportes = $request->all();
                    $TipReportes['PB_COD_USUARIO'] = $codigoUsuario;

                    // Guardar el valor de PB_COD_USUARIO en una variable de sesión
                    $request->session()->put('PB_COD_USUARIO', $codigoUsuario);
                    dd('Datos a enviar a la API:', $Reportes);
        // Validar los campos recibidos del formulario de creación
        $request->validate([
    
        ]);

        // Obtener los datos del formulario
       
        //dd('Datos a enviar a la API:', $TipReportes);
        // Realizar la solicitud POST a la API para guardar el nuevo registro
        $res = Http::post("http://localhost:3000/InsReportes/Tipos_Reportes", $TipReportes);
        return redirect()->route('TiposReportes.index');
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Obtener los datos del formulario
   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}