Web 

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
use App\Http\Controllers\ModuloPersonas\InsEmpleadoController;

use App\Http\Controllers\ModuloSeguridad\RolesController;
use App\Http\Controllers\ModuloSeguridad\ObjetosController;
use App\Http\Controllers\ModuloSeguridad\PermisosController;
use App\Http\Controllers\ModuloSeguridad\ParametrosController;
use App\Http\Controllers\ModuloSeguridad\UsuariosController;
use App\Http\Controllers\ModuloSeguridad\PerfilController;
use App\Http\Controllers\ModuloSeguridad\ContraPerfilController;
use App\Http\Controllers\ModuloSeguridad\BitacoraController;
use App\Http\Controllers\ModuloPlanillas\DeduccionController;
use App\Http\Controllers\ModuloPlanillas\VacacionesEmpleadoController;
use App\Http\Controllers\ModuloPlanillas\DetallePlanillaController;
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

Route::get('/Dashboard', function () {
    return view('admin.admin');
})->name('Dashboard');
/*Route::get('/Dashboard',[EstadisticaController::class,'index'])->name('Esta.edit');*/

//Login
Route::get('/login',[AuthController::class,'ShowLogin'])->name('ModuloSeguridad.Login');
Route::post('login',[AuthController::class,'SendLogin'])->name('ModuloSeguridad.entrar');
//LogOut
Route::post('logout',[Authcontroller::class,'Logout'])->name('cerrar-sesion');


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
Route::get('Planilla_Aguinaldo', [PlanillaController::class, 'indexAguinaldo'])->name('PlanillaAguinaldo.index');
Route::get('Planilla_Catorceavo', [PlanillaController::class, 'indexCatorceavo'])->name('PlanillaCatorceavo.index');
Route::get('Planilla_Vacaciones', [PlanillaController::class, 'indexVacaciones'])->name('PlanillaVacaciones.index');
Route::get('/Generar-Planilla', [PlanillaController::class, 'showGenerarPlanilla'])->name('generar.planilla');
Route::post('Post-Planilla', [PlanillaController::class, 'store'])->name('Post-Planilla.Store');
Route::post('/Post-Generar-Planilla' , [PlanillaController::class, 'guardarSelecciones']);

// Detalle Planillas
Route::get('Detalle-Planilla', [DetallePlanillaController::class, 'index'])->name('DetallePlanilla.index');
Route::get('/DetallePlanilla/{ID_PLANILLA}', [DetallePlanillaController::class, 'show'])->name('ShowPlanilla.Show');
Route::post('Post-Detalle-Planilla', [DetallePlanillaController::class, 'store'])->name('PostDetalle.store');

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
Route::get('/Municipio-Eliminados', [MunicipioController::class, 'indexEliminados'])->name('MunicipiosEliminado.indexEliminados');
Route::post('Act-Municipio', [MunicipioController::class, 'activar'])->name('Act-Municipio.activar');
Route::post('Del-Municipio', [MunicipioController::class, 'desactivar'])->name('Del-Municipio.desactivar');

// Empleado
Route::get('Empleado', [EmpleadoController::class, 'index'])->name('Empleado.index');
Route::get('InsEmpleado', [EmpleadoController::class, 'insEmpleados'])->name('InsEmpleado.index'); 
// Ruta para manejar datos de los formularios
Route::post('Post-Empleado', [EmpleadoController::class, 'manejarDatos'])->name('Post-Empleado.store');


Route::post('/Upd-Empleado',[EmpleadoController::class, 'update'])->name('Upd-Empleado.update');
Route::get('/empleados/validar-rtn/{rtn}', [EmpleadoController::class, 'validarRtn']);

// Personas
Route::get('Persona', [PersonaController::class, 'index'])->name('Persona.index');
Route::get('InsPersona', [PersonaController::class, 'insPersonas'])->name('InsPersona.index'); 
// Ruta para manejar datos de los formularios
Route::post('Post-Persona', [PersonaController::class, 'manejarDatos2'])->name('Post-Persona.store');
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
Route::get('/Sucursales-Eliminados', [SucursalController::class, 'indexEliminados'])->name('SucursalEliminado.indexEliminados');
Route::post('Act-Sucursal', [SucursalController::class, 'activar'])->name('Act-Sucursal.activar');
Route::post('Del-Sucursal', [SucursalController::class, 'desactivar'])->name('Del-Sucursal.desactivar');

//Departamento de empresa
Route::get('DeptoEmpresa', [DeptoEmpresaController::class, 'index'])->name('DeptoEmpresa.index');
Route::post('Post-DeptoEmpresa',[DeptoEmpresaController::class, 'store'])->name('Post-DeptoEmpresa.store');
Route::post('/Upd-DeptoEmpresa',[DeptoEmpresaController::class, 'update'])->name('Upd-DeptoEmpresa.update');
Route::get('/DeptoEmpresa-Eliminados', [DeptoEmpresaController::class, 'indexEliminados'])->name('DeptoEmpresaEliminado.indexEliminados');
Route::post('Act-DeptoEmpresa', [DeptoEmpresaController::class, 'activar'])->name('Act-DeptoEmpresa.activar');
Route::post('Del-DeptoEmpresa', [DeptoEmpresaController::class, 'desactivar'])->name('Del-DeptoEmpresa.desactivar');


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
Route::post('Post-Usuario',[UsuariosController::class, 'store'])->name('Post-Usuario.store');


Route::get('estadistica', [EstadisticaController::class, 'edit'])->name('estadistica.edit');

//Perfil
Route::get('Perfil', [PerfilController::class, 'index'])->name('Perfil.index');
Route::get('ContraPerfil', [ContraPerfilController::class, 'UpdPerfilContra'])->name('ContraPerfil.index');

//Bitacora
Route::get('bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');

//Deduccion
Route::get('Deducciones', [DeduccionController::class, 'index'])->name('Deducciones.index');
Route::get('Ihss', [DeduccionController::class, 'indexIhss'])->name('Ihss.index');
Route::post('Post-Deduccion', [DeduccionController::class, 'store'])->name('Post-Deduccion.store');
Route::post('Upt-Deduccion',[DeduccionController::class, 'update'])->name('Upt-Deduccion.update');
// ESTADISTICAS
Route::get('Estadisticas', [EstadisticaController::class, 'index'])->name('Estadisticas.index');

//ISR
use App\Http\Controllers\ModuloPlanillas\IsrController;

// Ruta para mostrar la vista ISR
Route::get('/isr', [IsrController::class, 'index'])->name('isr.index');
Route::post('Post-isr',[IsrController::class, 'store'])->name('Post-isr.store');
Route::post('/Upd-isr',[IsrController::class, 'update'])->name('Upd-isr.update');

Route::get('VacacionesEmpleados', [VacacionesEmpleadoController::class, 'index'])->name('VacacionesEmpleados.index');
Route::post('/Upd-VacacionesEmpleados',[VacacionesEmpleadoController::class, 'update'])->name('Upd-VacacionesEmpleados.update');

Route::get('/Sucursales-Eliminados', [SucursalController::class, 'indexEliminados'])->name('SucursalEliminado.indexEliminados');
Route::post('Act-Sucursal', [SucursalController::class, 'activar'])->name('Act-Sucursal.activar');
Route::post('Del-Sucursal', [SucursalController::class, 'desactivar'])->name('Del-Sucursal.desactivar');

