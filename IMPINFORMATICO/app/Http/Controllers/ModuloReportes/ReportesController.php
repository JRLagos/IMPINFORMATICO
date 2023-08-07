<?php


namespace App\Http\Controllers\ModuloReportes;
use Auth;
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
        $userId = Auth::id();
        $Reportes = $request->all();
        $Reportes['PB_COD_USUARIO'] = $userId;
        // Imprimir los datos del reporte antes de enviarlos a la API
        dd('Datos del Reporte:', $Reportes);
    
        // Realizar la solicitud HTTP a la API externa
        $res = Http::post("http://localhost:3000/InsReportes/Reportes", $Reportes);
    
        // Imprimir la respuesta de la API después de recibir la respuesta
        dd('Respuesta de la API:', $res->json());
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
