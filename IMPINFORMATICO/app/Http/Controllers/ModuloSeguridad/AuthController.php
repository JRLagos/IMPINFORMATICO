<?php

namespace App\Http\Controllers\ModuloSeguridad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function ShowLogin(){return view('modseguridad.Login');}
    //
    public function Logout(){

        //Variables de sesión olvidando sus valores 
        session()->forget('credenciales');
        session()->forget('nombreRol');
        session()->forget('permisos');
        session()->forget('objetos');
    
        return view('modseguridad.Login');}
    //
    public function ShowMenuRecuperar(){return view('modseguridad.recuperar');}
    //
    public function ShowPreguntas(){return view('modseguridad.preguntas');}
    //
    public function GuardarPreguntas(){return view('modseguridad.preguntas_usuario');}
    //
    public function ShowRecuperar(){return view('modseguridad.contrasena');}
    //
    public function ShowCorreoContrasena(){return view('modseguridad.correo');}

    public function SendLogin(Request $request){
    // Obtener el valor actual del contador de intentos fallidos de la sesión
    $intentosFallidos = $request->session()->get('intentos_fallidos', 0);

    $usuario = $request->input('usuario');
    $contrasena = $request->input('contrasena');

    $urlToken = 'http://localhost:3000/auths/auth'; // Cambiar la URL a la ruta de generación de token
    $urlParametros = 'http://localhost:3000/SHOW_USUARIOS/SEGURIDAD_PARAMETROS';
    $url_CT = 'http://localhost:3000/SHOW_USUARIOS/SEGURIDAD_CONTRASENAS_TEMPORALES';
    $responseParametros = Http::get($urlParametros);
    $response_CT=Http::get($url_CT);
    $responseToken = Http::post($urlToken, [
        'usuario' => $usuario,
        'contraseña' => $contrasena
    ]);

    if ($responseToken->status() === 200) {
        $token = $responseToken->json()['token'];
        $request->session()->put('generated_token', $token);

    }

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
                 if ($user['NOM_USUARIO'] === $usuario) {
                    if ($user['IND_USUARIO'] === 'DISABLED') {
                // El usuario está "DISABLED", mostrar un mensaje de error y redirigir al login
                Session::flash('error', 'Tu cuenta está bloqueada. Contacta al administrador.');
                return view('modseguridad.Login');
            } else if ($user['IND_USUARIO'] === 'NUEVO') {
                // El usuario es "NUEVO", redirigir a la vista de preguntas de seguridad
                // Credenciales válidas, restablecer el contador de intentos fallidos
                $request->session()->forget('intentos_fallidos');
                $credencialesCorrectas = true;
                $request->session()->put('usuario', $usuario);
                $request->session()->put('credenciales', $user);
                return view('modseguridad.preguntas_usuario');
            } 
        } 
    }

    
            // Iterar por los usuarios para buscar coincidencias de usuario y contraseña
            foreach ($jsonContentUsuarios as $user) {

                // Verificar si el usuario tiene una contraseña temporal activa
                $url_CT_usuario = 'http://localhost:3000/SHOW_USUARIOS/SEGURIDAD_CONTRASENAS_TEMPORALES';
                $response_CT_usuario = Http::get($url_CT_usuario);

                if ($response_CT_usuario->status() === 200) {
                    $jsonContentCT_usuario = $response_CT_usuario->json();
                
                    foreach ($jsonContentCT_usuario as $contrasenaTemporal) {
                        if ($contrasenaTemporal['CONTRASENA'] === $contrasena &&
                            strtotime($contrasenaTemporal['FEC_EXPIRACION']) > time()) {
                
                            // El usuario tiene una contraseña temporal activa, redirigir a la página
                            $request->session()->forget('intentos_fallidos');
                            $credencialesCorrectas = true;
                            $request->session()->put('usuario', $usuario);
                            $request->session()->put('credenciales', $user);
                
                            // Obtener el nombre del rol del usuario
                            $urlRoles = 'http://localhost:3000/SHOW_USUARIOS/SEGURIDAD_ROLES';
                            $responseRoles = Http::get($urlRoles);
                
                            if ($responseRoles->status() === 200) {
                                $roles = $responseRoles->json();
                                $nombreRol = null;
                
                                foreach ($roles as $rol) {
                                    if ($rol['COD_ROL'] === $user['COD_ROL']) {
                                        $nombreRol = $rol['NOM_ROL'];
                                        break;
                                    }
                                }
                
                                if ($nombreRol) {
                                    $request->session()->put('nombreRol', $nombreRol);
                                }
                            }
                
                            // Obtener los permisos del usuario con el mismo código de rol
                            $urlPermisos = 'http://localhost:3000/SHOW_USUARIOS/SEGURIDAD_PERMISOS';
                            $responsePermisos = Http::get($urlPermisos);
                
                            if ($responsePermisos->status() === 200) {
                                $permisos = $responsePermisos->json();
                
                                // Filtrar los permisos por el mismo código de rol del usuario
                                $codigoRolUsuario = $user['COD_ROL'];
                                $permisosFiltrados = array_filter($permisos, function ($permiso) use ($codigoRolUsuario) {
                                    return $permiso['COD_ROL'] === $codigoRolUsuario;
                                });
                
                                // Almacenar los permisos filtrados en la sesión
                                $request->session()->put('permisos', $permisosFiltrados);
                            }
                
                            // Obtener los registros de seguridad_objetos
                            $urlObjetos = 'http://localhost:3000/SHOW_USUARIOS/SEGURIDAD_OBJETOS';
                            $responseObjetos = Http::get($urlObjetos);
                
                            if ($responseObjetos->status() === 200) {
                                $objetos = $responseObjetos->json();
                
                                // Almacenar los objetos en la sesión
                                $request->session()->put('objetos', $objetos);
                            }
                
                            return redirect()->route('Esta.edit'); // O la página que desees permitir acceso

                        }
                    }
                }
                
                if ($user['NOM_USUARIO'] === $usuario && Hash::check($contrasena, $user['CONTRASENA']) === false) {
                    // Usuario encontrado, aumentar contador de intentos fallidos
                    $intentosFallidos = $request->session()->get('intentos_fallidos', 0);
                    $credencialesCorrectas=true;
                    $request->session()->put('intentos_fallidos', $intentosFallidos);
                    Session::flash('error', 'Credenciales inválidas. Inténtalo de nuevo.');
                    break;
                    
                }

                if ($user['NOM_USUARIO'] === $usuario && Hash::check($contrasena, $user['CONTRASENA']) && $user['IND_USUARIO'] === 'ENABLED') {
                    // Credenciales válidas, restablecer el contador de intentos fallidos
                    $request->session()->forget('intentos_fallidos');
                    $credencialesCorrectas = true;
                    $request->session()->put('usuario', $usuario);
                    $request->session()->put('credenciales', $user);
                    // Obtener el nombre del rol del usuario
                $urlRoles = 'http://localhost:3000/SHOW_USUARIOS/SEGURIDAD_ROLES';
                $responseRoles = Http::get($urlRoles);

                if ($responseRoles->status() === 200) {
                    $roles = $responseRoles->json();
                    $nombreRol = null;
                
                    foreach ($roles as $rol) {
                        if ($rol['COD_ROL'] === $user['COD_ROL']) {
                            $nombreRol = $rol['NOM_ROL'];
                            break;
                        }
                    }
                
                    if ($nombreRol) {
                        $request->session()->put('nombreRol', $nombreRol);
                    }
                }
                // Obtener los permisos del usuario con el mismo código de rol
                $urlPermisos = 'http://localhost:3000/SHOW_USUARIOS/SEGURIDAD_PERMISOS';
                $responsePermisos = Http::get($urlPermisos);

                if ($responsePermisos->status() === 200) {
                $permisos = $responsePermisos->json();

                // Filtrar los permisos por el mismo código de rol del usuario
                $codigoRolUsuario = $user['COD_ROL'];
                $permisosFiltrados = array_filter($permisos, function ($permiso) use ($codigoRolUsuario) {
                         return $permiso['COD_ROL'] === $codigoRolUsuario;
                });

                // Almacenar los permisos filtrados en la sesión
                $request->session()->put('permisos', $permisosFiltrados);
                }

                // Obtener los registros de seguridad_objetos
                $urlObjetos = 'http://localhost:3000/SHOW_USUARIOS/SEGURIDAD_OBJETOS';
                $responseObjetos = Http::get($urlObjetos);

                if ($responseObjetos->status() === 200) {
                $objetos = $responseObjetos->json();

                // Almacenar los objetos en la sesión
                $request->session()->put('objetos', $objetos);
            }
                    return view('admin.admin');
                }

                if ($user['NOM_USUARIO'] === $usuario && Hash::check($contrasena, $user['CONTRASENA']) && $user['IND_USUARIO'] === 'NUEVO') {
                    // Credenciales válidas, restablecer el contador de intentos fallidos
                    $request->session()->forget('intentos_fallidos');
                    $credencialesCorrectas = true;
                    $request->session()->put('usuario', $usuario);
                    $request->session()->put('credenciales', $user);
                    return view('modseguridad.preguntas_usuario');
                }


            }
            
            // Verificar si ambas credenciales son incorrectas
            if ($credencialesCorrectas) {
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
                        Session::flash('blocked', 'Tu cuenta está bloqueada. Contacta al administrador.');
                        return view('modseguridad.Login');
                    }
                }
            }
        }

    }
    
    // Mostrar mensaje o redirigir indicando que las credenciales son incorrectas
    Session::flash('error', 'Credenciales inválidas. Inténtalo de nuevo.');
    return view('modseguridad.Login');
}

    //
    public function SendPreguntas(Request $request){

    $credencialesUS=session('credenciales_correctas');
    $pregunta = $request->input('pregunta');
    $respuesta = $request->input('respuesta');

    
    $url ='http://localhost:3000/SHOW_USUARIOS/GETALL_USUARIOS';
    $urlp ='http://localhost:3000/SHOW_USUARIOS/SEGURIDAD_PREGUNTAS_USUARIO';
    $urlUP= 'http://localhost:3000/USUARIOS';
    $response = Http::get($url);

    if ($response->status() === 200) {
        $usuarios = $response->json();
        
        // Buscar el usuario por correo en la respuesta de la API
        $usuarioEncontrado = null;
        foreach ($usuarios as $usuario) {
            if ($usuario['NOM_USUARIO'] === $credencialesUS['NOM_USUARIO']) {
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
                        return view('modseguridad.contrasena');
                    }
                }

                $responseUP = Http::put($urlUP, [
                    "COD_ROL" => $usuarioEncontrado['COD_USUARIO'],
                    "NOM_USUARIO" => $usuarioEncontrado['NOM_USUARIO'],
                    "CONTRASENA" => $usuarioEncontrado['CONTRASENA'],
                    "ESTADO" => "DISABLED",
                    "PRE_CONTESTADAS" => $usuarioEncontrado['PRE_CONTESTADAS'],
                    "COR_ELECTRONICO" => $usuarioEncontrado['EMAIL']
                ]);

                if ($responseUP->successful()) {
                    // Usuario bloqueado exitosamente, redirigir con mensaje de error
                    return view('modseguridad.preguntas', ['error' => 'Respuesta incorrecta. Tu cuenta ha sido bloqueada.']);
                } else {
                    // Error al bloquear el usuario, redirigir con mensaje de error
                    return view('modseguridad.preguntas', ['error' => 'Error al bloquear la cuenta de usuario']);
                }
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
    $usuarioEncontrado = session('credenciales_correctas');
    // Realizar la solicitud GET para obtener los parámetros de seguridad

    // Verificar si los datos del usuario están disponibles
    if ($usuarioEncontrado) {
        // Validar que las contraseñas coincidan
        $nuevaContrasenia = $request->input('nueva_contrasenia');
        $confirmarContrasenia = $request->input('confirmar_contrasenia');
        $urlParametros = 'http://localhost:3000/SHOW_USUARIOS/SEGURIDAD_PARAMETROS';
        $responseParametros = Http::get($urlParametros);

        

        if ($responseParametros->successful()) {
            $parametros = $responseParametros->json();
    

            // Buscar los valores de min_contrasena y max_contrasena en el array
            $minContrasena = null;
            $maxContrasena = null;
    
            
            foreach ($parametros as $parametro) {
                if ($parametro['DES_PARAMETRO'] === 'MIN_CONTRASENA') {
                    $minContrasena = intval($parametro['DES_VALOR']);
                } elseif ($parametro['DES_PARAMETRO'] === 'MAX_CONTRASENA') {
                    $maxContrasena = intval($parametro['DES_VALOR']);
                }

                // Si ambos valores se han encontrado, salir del bucle
                if ($minContrasena !== null && $maxContrasena !== null) {
                    
                    break;
                }
            }


            


            // Validar longitud mínima y máxima de la contraseña
        if (strlen($nuevaContrasenia) < $minContrasena || strlen($nuevaContrasenia) > $maxContrasena) {
                return view('modseguridad.contrasena');
                
        }
            
        } else {
            // Error al obtener los parámetros, redirigir con mensaje de error
            return view('modseguridad.contrasena');
        }



        if ($nuevaContrasenia !== $confirmarContrasenia) {
            // Las contraseñas no coinciden, redirigir con mensaje de error
            return view('modseguridad.contrasena', ['error' => 'Las contraseñas no coinciden']);
        }

        // Validar que la contraseña no sea igual al nombre de usuario
        if ($nuevaContrasenia === $usuarioEncontrado['NOM_USUARIO']) {
            // Contraseña igual al nombre de usuario, redirigir con mensaje de error
            return view('modseguridad.contrasena', ['error' => 'La contraseña no puede ser igual al nombre de usuario']);
        }

        // Validar que la nueva contraseña no sea igual a la contraseña anterior
        if ($nuevaContrasenia === $usuarioEncontrado['CONTRASENA']) {
            // Contraseña igual a la contraseña anterior, redirigir con mensaje de error
            return view('modseguridad.contrasena', ['error' => 'La nueva contraseña no puede ser igual a la contraseña anterior']);
        }



        // Validar robustez de la contraseña
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{' . $minContrasena . ',}$/';
         if (!preg_match($pattern, $nuevaContrasenia)) {
        return view('modseguridad.contrasena', ['error' => 'La contraseña debe cumplir con los requisitos de robustez']);
        }


        // Aplicar el hash a la nueva contraseña
        $nuevaContraseniaHashed = Hash::make($nuevaContrasenia);


        // Construir el cuerpo de la solicitud en formato JSON
        $nuevosDatos = [
            "COD_ROL" => $usuarioEncontrado['COD_USUARIO'],
            "NOM_USUARIO" => $usuarioEncontrado['NOM_USUARIO'],
            "CONTRASENA" => $nuevaContraseniaHashed,
            "ESTADO" => "ENABLED",
            "PRE_CONTESTADAS" => $usuarioEncontrado['PRE_CONTESTADAS'],
            "COR_ELECTRONICO" => $usuarioEncontrado['EMAIL']
        ];

        // Realizar la solicitud PUT a la API para actualizar la contraseña
        $url = 'http://localhost:3000/USUARIOS';
        $url_ins_con= 'http://localhost:3000/INS_USUARIO/SEGURIDAD_HISTORIAL_CONTRASENAS';
        $response_ins= Http::post($url_ins_con, [
            "NOM_ROL" => "d",
            "DES_ROL" => "d",
            "COD_ROL" => 2,
            "NOM_USUARIO" => "RLagos",
            "CONTRASENA" => "Roberto2023",
            "IND_USUARIO" => "ENABLED",
            "PRE_CONTESTADAS" => 3,
            "EMAIL" => "@AAAA",
            "COD_USUARIO" => $usuarioEncontrado['COD_USUARIO'],
            "CONTRASENA_HIST" => $usuarioEncontrado['CONTRASENA'],
            "NOM_OBJETO" => "ddd",
            "DES_OBJETO" => "ddff",
            "TIP_OBJETO" => "sdd",
            "COD_OBJETO" => 1,
            "PER_INSERTAR" => "f",
            "PER_ELIMINAR" => "f",
            "PER_ACTUALIZAR" => "d",
            "PER_CONSULTAR" => "d",
            "DES_PARAMETRO" => "f",
            "DES_VALOR" => "dsd",
            "COD_PARAMETRO" => 5,
            "FEC_CREACION" => "2023-9-15",
            "FEC_MODIFICACION" => "2023-9-15",
            "DES_PREGUNTA" => "2023-9-15",
            "COD_PREGUNTA" => 2,
            "DES_RESPUESTA" => "2023-9-15",
            "NOM_PERSONA" => "Roberto",
            "APE_PERSONA" => "Coello",
            "DNI_PERSONA" => 1111111111111,
            "RTN_PERSONA" => 1111111111111111,
            "TIP_TELEFONO" => "FIJO",
            "NUM_TELEFONO" => 12345678,
            "SEX_PERSONA" => "MASCULINO",
            "EDAD_PERSONA" => 23,
            "FEC_NAC_PERSONA" => "2023-9-15",
            "LUG_NAC_PERSONA" => "La Venta, F.M.",
            "IND_CIVIL" => "SOLTERO",
            "PES_PERSONA" => 180,
            "EST_PERSONA" => 1.75,
            "FOTO_PERSONA" => "c//",
            "CORREO_ELECTRONICO" => "Corre@",
            "DES_CORREO" => "gmail",
            "NIV_ESTUDIO" => "primaria",
            "NOM_CENTRO_ESTUDIO" => "Gilda Lagos",
            "COD_MUNICIPIO" => 8,
            "DES_DIRECCION" => "La Venta, Centro"
        ]
        );
        $response = Http::put($url, $nuevosDatos);

        // Verificar la respuesta de la API y redirigir según sea necesario
        if ($response->successful() && $response_ins->successful()) {
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

    // Obtener todos los datos del formulario
    $formData = $request->all();

    // Verificar si algún campo está vacío o no ha sido ingresado
        foreach ($formData as $key => $value) {
             if (empty($value)) {
            // Si algún campo está vacío, redirige de nuevo al formulario de registro con un mensaje de error
               return view('modseguridad.registro');
        }
    }

        // Definir reglas de validación
        $rules = [
            'nombre' => 'required|max:15',
            'apellido' => 'required|max:15',
            'correo' => 'required|email|max:100',
            'contrasenia' => 'required|min:5|max:12',
            'usuario' => 'required|alpha_dash|max:20',
            'dni' => 'required|max:13',
            'rtn' => 'max:14',
            'tipo_telefono' => 'required',
            'numero_telefono' => 'max:8',
            'sexo' => 'required',
            'edad' => 'required|integer|min:1|max:120',
            'fecha_nacimiento' => 'required|date|before_or_equal:' . now()->format('Y-m-d'),
            'lugar_nacimiento' => 'required|max:50',
            'estado_civil' => 'required',
            'peso' => 'numeric|nullable|min:0|max:999',
            'estatura' => 'numeric|nullable|min:0|max:999',
        ];
        

    // Validar los datos
    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        // Redirigir de nuevo al formulario de registro con mensajes de error
        return view('modseguridad.registro');
    }

    
        $nombre = $request->input('nombre');
        $apellido = $request->input('apellido');
        $correo = $request->input('correo');
        $contrasenia = $request->input('contrasenia');
        $newUser = strtoupper($request->input('usuario'));
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

        //
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            // El formato del correo electrónico no es válido, puedes mostrar un mensaje de error o redireccionar
        
            return view('modseguridad.registro');
        }

        $contraseniaCifrada = Hash::make($contrasenia);

        // Después de la validación de contraseña
        $uppercase = preg_match('@[A-Z]@', $contrasenia);
        $number    = preg_match('@[0-9]@', $contrasenia);
        $specialChar = preg_match('/[!@#$%^&*()\[\]{};:,<.>\-_+=]/', $contrasenia);

        $isStrongPassword = $uppercase && $number && $specialChar;

        if (!$isStrongPassword) {
        // Contraseña no cumple con los criterios de robustez
        return view('modseguridad.registro', ['contraseniaError' => true]);
        }
    
    // Resto de tu código para guardar el usuario y redireccionar


        // Aquí puedes realizar la validación y procesamiento de los datos ingresados
        // y luego realizar la inserción en la base de datos utilizando la URL proporcionada
    
        $url = 'http://localhost:3000/INS_USUARIO/USUARIO';
        $response = Http::post($url, [
            "NOM_ROL" => null,
    "DES_ROL" => null,
    "COD_ROL" => 2,
    "NOM_USUARIO" => $newUser,
    "CONTRASENA" => $contraseniaCifrada,
    "IND_USUARIO" => 'NUEVO',
    "PRE_CONTESTADAS" => 0,
    "EMAIL" => $correo,
    "COD_USUARIO" => null,
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
    "FOTO_PERSONA" => null,
    "CORREO_ELECTRONICO" => $correo,
    "DES_CORREO" => null,
    "NIV_ESTUDIO" => null,
    "NOM_CENTRO_ESTUDIO" => 'nada',
    "COD_MUNICIPIO" => null,
    "DES_DIRECCION" => 'nada'
        ]);
    
    
        if ($response ->successful()) {
            // Inserción exitosa, redireccionar o mostrar mensaje de éxito
            return view('modseguridad.Login');
        } elseif($response->failed()) {
            // Inserción fallida, redireccionar o mostrar mensaje de error
            return view('modseguridad.registro');
        }


    }

    public function SendPreguntasSecretas(Request $request){
      
        $credenciales = $request->session()->get('credenciales');

        $pregunta = $request->input('pregunta');
        $respuesta= $request->input('respuesta');
        $contrasenaNueva= $request->input('nueva_contrasenia');

        // Validar contraseña según tus requisitos
    $minLength = 5;
    $maxLength = 12;
    if (
        strlen($contrasenaNueva) < $minLength ||
        strlen($contrasenaNueva) > $maxLength ||
        !preg_match('/[A-Z]/', $contrasenaNueva) ||   // Al menos una mayúscula
        !preg_match('/[!@#$]/', $contrasenaNueva) ||  // Al menos un caracter especial
        !preg_match('/[0-9]/', $contrasenaNueva)      // Al menos un número
    ) {
        // Mostrar mensaje de error o realizar alguna acción
        return view('modseguridad.preguntas_usuario');
    }



        $contrasenaNuevaHashed = Hash::make($contrasenaNueva);

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
            "CONTRASENA" => $contrasenaNuevaHashed,
            "ESTADO"=>"ENABLED",
            "PRE_CONTESTADAS" => $credenciales['PRE_CONTESTADAS'],
            "COR_ELECTRONICO" => $credenciales['EMAIL']
        ]);


        if ($responsePre->status() === 200 && $responseUp->status() === 200) {
            // Ambas solicitudes exitosas, redirigir a la vista deseada
            return view('modseguridad.Login');
        }
    
        // Si alguna de las solicitudes falló, mostrar mensaje o redirigir a vista de fallo
        return view('modseguridad.preguntas_usuario');


    }


    public function SendPreguntasContra(Request $request){

        $usuarioPreguntas=$request->input('usuario');
        $urlParametros = 'http://localhost:3000/SHOW_USUARIOS/GETALL_USUARIOS';
        $responseUsuarioPreguntas=Http::get($urlParametros);

        if ($responseUsuarioPreguntas->status() === 200) {
            $usuarios = $responseUsuarioPreguntas->json(); // Convierte la respuesta JSON en un array
    
            // Buscar al usuario en la lista
            $usuarioEncontrado = false;
            foreach ($usuarios as $usuario) {
                if ($usuario['NOM_USUARIO'] === $usuarioPreguntas) {
                    $usuarioEncontrado = true;
                    break;
                }
            }
    
            if ($usuarioEncontrado) {
                // Usuario encontrado, redirige a la vista de enviar contraseña por correo
                session(['credenciales_correctas'=> $usuario]);
                return view('modseguridad.preguntas');
            } else {
                // Usuario no encontrado, redirige a la vista de recuperar contraseña
                return view('modseguridad.recuperar');
            }
        }

        return view('modseguridad.recuperar');
    }




    public function SendCorreoContra(Request $request){

        $usuarioCorreo = $request->input('usuario');
        $urlIns = 'http://localhost:3000/INS_USUARIO/SEGURIDAD_CONTRASENAS_TEMPORALES';
        $url = 'http://localhost:3000/SHOW_USUARIOS/GETALL_USUARIOS';
        $urlCT = 'http://localhost:3000/SHOW_USUARIOS/SEGURIDAD_CONTRASENAS_TEMPORALES';
        $urlUpCT = 'http://localhost:3000/SEGURIDAD_CON_TEMP'; // URL para actualizar la contraseña temporal
    
        $response = Http::get($url);
        $responseCT = Http::get($urlCT);
    
        if ($response->status() === 200 && $responseCT->status() === 200) {
            $usuarios = $response->json();
            $contrasenasTemporales = $responseCT->json();
    
            $usuarioEncontrado = false;
            foreach ($usuarios as $usuario) {
                if ($usuario['NOM_USUARIO'] === $usuarioCorreo) {
                    $usuarioEncontrado = true;
    
                    $contrasenaTemporalActiva = false;
                    $contrasenaTemporalExpirada = true;
                    $sinContrasenaTemporal=true;
    
                    foreach ($contrasenasTemporales as $contrasenaTemporal) {
                        if ($contrasenaTemporal['COD_USUARIO'] === $usuario['COD_USUARIO']) {
                            $fechaVencimiento = strtotime($contrasenaTemporal['FEC_EXPIRACION']);
                            $fechaActual = time();
    
                            if ($fechaVencimiento > $fechaActual) {
                                $contrasenaTemporalActiva = true;
                                $sinContrasenaTemporal = false;
                                $contrasenaTemporalExpirada = false;
                                break;
                            }
                            if($fechaVencimiento < $fechaActual){

                                $contrasenaTemporalExpirada = true;
                                $contrasenaTemporalActiva = false;
                                $sinContrasenaTemporal=false;

                            }
                        }
                    }

                    
                    if ($sinContrasenaTemporal) {
                        // Realizar la solicitud POST para insertar nueva contraseña
                        $correoDestinatario = $usuario['EMAIL'];
                        $contraseniaTemporal = Str::random(10);
                        $responseUp = Http::post($urlIns, [
                            "CONTRASENA" => $contraseniaTemporal,
                            "COD_USUARIO" => $usuario['COD_USUARIO']
                        ]);

                        if ($responseUp->status() === 200) {
                            
                            Mail::raw("Tu contraseña temporal es: $contraseniaTemporal", function ($message) use ($correoDestinatario) {
                                $message->to($correoDestinatario)
                                    ->subject('Contraseña Temporal');});


                            Session::flash('success', 'El correo se ha enviado exitosamente.');

                            return view('modseguridad.Login');
                        } else {
                            return view('modseguridad.error');
                        }
                    }
    
                    if ($contrasenaTemporalExpirada) {
                        // Actualizar la contraseña temporal expirada utilizando la URL de PUT
                        $correoDestinatario = $usuario['EMAIL'];
                        $contraseniaTemporal = Str::random(10);
                        $fechaVencimiento = date('Y-m-d H:i:s', strtotime('+1 day'));
            
                        $responseUpdateCT = Http::put($urlUpCT, [
                            "COD_USUARIO" => $usuario['COD_USUARIO'],
                            "CONTRASENA" => $contraseniaTemporal,
                            "FEC_EXPIRACION" => $fechaVencimiento,
                        ]);
            
                        if ($responseUpdateCT->status() === 200) {

                            Mail::raw("Tu contraseña temporal es: $contraseniaTemporal", function ($message) use ($correoDestinatario) {
                                $message->to($correoDestinatario)
                                    ->subject('Contraseña Temporal');});


                            $request->session()->flash('success', 'El correo se ha enviado exitosamente.');
                            return view('modseguridad.Login');
                        } else {
                            return view('modseguridad.error');
                        }
                    } elseif ($contrasenaTemporalActiva) {
                        // Usuario con contraseña temporal activa
                        Session::flash('info', 'Ya tienes una contraseña temporal activa.');
                        return view('modseguridad.correo');
                    }
                }
            }
                
            // Si no se encontró al usuario en la lista
            $request->session()->flash('error', 'El usuario no fue encontrado.');
            return view('modseguridad.correo');
        }
    
        
        return view('modseguridad.correo');

    }

    public function UpdUsuario(Request $request) {
        
        // Recuperar los valores del formulario
        $COD_ROL = $request->input('COD_USUARIO');
        $NOM_USUARIO = $request->input('nombre');
        $CONTRASENA = Hash::make($request->input('contrasena')); // Hashear la contraseña
        $ESTADO = $request->input('estado');
        $PRE_CONTESTADAS = 0;
        $COR_ELECTRONICO = $request->input('email');


        // Validar los campos del formulario
        $validator = Validator::make($request->all(), [
            'contrasena' => ['required', 'string', 'min:5', 'max:12'],
            'COD_USUARIO' => ['required', 'integer'], // Asegúrate de ajustar el nombre del campo en el formulario
            // ... otras reglas de validación para otros campos ...
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

    
        // Realizar el request HTTP
        $urlUpUsu = 'http://localhost:3000/USUARIOS';
    
        $responseUpdateUsu = Http::put($urlUpUsu, [
            "COD_ROL" => $COD_ROL,
            "NOM_USUARIO" => $NOM_USUARIO,
            "CONTRASENA" => $CONTRASENA,
            "ESTADO" => $ESTADO,
            "PRE_CONTESTADAS" => $PRE_CONTESTADAS,
            "COR_ELECTRONICO" => $COR_ELECTRONICO,
        ]);
    
        // Procesar la respuesta según tus necesidades
        // Procesar la respuesta según tus necesidades
       // Procesar la respuesta según tus necesidades
       if ($responseUpdateUsu->successful()) {
       // El request se realizó correctamente
       return redirect(route('Usuarios.index'))->with('success', 'Actualización exitosa');
    } else {
    // El request falló
    return redirect(route('Usuarios.index'))->with('error', 'Error al actualizar');
}


    }

}
