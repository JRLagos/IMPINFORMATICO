<?php

namespace App\Http\Controllers\ModuloSeguridad;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class BitacoraController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost:3000/Bitacora');
        $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
    
        // Convierte los datos JSON a un array asociativo
        $Bitacora  = json_decode($data, true);
    
        return view('modseguridad.bitacora')->with('Resulbitacora', $Bitacora);
    }
}
