<?php

namespace App\Http\Controllers\ModuloPersonas;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         // Obtenter el token generado y guardado en la sesión
        $sessionToken = $request->session()->get('generated_token');
        $response = Http::get('http://localhost:3000/SHOW_DEPARTAMENTO/DEPARTAMENTO_ACTIVO',[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
    
        // Convierte los datos JSON a un array asociativo
        $Departamento = json_decode($data, true);
    
        return view('modpersonas.departamento')->with('ResulDepartamento', $Departamento);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function indexEliminados(Request $request)
    {
         // Obtenter el token generado y guardado en la sesión
         $sessionToken = $request->session()->get('generated_token');
        $response = Http::get('http://localhost:3000/SHOW_DEPARTAMENTO/DEPARTAMENTO_ELIMINADO',[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
    
        // Convierte los datos JSON a un array asociativo
        $DepartamentoEliminado = json_decode($data, true);
    
        return view('modpersonas.departamentosEliminados')->with('ResulDepartamentoEliminado', $DepartamentoEliminado);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'NOM_DEPARTAMENTO' => 'required|unique:departamentos,NOM_DEPARTAMENTO|max:255',
        ], [
            'NOM_DEPARTAMENTO.unique' => 'El departamento ya existe',
            'NOM_DEPARTAMENTO.required' => 'El nombre del departamento es obligatorio.',
        ]);

         // Obtenter el token generado y guardado en la sesión
         $sessionToken = $request->session()->get('generated_token');
        $Departamento = $request->all();

        $res = Http::post("http://localhost:3000/INS_DEPARTAMENTO/DEPARTAMENTO", $Departamento,[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);

        return redirect(route('Departamento.index'))->with('success', 'Registro ingresado con éxito.');
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
    public function activar(Request $request)
    {
         // Obtenter el token generado y guardado en la sesión
         $sessionToken = $request->session()->get('generated_token');
        $act_departamento = Http::put('http://localhost:3000/ACT_DESACT_DEPARTAMENTO/ACTIVAR_DEPARTAMENTO/'.$request->input("COD_DEPARTAMENTO"),[
            "COD_DEPARTAMENTO" => $request->input('COD_DEPARTAMENTO'),
        ],[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        
        return redirect(route('Departamento.index'))->with('success', 'La actualización se ha realizado con éxito.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'NOM_DEPARTAMENTO' => 'required|string|max:50',
        ]);
    
        // Verificar si ya existe una sucursal con el mismo nombre
        $existingSucursal = DB::table('DEPARTAMENTOS')
            ->where('NOM_DEPARTAMENTO', $request->input('NOM_DEPARTAMENTO'))
            ->where('COD_DEPARTAMENTO', '!=', $request->input('COD_DEPARTAMENTO')) // Excluir la sucursal actual
            ->first();
    
        // Si existe, mostrar mensaje de error y redirigir
        if ($existingSucursal) {
            return redirect()->back()->withErrors(['NOM_DEPARTAMENTO' => 'Ya existe un departamento con este nombre.']);
        }

        $upt_departamento = Http::put('http://localhost:3000/UPD_DEPARTAMENTO/DEPARTAMENTO/'.$request->input("COD_DEPARTAMENTO"),[
            "COD_DEPARTAMENTO" => $request->input('COD_DEPARTAMENTO'),
            "NOM_DEPARTAMENTO" => $request->input("NOM_DEPARTAMENTO"),
        ]);
        
        return redirect(route('Departamento.index'))->with('success', 'La actualización se ha realizado con éxito.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function desactivar(Request $request)
    {
         // Obtenter el token generado y guardado en la sesión
         $sessionToken = $request->session()->get('generated_token');
        $desact_departamento = Http::put('http://localhost:3000/ACT_DESACT_DEPARTAMENTO/ELIMINAR_DEPARTAMENTO/'.$request->input("COD_DEPARTAMENTO"),[
            "COD_DEPARTAMENTO" => $request->input('COD_DEPARTAMENTO'),
        ],[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        
        return redirect(route('Departamento.index'))->with('success', 'La actualización se ha realizado con éxito.');
    }
}
