<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\ModuloPlanillas\VacacionesController;
use App\Http\Controllers\ModuloPlanillas\HoraExtraController;
use App\Http\Controllers\ModuloPlanillas\PlanillaController;
use App\Http\Controllers\ModuloReportes\ReportesGeneradosController;
use App\Http\Controllers\ModuloReportes\ReportesController;
use App\Http\Controllers\ModuloReportes\TiposReportesController;
use App\Http\Controllers\ModuloReportes\ReportesvistaController;
use App\Http\Controllers\ModuloReportes\ReportesGuardadosController;
use App\Http\Controllers\ModuloPersonas\DepartamentoController;
use App\Http\Controllers\ModuloPersonas\MunicipioController;
use App\Http\Controllers\ModuloPersonas\PersonaController;
use App\Http\Controllers\ModuloReportes\EstadisticaController;
use App\Http\Controllers\ModuloPersonas\EmpleadoController;
use App\Http\Controllers\ModuloSeguridad\AuthController;
use App\Http\Controllers\ModuloPersonas\DireccionController;
use App\Http\Controllers\ModuloPersonas\BancoController;
use App\Http\Controllers\ModuloPersonas\CorreoController;
use App\Http\Controllers\ModuloPersonas\SucursalController;
use App\Http\Controllers\ModuloPersonas\DeptoEmpresaController;
use App\Http\Controllers\ModuloPersonas\EstudioController;
use App\Http\Controllers\ModuloSeguridad\RolesController;
use App\Http\Controllers\ModuloSeguridad\ObjetosController;
use App\Http\Controllers\ModuloSeguridad\PermisosController;
use App\Http\Controllers\ModuloSeguridad\ParametrosController;
use App\Http\Controllers\ModuloSeguridad\UsuariosController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('modseguridad.Login');
})->name('Login');
/*
Route::get('/Dashboard', function () {
    return view('admin.admin');
})->name('Dashboard');*/
Route::get('/Dashboard',[EstadisticaController::class,'index'])->name('Esta.edit');

//Login
Route::get('/login',[AuthController::class,'ShowLogin'])->name('ModuloSeguridad.Login');
Route::post('login',[AuthController::class,'SendLogin'])->name('ModuloSeguridad.entrar');
//LogOut
Route::get('logout',[Authcontroller::class,'Logout'])->name('cerrar-sesion');


//Preguntas
Route::get('menurecuperar',[AuthController::class,'ShowMenuRecuperar'])->name('ModuloSeguridad.reMenu');
Route::get('contrasenaCorreo',[AuthController::class,'SendPreguntasContra'])->name('ModuloSeguridad.seCorreo');
Route::get('preguntas',[AuthController::class,'ShowPreguntas'])->name('ModuloSeguridad.Preguntas');
Route::get('recuperar',[AuthController::class,'SendPreguntas'])->name('ModuloSeguridad.recuperar');
Route::get('nuevacontrasena',[AuthController::class,'SendRecuperar'])->name('ModuloSeguridad.nueva');
Route::get('preguntasSeg',[AuthController::class,'SendPreguntasSecretas'])->name('ModuloSeguridad.preguntasSeg');
Route::get('correoCon',[AuthController::class,'ShowCorreoContrasena'])->name('ModuloSeguridad.ConCorreo');
Route::get('emailCon',[AuthController::class,'SendCorreoContra'])->name('ModuloSeguridad.emailEnviarCon');
Route::get('ActualizarUs',[AuthController::class,'UpdUsuario'])->name('ModuloSeguridad.UpdUsu');
Route::get('contra',[AuthController::class,'SendContra'])->name('ModuloSeguridad.contra');

//Registro
Route::get('registro',[AuthController::class,'ShowRegistro'])->name('ModuloSeguridad.Registro');
Route::post('guardar',[AuthController::class,'SendRegistro'])->name('ModuloSeguridad.enviar');

// Horas Extras
Route::get('HoraExtra',[HoraExtraController::class, 'index'])->name('HoraExtra.index');
Route::post('Post-HoraExtra',[HoraExtraController::class, 'store'])->name('Post-HoraExtra.store');
Route::post('/Upt-HoraExtra',[HoraExtraController::class, 'update'])->name('Upt-HoraExtra.update');

// Vacaciones
Route::get('Vacaciones', [VacacionesController::class, 'index'])->name('Vacaciones.index');
Route::post('Post-Vacaciones', [VacacionesController::class, 'store'])->name('Post-Vacaciones.store');
Route::post('/Upt-Vacaciones',[VacacionesController::class, 'update'])->name('Upt-Vacaciones.update');

// Planillas
Route::get('Planilla', [PlanillaController::class, 'index'])->name('Planilla.index');
Route::post('Post-Planilla', [PlanillaController::class, 'store'])->name('Post-Planilla.Store');

//Reportes
Route::get('Reportes', [ReportesController::class, 'index'])->name('Reportes.index');
Route::post('Post-Reportes', [ReportesController::class, 'store'])->name('Post-Reportes.store');

//Reportes Generados
Route::get('ReportesGenerados', [ReportesGeneradosController::class, 'index'])->name('ReportesGenerados.index');

//Tipos de Reportes
Route::get('TiposReportes', [TiposReportesController::class, 'index'])->name('TiposReportes.index');
Route::post('Post-TiposReportes', [TiposReportesController::class, 'store'])->name('Post-TiposReportes.store');

//Reportes Guardados
Route::get('ReportesGuardados', [ReportesGuardadosController::class, 'index'])->name('ReportesGuardados.index');

//Rpeortesvista
Route::get('reportevista', [ReportesvistaController::class, 'index'])->name('Reportesvista.index');
Route::get('/generar-reporte', 'ReportController@generarReporte');

// Departamentos
Route::get('Departamentos', [DepartamentoController::class, 'index'])->name('Departamento.index');
Route::post('Post-Departamento', [DepartamentoController::class, 'store'])->name('Post-Departamento.store');
Route::post('Put-Departamento', [DepartamentoController::class, 'update'])->name('Put-Departamento.update');
Route::get('/Departamentos-Eliminados', [DepartamentoController::class, 'indexEliminados'])->name('DepartamentoEliminado.indexEliminados');
Route::post('Act-Departamento', [DepartamentoController::class, 'activar'])->name('Act-Departamento.activar');
Route::post('Del-Departamento', [DepartamentoController::class, 'desactivar'])->name('Del-Departamento.desactivar');

// Municipios
Route::get('Municipios', [MunicipioController::class, 'index'])->name('Municipio.index');
Route::post('Post-Municipio', [MunicipioController::class, 'store'])->name('Post-Municipio.store');
Route::post('/Upd-Municipio',[MunicipioController::class, 'update'])->name('Upd-Municipio.update');

// Empleado
Route::get('Empleado', [EmpleadoController::class, 'index'])->name('Empleado.index');
Route::post('Post-Empleado', [EmpleadoController::class, 'store'])->name('Post-Empleado.store');
Route::post('/Upd-Empleado',[EmpleadoController::class, 'update'])->name('Upd-Empleado.update');
Route::get('/empleados/validar-rtn/{rtn}', [EmpleadoController::class, 'validarRtn']);

// Personas
Route::get('Persona', [PersonaController::class, 'index'])->name('Persona.index');
Route::post('Post-Persona',[PersonaController::class, 'store'])->name('Post-Persona.store');
Route::post('/Upd-Persona',[PersonaController::class, 'update'])->name('Upd-Persona.update');


// Direcciones
Route::get('Direcciones', [DireccionController::class, 'index'])->name('Direcciones.index');
Route::post('/Upd-Direcciones',[DireccionController::class, 'update'])->name('Upd-Direcciones.update');


//Bancos
Route::get('Banco', [BancoController::class, 'index'])->name('Banco.index');
Route::post('/Upd-Banco',[BancoController::class, 'update'])->name('Upd-Banco.update');

//Correos
Route::get('Correo', [CorreoController::class, 'index'])->name('Correo.index');
Route::post('Put-Correo', [CorreoController::class, 'update'])->name('Upd-Correo.update');

//Estudios
Route::get('Estudio', [EstudioController::class, 'index'])->name('Estudio.index');
Route::post('Put-Estudio', [EstudioController::class, 'update'])->name('Upd-Estudio.update');

//Sucursal
Route::get('Sucursal', [SucursalController::class, 'index'])->name('Sucursal.index');
Route::post('Post-Sucursal',[SucursalController::class, 'store'])->name('Post-Sucursal.store');
Route::post('/Upd-Sucursal',[SucursalController::class, 'update'])->name('Upd-Sucursal.update');

//Departamento de empresa
Route::get('DeptoEmpresa', [DeptoEmpresaController::class, 'index'])->name('DeptoEmpresa.index');
Route::post('Post-DeptoEmpresa',[DeptoEmpresaController::class, 'store'])->name('Post-DeptoEmpresa.store');
Route::post('/Upd-DeptoEmpresa',[DeptoEmpresaController::class, 'update'])->name('Upd-DeptoEmpresa.update');

// Roles
Route::get('Roles', [RolesController::class, 'index'])->name('Roles.index');
Route::post('Post-Roles',[RolesController::class, 'store'])->name('Post-Roles.store');
Route::post('Upt-Roles',[RolesController::class, 'update'])->name('Upt-Roles.update');

// Objetos
Route::get('Objetos', [ObjetosController::class, 'index'])->name('Objetos.index');
Route::post('Post-Objetos',[ObjetosController::class, 'store'])->name('Post-Objetos.store');
Route::post('Upt-Objetos',[ObjetosController::class, 'update'])->name('Upt-Objetos.update');

// Permisos
Route::get('Permisos', [PermisosController::class, 'index'])->name('Permisos.index');
Route::post('Post-Permisos',[PermisosController::class, 'store'])->name('Post-Permisos.store');
Route::post('Upt-Permisos',[PermisosController::class, 'update'])->name('Upt-Permisos.update');

// Parametros
Route::get('Parametros', [ParametrosController::class, 'index'])->name('Parametros.index');
Route::post('Post-Parametros',[ParametrosController::class, 'store'])->name('Post-Parametros.store');
Route::post('Upt-Parametros',[ParametrosController::class, 'update'])->name('Upt-Parametros.update');

// Usuarios
Route::get('Usuarios', [UsuariosController::class, 'index'])->name('Usuarios.index');

Route::get('estadistica', [EstadisticaController::class, 'edit'])->name('estadistica.edit');

