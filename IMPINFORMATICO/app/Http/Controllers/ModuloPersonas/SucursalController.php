<?php
namespace App\Http\Controllers\ModuloPersonas;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Http\Response;

use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\DB;

class SucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtenter el token generado y guardado en la sesión
        $sessionToken = $request->session()->get('generated_token');
        $response = Http::get('http://localhost:3000/SHOW_SUCURSAL/GETALL_SUCURSAL/2',[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
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
        $request->validate([
            'NOM_SUCURSAL' => 'required|unique:SUCURSALES,NOM_SUCURSAL|max:50 ',
        ], [
            'NOM_SUCURSAL.unique' => 'La sucursal ya existe en la base de datos.',
            'NOM_SUCURSAL.required' => 'El nombre del departamento es obligatorio.',
        ]);
            $Sucursal = $request->all();
    
            $res = Http::post("http://localhost:3000/INS_SUCURSAL/SUCURSAL", $Sucursal,[
              
            ]);
    
            return redirect(route('Sucursal.index'))->with('success', 'Datos ingresados con éxito.');
    
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
        'NOM_SUCURSAL' => 'required|string|max:50',
        'DES_SUCURSAL' => 'required|string|max:50',
    ]);

    // Verificar si ya existe una sucursal con el mismo nombre
    $existingSucursal = DB::table('SUCURSALES')
        ->where('NOM_SUCURSAL', $request->input('NOM_SUCURSAL'))
        ->where('COD_SUCURSAL', '!=', $request->input('COD_SUCURSAL')) // Excluir la sucursal actual
        ->first();

    // Si existe, mostrar mensaje de error y redirigir
    if ($existingSucursal) {
        return redirect()->back()->withErrors(['NOM_SUCURSAL' => 'Ya existe una sucursal con este nombre.']);
    }

        $upd_sucursal = Http::put('http://localhost:3000/UPD_SUCURSAL/SUCURSAL/'.$request->input("COD_SUCURSAL"), [
            "COD_SUCURSAL" => $request->input('COD_SUCURSAL'),
            "NOM_SUCURSAL" => $request->input("NOM_SUCURSAL"),
            "DES_SUCURSAL" => $request->input("DES_SUCURSAL"),
        ]);

        return redirect(route('Sucursal.index'))->with('success', 'La actualización se ha realizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function desactivar(Request $request)
    {
         // Obtenter el token generado y guardado en la sesión
         $sessionToken = $request->session()->get('generated_token');
        $desact_departamento = Http::put('http://localhost:3000/ACT_DESACT_SUCURSAL/ELIMINAR_SUCURSAL/'.$request->input("COD_SUCURSAL"),[
            "COD_SUCURSAL" => $request->input('COD_SUCURSAL'),
        ],[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        
        return redirect(route('Sucursal.index'))->with('success', 'La actualización se ha realizado con éxito.');
    }

    public function activar(Request $request)
    {
         // Obtenter el token generado y guardado en la sesión
         $sessionToken = $request->session()->get('generated_token');
        $act_departamento = Http::put('http://localhost:3000/ACT_DESACT_SUCURSAL/ACTIVAR_SUCURSAL/'.$request->input("COD_SUCURSAL"),[
            "COD_SUCURSAL" => $request->input('COD_SUCURSAL'),
        ],[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        
        return redirect(route('Sucursal.index'))->with('success', 'La actualización se ha realizado con éxito.');
    }
    public function indexEliminados(Request $request)
    {
         // Obtenter el token generado y guardado en la sesión
         $sessionToken = $request->session()->get('generated_token');
        $response = Http::get('http://localhost:3000/SHOW_SUCURSAL/GETALL_SUCURSAL2/2',[
            'headers' => [
                'Authorization' => 'Bearer ' . $sessionToken,
            ],
        ]);
        $data = $response->getBody()->getContents(); // Obtiene el cuerpo de la respuesta
    
        // Convierte los datos JSON a un array asociativo
        $SucursalEliminado = json_decode($data, true);
    
        return view('modpersonas.SucursalesEliminados')->with('ResulSucursalEliminado', $SucursalEliminado);
    }
}
