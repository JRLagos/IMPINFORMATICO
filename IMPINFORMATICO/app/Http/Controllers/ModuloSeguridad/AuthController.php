<?php

namespace App\Http\Controllers\ModuloSeguridad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    //Retorna la vista del inicio de sesión
    public function ShowLogin(){
        
        return view('modseguridad.Login');
    }

    public function SendLogin(Request $request){

       $usuario = $request->input('usuario');
       $contrasena = $request->input('contrasena');

       $url=$url = 'http://localhost:3000/SHOW_USUARIOS/GETALL_USUARIOS';

       //

       $response=Http::get($url);
    // Verificar si la respuesta tiene un código de estado 200 (OK)
       if ($response->status() === 200) {
        // Utilizar el método json() para obtener el contenido de la respuesta en formato JSON
        $jsonContent = $response->json();

        // Verificar si el arreglo no está vacío
        if (!empty($jsonContent)) {
            // Iterar por los usuarios para buscar coincidencias de usuario y contraseña
            foreach ($jsonContent as $user) {
                // Imprimir los datos del usuario en la consola o página web

                if ($user['NOM_USUARIO'] === $usuario && $user['CONTRASENA'] === $contrasena && $user['IND_USUARIO'] === 'ENABLED') {
                    // Credenciales válidas, realizar acciones adicionales (por ejemplo, iniciar sesión)
                    return view('admin.admin');
                }
            }
        }
    }

    // Credenciales inválidas, mostrar mensaje de error o redirigir a otra vista
    return view('modseguridad.login');
    
    }





    //Preguntas y sus relacionados
    public function ShowPreguntas(){
        return view('modseguridad.preguntas');
    }

    //Registro y sus relacionados
    public function ShowRegistro(){
        return view('modseguridad.registro');
    }


}
