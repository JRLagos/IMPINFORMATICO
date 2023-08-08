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
        // Validar los campos recibidos del formulario de creación
        $request->validate([
    
        ]);

        // Obtener los datos del formulario
        $TipReportes = $request->all();
        dd('Datos a enviar a la API:', $TipReportes);
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
        // Obtener el tipo de reporte por su ID desde la API
        $res = Http::put("http://localhost:3000/ObtReportes/Tipos_Reportes/$id");

        // Verificar si la solicitud fue exitosa y obtener los datos del reporte
        if ($res->successful()) {
            $TipReportes = $res->json(); // Cambiamos la variable a $TipReportes
            // Renderizar la vista de edición con los datos del reporte
            return view('tipos_reportes.edit', compact('TipReportes'));
        } else {
            // Manejar el error si la solicitud no fue exitosa
            // Por ejemplo, redireccionar a una página de error o volver a la página anterior con un mensaje de error
            return redirect()->back()->with('error', 'Error al obtener el reporte para editar.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Obtener los datos del formulario
    $TipReportes = $request->all();

    // Realizar la solicitud PUT a la API para actualizar el registro con el ID proporcionado
    $res = Http::put("http://localhost:3000/UpdReportes/Tipos_Reportes/$id", $TipReportes);

    // Verificar la respuesta de la API y realizar acciones adecuadas (puedes validar la respuesta, manejar errores, etc.)
    if ($res->successful()) {
        // La actualización fue exitosa
        // Puedes agregar un mensaje de éxito a través de la sesión o flash data
        session()->flash('success', 'Reporte actualizado correctamente.');
    } else {
        // La actualización falló
        // Puedes agregar un mensaje de error a través de la sesión o flash data
        session()->flash('error', 'Error al actualizar el reporte.');
    }

    return redirect()->route('TiposReportes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}