<?php

namespace App\Http\Controllers\ModuloReportes;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EstadisticaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response1 = Http::get('http://localhost:3000/SHOW_ESTADISTICA/GET_TIPO_CONTRATO');
        $data1 = $response1->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response2 = Http::get('http://localhost:3000/SHOW_ESTADISTICA/GET_DEPARTAMENTO_EMPRESA');
        $data2 = $response2->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response3 = Http::get('http://localhost:3000/SHOW_ESTADISTICA/GET_SEXO_EMPLEADO');
        $data3 = $response3->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response4 = Http::get('http://localhost:3000/SHOW_ESTADISTICA/GET_SUCURSAL');
        $data4 = $response4->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response5 = Http::get('http://localhost:3000/SHOW_ESTADISTICA/TOTAL_SUCURSALES');
        $data5 = $response5->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response6 = Http::get('http://localhost:3000/SHOW_ESTADISTICA/TOTAL_USUARIOS');
        $data6 = $response6->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
        $response7 = Http::get('http://localhost:3000/SHOW_ESTADISTICA/TOTAL_EMPLEADOS');
        $data7 = $response7->getBody()->getContents(); // Obtiene el cuerpo de la respuesta

        // Convierte los datos JSON a un array asociativo
        $Contrato = json_decode($data1, true);
        $Usuario = json_decode($data2, true);
        $Genero = json_decode($data3, true);
        $Sucursal = json_decode($data4, true);
        $TotalSucursal = json_decode($data5, true);
        $TotalUsuario = json_decode($data6, true);
        $TotalEmpleado = json_decode($data7, true);
    
        return view('modreportes.estadistica')->with('ResulContrato', $Contrato)->with('ResulUsuario', $Usuario)->with('ResulGenero', $Genero)->with('ResulSucursal', $Sucursal)->with('ResulTotalSucursal', $TotalSucursal)->with('ResulTotalUsuario', $TotalUsuario)->with('ResulTotalEmpleado', $TotalEmpleado);
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
    public function edit()
    {
        $response = Http::get('http://localhost:3000/SHOW_ESTADISTICA/GET_TIPO_CONTRATO');
        $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
    
        // Convierte los datos JSON a un array asociativo
        $Sucursal = json_decode($data, true);
    
        return view('admin.admin')->with('ResulSucursal', $Sucursal);
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

