<?php
namespace App\Http\Controllers\ModuloPersonas;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::get('http://localhost:3000/SHOW_SUCURSAL/GETALL_SUCURSAL/2');
        $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
    
        // Convierte los datos JSON a un array asociativo
        $Sucursal = json_decode($data, true);

        return view('modpersonas.sucursal')->with('ResulSucursal', $Sucursal); 
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
        {
            $Sucursal = $request->all();
    
            $res = Http::post("http://localhost:3000/INS_SUCURSAL/SUCURSAL", $Sucursal);
    
            return redirect(route('Sucursal.index'))->with('success', 'Datos ingresados con éxito.');
        }
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
        $upd_sucursal = Http::put('http://localhost:3000/UPD_SUCURSAL/SUCURSAL/'.$request->input("COD_SUCURSAL"),[
            "COD_SUCURSAL" => $request->input('COD_SUCURSAL'),
            "NOM_SUCURSAL" => $request->input("NOM_SUCURSAL"),
            "DES_SUCURSAL" => $request->input("DES_SUCURSAL"),
        ]);
        
        return redirect(route('Sucursal.index'))->with('success', 'La actualización se ha realizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
