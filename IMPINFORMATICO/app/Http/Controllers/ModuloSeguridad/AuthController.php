<?php

namespace App\Http\Controllers\ModuloSeguridad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    //Retorna la vista del inicio de sesión
    public function ShowLogin(){return view('modseguridad.Login');}
    //
    //Preguntas y sus relacionados
    public function ShowPreguntas(){return view('modseguridad.preguntas');}
    //
    public function GuardarPreguntas(){return view('modseguridad.preguntas_usuario');}
    //
    public function ShowRecuperar(){return view('modseguridad.contrasena');}


    public function SendLogin(Request $request){
    // Obtener el valor actual del contador de intentos fallidos de la sesión
    $intentosFallidos = $request->session()->get('intentos_fallidos', 0);

    $usuario = $request->input('usuario');
    $contrasena = $request->input('contrasena');

    $urlParametros = 'http://localhost:3000/SHOW_USUARIOS/SEGURIDAD_PARAMETROS';
    $responseParametros = Http::get($urlParametros);

    // Verificar si la respuesta tiene un código de estado 200 (OK)
    if ($responseParametros->status() === 200) {
        $jsonContentParametros = $responseParametros->json();

        // Buscar el valor del parámetro "ADMIN_INTENTOS_INVALIDOS"
        $adminIntentosInvalidos = 0;
        foreach ($jsonContentParametros as $parametro) {
            if ($parametro['DES_PARAMETRO'] === 'ADMIN_INTENTOS_INVALIDOS') {
                $adminIntentosInvalidos = (int)$parametro['DES_VALOR'];
                break;
            }
        }

        // Realizar la validación de inicio de sesión
        $urlUsuarios = 'http://localhost:3000/SHOW_USUARIOS/GETALL_USUARIOS';
        $responseUsuarios = Http::get($urlUsuarios);

        if ($responseUsuarios->status() === 200) {
            $jsonContentUsuarios = $responseUsuarios->json();
            $credencialesCorrectas = false;

            // Iterar por los usuarios para buscar coincidencias de usuario y contraseña
            foreach ($jsonContentUsuarios as $user) {
                if ($user['NOM_USUARIO'] === $usuario && $user['CONTRASENA'] === $contrasena && $user['IND_USUARIO'] === 'ENABLED') {
                    // Credenciales válidas, restablecer el contador de intentos fallidos
                    $request->session()->forget('intentos_fallidos');
                    $credencialesCorrectas = true;
                    $request->session()->put('usuario', $usuario);
                    $request->session()->put('credenciales', $user);
                    return view('admin.admin');
                }

                if ($user['NOM_USUARIO'] === $usuario && $user['CONTRASENA'] === $contrasena && $user['IND_USUARIO'] === 'NUEVO') {
                    // Credenciales válidas, restablecer el contador de intentos fallidos
                    $request->session()->forget('intentos_fallidos');
                    $credencialesCorrectas = true;
                    $request->session()->put('usuario', $usuario);
                    $request->session()->put('credenciales', $user);
                    return view('modseguridad.preguntas_usuario');
                }


            }

            // Verificar si ambas credenciales son incorrectas
            if (!$credencialesCorrectas) {
                // Incrementar el contador de intentos fallidos en la sesión
                $intentosFallidos++;
                $request->session()->put('intentos_fallidos', $intentosFallidos);

                // Verificar si se supera el límite de intentos fallidos
                if ($intentosFallidos >= $adminIntentosInvalidos) {
                    // Bloquear al usuario: Actualizar el estado del usuario a "DISABLED" en la base de datos
                    $urlBloquearUsuario = 'http://localhost:3000/USUARIOS/';
                    $dataBloquearUsuario = [
                        "COD_ROL" => $user['COD_USUARIO'], // Utilizar el código de rol del usuario
                        "NOM_USUARIO" => $user['NOM_USUARIO'],
                        "CONTRASENA" => $user['CONTRASENA'], // Utilizar la contraseña del usuario
                        "ESTADO" => "DISABLED",
                        "PRE_CONTESTADAS" => 0,
                        "COR_ELECTRONICO" => $user['EMAIL'] // Utilizar el correo electrónico del usuario
                    ];
                    
                    $responseBloquearUsuario = Http::put($urlBloquearUsuario, $dataBloquearUsuario);

                    
                    if ($responseBloquearUsuario->status() === 200) {
                        $intentosFallidos=0;
                        $request->session()->put('intentos_fallidos', $intentosFallidos);
                        return view('modseguridad.LoginBloqueado');
                    }
                }
            }
        }
    }
    
    // Mostrar mensaje o redirigir indicando que las credenciales son incorrectas
    return view('modseguridad.LoginFallido');
}

    //
    public function SendPreguntas(Request $request){

    $correo = $request->input('correo');
    $pregunta = $request->input('pregunta');
    $respuesta = $request->input('respuesta');
    
    $url ='http://localhost:3000/SHOW_USUARIOS/GETALL_USUARIOS';
    $urlp ='http://localhost:3000/SHOW_USUARIOS/SEGURIDAD_PREGUNTAS_USUARIO';
    $response = Http::get($url);

    if ($response->status() === 200) {
        $usuarios = $response->json();
        
        // Buscar el usuario por correo en la respuesta de la API
        $usuarioEncontrado = null;
        foreach ($usuarios as $usuario) {
            if ($usuario['EMAIL'] === $correo) {
                $usuarioEncontrado = $usuario;
                break;
            }
        }

        if ($usuarioEncontrado) {
            // El correo existe en la base de datos, continuar con el flujo
            // Buscar las preguntas de seguridad del usuario basado en el código de usuario
            $responsePreguntas = Http::get($urlp);
            $preguntasUsuario = $responsePreguntas->json();

            // Verificar si el usuario tiene preguntas de seguridad
            if (!empty($preguntasUsuario)) {
                // Buscar la pregunta correspondiente al código de pregunta y verificar la respuesta
                foreach ($preguntasUsuario as $preguntaUsuario) {
                    if ($preguntaUsuario['COD_PREGUNTA'] == $pregunta && $preguntaUsuario['DES_RESPUESTA'] == $respuesta) {
                        // Respuesta correcta, redirigir al usuario a la vista de cambio de contraseña
                        session(['usuarioEncontrado' => $usuarioEncontrado]);
                        return view('modseguridad.contrasena');
                    }
                }

                // Respuesta incorrecta, redirigir con mensaje de error
                return view('modseguridad.preguntas');
            } else {
                // El usuario no tiene preguntas de seguridad registradas, redirigir con mensaje de error
                return view('modseguridad.preguntas');
            }
        } else {
            // El correo no está registrado, redirigir con mensaje de error
            return view('modseguridad.preguntas');
        }
    } else {
        // Error en la respuesta de la API, manejar según tus necesidades
        return view('modseguridad.preguntas');
    }

}
    
    //
    public function SendRecuperar(Request $request){
    // Acceder a los datos del usuario desde la sesión
    $usuarioEncontrado = session('usuarioEncontrado');

    
    // Verificar si los datos del usuario están disponibles
    if ($usuarioEncontrado) {
        // Validar que las contraseñas coincidan
        $nuevaContrasenia = $request->input('nueva_contrasenia');
        $confirmarContrasenia = $request->input('confirmar_contrasenia');

        if ($nuevaContrasenia !== $confirmarContrasenia) {
            // Las contraseñas no coinciden, redirigir con mensaje de error
            return view('modseguridad.contrasena', ['error' => 'Las contraseñas no coinciden']);
        }

        // Construir el cuerpo de la solicitud en formato JSON
        $nuevosDatos = [
            "COD_ROL" => $usuarioEncontrado['COD_USUARIO'],
            "NOM_USUARIO" => $usuarioEncontrado['NOM_USUARIO'],
            "CONTRASENA" => $nuevaContrasenia,
            "ESTADO" => "ENABLED",
            "PRE_CONTESTADAS" => $usuarioEncontrado['PRE_CONTESTADAS'],
            "COR_ELECTRONICO" => $usuarioEncontrado['EMAIL']
        ];

        // Realizar la solicitud PUT a la API para actualizar la contraseña
        $url = 'http://localhost:3000/USUARIOS';
        $response = Http::put($url, $nuevosDatos);

        // Verificar la respuesta de la API y redirigir según sea necesario
        if ($response->successful()) {
            // Contraseña actualizada exitosamente, redirigir a una vista de éxito
            return view('modseguridad.Login');
        } else {
            // Error al actualizar la contraseña, redirigir con mensaje de error
            return view('modseguridad.contrasena', ['error' => 'Error al actualizar la contraseña']);
        }
    } else {
        // Si los datos del usuario no están disponibles en la sesión, redirigir con mensaje de error
        return view('modseguridad.contrasena', ['error' => 'Datos de usuario no disponibles']);
    }

    
}

    //Registro y sus relacionados
    public function ShowRegistro(){return view('modseguridad.registro');}

    public function SendRegistro(Request $request){

        $nombre = $request->input('nombre');
        $apellido = $request->input('apellido');
        $correo = $request->input('correo');
        $contrasenia = $request->input('contrasenia');
        $usuario = strtoupper($request->input('usuario'));
        $dni = $request->input('dni');
        $rtn = $request->input('rtn');
        $tipoTelefono = $request->input('tipo_telefono');
        $numeroTelefono = $request->input('numero_telefono');
        $sexo = $request->input('sexo');
        $edad = $request->input('edad');
        $fechaNacimiento = $request->input('fecha_nacimiento');
        $lugarNacimiento = $request->input('lugar_nacimiento');
        $estadoCivil = $request->input('estado_civil');
        $peso = $request->input('peso');
        $estatura = $request->input('estatura');
    
        // Aquí puedes realizar la validación y procesamiento de los datos ingresados
        // y luego realizar la inserción en la base de datos utilizando la URL proporcionada
    
        $url = 'http://localhost:3000/INS_USUARIO/USUARIO';
        $response = Http::post($url, [
            "NOM_ROL" => 'D',
            "DES_ROL" => 'D',
            "COD_ROL" => 1,
            "NOM_USUARIO" => $usuario,
            "CONTRASENA" => $contrasenia,
            "IND_USUARIO" => "NUEVO",
            "PRE_CONTESTADAS"=>3,
            "EMAIL" => $correo,
            "COD_USUARIO" => 1,
            "CONTRASENA_HIST" => null,
            "NOM_OBJETO" => null,
            "DES_OBJETO" => null,
            "TIP_OBJETO" => null,
            "COD_OBJETO" => null,
            "PER_INSERTAR" => null,
            "PER_ELIMINAR" => null,
            "PER_ACTUALIZAR" => null,
            "PER_CONSULTAR" => null,
            "DES_PARAMETRO" => null,
            "DES_VALOR" => null,
            "COD_PARAMETRO" => null,
            "FEC_CREACION" => null,
            "FEC_MODIFICACION" => null,
            "DES_PREGUNTA" => null,
            "COD_PREGUNTA" => null,
            "DES_RESPUESTA" => null,
            "NOM_PERSONA" => $nombre,
            "APE_PERSONA" => $apellido,
            "DNI_PERSONA" => $dni,
            "RTN_PERSONA" => $rtn,
            "TIP_TELEFONO" => $tipoTelefono,
            "NUM_TELEFONO" => $numeroTelefono,
            "SEX_PERSONA" => $sexo,
            "EDAD_PERSONA" => $edad,
            "FEC_NAC_PERSONA" => $fechaNacimiento,
            "LUG_NAC_PERSONA" => $lugarNacimiento,
            "IND_CIVIL" => $estadoCivil,
            "PES_PERSONA" => $peso,
            "EST_PERSONA" => $estatura,
            "FOTO_PERSONA" => 'a',
            "CORREO_ELECTRONICO" => $correo,
            "DES_CORREO" => null,
            "NIV_ESTUDIO" => null,
            "NOM_CENTRO_ESTUDIO" => 'a',
            "COD_MUNICIPIO" => null,
            "DES_DIRECCION" => 'a'
        ]);
    
    
        if ($response->status() === 200) {
            // Inserción exitosa, redireccionar o mostrar mensaje de éxito
            return view('modseguridad.login');
        } else {
            // Inserción fallida, redireccionar o mostrar mensaje de error
            return view('modseguridad.preguntas');
        }


    }

    public function SendPreguntasSecretas(Request $request){
      
        $credenciales = $request->session()->get('credenciales');

        $pregunta = $request->input('pregunta');
        $respuesta= $request->input('respuesta');
        $contrasenaNueva= $request->input('nueva_contrasenia');

        $urlPre = 'http://localhost:3000/INS_USUARIO/SEGURIDAD_PREGUNTAS_USUARIO';
        $responsePre = Http::post($urlPre, [
            "NOM_ROL" => null,
            "DES_ROL" => null,
            "COD_ROL" => null,
            "NOM_USUARIO" => null,
            "CONTRASENA" => null,
            "IND_USUARIO" => null,
            "PRE_CONTESTADAS"=>null,
            "EMAIL" => null,
            "COD_USUARIO" => $credenciales['COD_USUARIO'],
            "CONTRASENA_HIST" => null,
            "NOM_OBJETO" => null,
            "DES_OBJETO" => null,
            "TIP_OBJETO" => null,
            "COD_OBJETO" => null,
            "PER_INSERTAR" => null,
            "PER_ELIMINAR" => null,
            "PER_ACTUALIZAR" => null,
            "PER_CONSULTAR" => null,
            "DES_PARAMETRO" => null,
            "DES_VALOR" => null,
            "COD_PARAMETRO" => null,
            "FEC_CREACION" => null,
            "FEC_MODIFICACION" => null,
            "DES_PREGUNTA" => null,
            "COD_PREGUNTA" => $pregunta,
            "DES_RESPUESTA" => $respuesta,
            "NOM_PERSONA" => null,
            "APE_PERSONA" => null,
            "DNI_PERSONA" => null,
            "RTN_PERSONA" => null,
            "TIP_TELEFONO" => null,
            "NUM_TELEFONO" => null,
            "SEX_PERSONA" => null,
            "EDAD_PERSONA" => null,
            "FEC_NAC_PERSONA" => null,
            "LUG_NAC_PERSONA" => null,
            "IND_CIVIL" => null,
            "PES_PERSONA" => null,
            "EST_PERSONA" => null,
            "FOTO_PERSONA" => null,
            "CORREO_ELECTRONICO" => null,
            "DES_CORREO" => null,
            "NIV_ESTUDIO" => null,
            "NOM_CENTRO_ESTUDIO" => null,
            "COD_MUNICIPIO" => null,
            "DES_DIRECCION" => null
        ]);

        $urlUp = 'http://localhost:3000/USUARIOS';
        $responseUp = Http::put($urlUp,[
            "COD_ROL" => $credenciales['COD_USUARIO'],
            "NOM_USUARIO" => $credenciales['NOM_USUARIO'],
            "CONTRASENA" => $contrasenaNueva,
            "ESTADO"=>"ENABLED",
            "PRE_CONTESTADAS" => $credenciales['PRE_CONTESTADAS'],
            "COR_ELECTRONICO" => $credenciales['EMAIL']
        ]);


        if ($responsePre->status() === 200 && $responseUp->status() === 200) {
            // Ambas solicitudes exitosas, redirigir a la vista deseada
            return view('modseguridad.login');
        }
    
        // Si alguna de las solicitudes falló, mostrar mensaje o redirigir a vista de fallo
        return view('modseguridad.preguntas_usuario');


    }


}
