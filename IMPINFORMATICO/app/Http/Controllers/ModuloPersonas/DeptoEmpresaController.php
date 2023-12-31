<?php

namespace App\Http\Controllers\ModuloPersonas;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Http\Response;

use Illuminate\Support\Facades\DB;

class DeptoEmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         // Obtenter el token generado y guardado en la sesión
        $sessionToken = $request->session()->get('generated_token');
        $response = Http::get('http://localhost:3000/SHOW_DEPTO_EMPRESA/GETALL_DEPTO_EMPRESA/2',[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
    
        // Convierte los datos JSON a un array asociativo
        $DeptoEmpresa = json_decode($data, true);

        return view('modpersonas.deptoempresa')->with('ResulDeptoEmpresa', $DeptoEmpresa); 
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
        
            $request->validate([
                'NOM_DEPTO_EMPRESA' => 'required|unique:DEPARTAMENTOS_EMPRESA,NOM_DEPTO_EMPRESA|max:255',
            ], [
                'NOM_DEPTO_EMPRESA.unique' => 'El departamento ya existe.',
                'NOM_DEPTO_EMPRESA.required' => 'El nombre del departamento es obligatorio.',
            ]);
            // Obtenter el token generado y guardado en la sesión
            $sessionToken = $request->session()->get('generated_token');
            $DeptoEmpresa = $request->all();
    
            $res = Http::post("http://localhost:3000/INS_DEPTO_EMPRESA/DEPARTAMENTOS_EMPRESA", $DeptoEmpresa,[
                'headers' => [
                    'Authorization' => 'Bearer ' . $sessionToken,
                ],
            ]);
    
            return redirect(route('DeptoEmpresa.index'))->with('success', 'Datos ingresados con éxito.');
        
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
            // Validar la entrada del formulario
    $request->validate([
        'NOM_DEPTO_EMPRESA' => 'required|string|max:50',
        'DES_DEPTO_EMPRESA' => 'required|string|max:50',
    ]);

    // Verificar si ya existe una sucursal con el mismo nombre
    $existingSucursal = DB::table('DEPARTAMENTOS_EMPRESA')
        ->where('NOM_DEPTO_EMPRESA', $request->input('NOM_DEPTO_EMPRESA'))
        ->where('COD_DEPTO_EMPRESA', '!=', $request->input('COD_DEPTO_EMPRESA')) // Excluir la sucursal actual
        ->first();

    // Si existe, mostrar mensaje de error y redirigir
    if ($existingSucursal) {
        return redirect()->back()->withErrors(['NOM_SUCURSAL' => 'Ya existe un Departamento con este nombre.']);
    }

        $upd_municipio = Http::put('http://localhost:3000/UPD_DEPTO_EMPRESA/DEPARTAMENTO EMPRESA/'.$request->input("COD_DEPTO_EMPRESA"),[
            "COD_DEPTO_EMPRESA" => $request->input('COD_DEPTO_EMPRESA'),
            "NOM_DEPTO_EMPRESA" => $request->input("NOM_DEPTO_EMPRESA"),
            "DES_DEPTO_EMPRESA" => $request->input("DES_DEPTO_EMPRESA"),
        ]);
        
        return redirect(route('DeptoEmpresa.index'))->with('success', 'La actualización se ha realizado con éxito.');

    }
    
    public function desactivar(Request $request)
    {
         // Obtenter el token generado y guardado en la sesión
         $sessionToken = $request->session()->get('generated_token');
        $desact_departamento = Http::put('http://localhost:3000/ACT_DESACT_DEPTO_EMPRESA/ELIMINAR_DEPTO_EMPRESA/'.$request->input("COD_DEPTO_EMPRESA"),[
            "COD_DEPTO_EMPRESA" => $request->input('COD_DEPTO_EMPRESA'),
        ],[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        
        return redirect(route('DeptoEmpresa.index'))->with('success', 'La actualización se ha realizado con éxito.');
    }

    public function activar(Request $request)
    {
         // Obtenter el token generado y guardado en la sesión
         $sessionToken = $request->session()->get('generated_token');
        $act_departamento = Http::put('http://localhost:3000/ACT_DESACT_DEPTO_EMPRESA/ACTIVAR_DEPTO_EMPRESA/'.$request->input("COD_DEPTO_EMPRESA"),[
            "COD_DEPTO_EMPRESA" => $request->input('COD_DEPTO_EMPRESA'),
        ],[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        
        return redirect(route('DeptoEmpresa.index'))->with('success', 'La actualización se ha realizado con éxito.');
    }
    public function indexEliminados(Request $request)
    {
         // Obtenter el token generado y guardado en la sesión
         $sessionToken = $request->session()->get('generated_token');
        $response = Http::get('http://localhost:3000/SHOW_DEPTO_EMPRESA/GETALL_DEPTO_EMPRESA2/2',[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
    
        // Convierte los datos JSON a un array asociativo
        $DeptoEmpresaEliminado = json_decode($data, true);
    
        return view('modpersonas.DeptoEmpresaEliminados')->with('ResulDeptoEmpresaEliminado', $DeptoEmpresaEliminado);
    }
}
