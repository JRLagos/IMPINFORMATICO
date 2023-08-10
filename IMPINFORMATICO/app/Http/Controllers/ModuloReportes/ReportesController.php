<?php


namespace App\Http\Controllers\ModuloReportes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class ReportesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::get('http://localhost:3000/Reportes?accion=REPORTES');
        $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response1 = Http::get('http://localhost:3000/Reportes?accion=TIPOS_REPORTES');
        $data1 = $response1->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
    
        // Convierte los datos JSON a un array asociativo
        $ResulReportes = json_decode($data, true);
        $TipReportes  = json_decode($data1, true);
       

        return view('modreportes.reportes')->with('ResulTipReportes', $TipReportes)->with('ResulReportes', $ResulReportes);
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
                        // Obtener el nombre de usuario desde la variable de sesión
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
                    $Reportes = $request->all();
                    $Reportes['PB_COD_USUARIO'] = $codigoUsuario;

                    // Guardar el valor de PB_COD_USUARIO en una variable de sesión
                    $request->session()->put('PB_COD_USUARIO', $codigoUsuario);
                    //dd('Datos a enviar a la API:', $Reportes);
                    
                    // Realizar la solicitud HTTP a la API externa
                    $res = Http::post("http://localhost:3000/InsReportes/Reportes", $Reportes);
                    return redirect()->route('Reportes.index');
                    // Imprimir la respuesta de la API después de recibir la respuesta
                    //dd('Respuesta de la API:', $res->json());
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