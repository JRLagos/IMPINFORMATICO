<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\ModuloPlanillas\VacacionesController;
use App\Http\Controllers\ModuloPlanillas\HoraExtraController;
use App\Http\Controllers\ModuloPlanillas\PlanillaController;
use App\Http\Controllers\ModuloReportes\ReportesGeneradosController;
use App\Http\Controllers\ModuloReportes\ReportesController;
use App\Http\Controllers\ModuloReportes\TiposReportesController;
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

//Login
Route::get('/login',[AuthController::class,'ShowLogin'])->name('ModuloSeguridad.Login');
Route::post('login',[AuthController::class,'SendLogin'])->name('ModuloSeguridad.entrar');

//Preguntas
Route::get('preguntas',[AuthController::class,'ShowPreguntas'])->name('ModuloSeguridad.Preguntas');
Route::get('recuperar',[AuthController::class,'SendPreguntas'])->name('ModuloSeguridad.recuperar');
Route::get('nuevacontrasena',[AuthController::class,'SendRecuperar'])->name('ModuloSeguridad.nueva');

//Registro
Route::get('registro',[AuthController::class,'ShowRegistro'])->name('ModuloSeguridad.Registro');
Route::post('guardar',[AuthController::class,'SendRegistro'])->name('ModuloSeguridad.enviar');

// Horas Extras
Route::get('HoraExtra',[HoraExtraController::class, 'index'])->name('HoraExtra.index');
Route::post('Post-HoraExtra',[HoraExtraController::class, 'store'])->name('Post-HoraExtra.store');
Route::put('/Upt-HoraExtra/{id}',[HoraExtraController::class, 'update'])->name('Upt-HoraExtra.update');

// Vacaciones
Route::get('Vacaciones', [VacacionesController::class, 'index'])->name('Vacaciones.index');
Route::post('Post-Vacaciones', [VacacionesController::class, 'store'])->name('Post-Vacaciones.store');

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

// Departamentos
Route::get('Departamentos', [DepartamentoController::class, 'index'])->name('Departamento.index');
Route::post('Post-Departamento', [DepartamentoController::class, 'store'])->name('Post-Departamento.store');
Route::put('Put-Departamento', [DepartamentoController::class, 'update'])->name('Put-Departamento.update');


// Municipios
Route::get('Municipios', [MunicipioController::class, 'index'])->name('Municipio.index');
Route::post('Post-Municipio', [MunicipioController::class, 'store'])->name('Post-Municipio.store');

// Estadisticas
Route::get('Estadistica', [EstadisticaController::class, 'index'])->name('Estadistica.index');

// Empleado
Route::get('Empleado', [EmpleadoController::class, 'index'])->name('Empleado.index');
Route::post('Post-Empleado', [EmpleadoController::class, 'store'])->name('Post-Empleado.store');
Route::get('/empleados/validar-rtn/{rtn}', [EmpleadoController::class, 'validarRtn']);

// Personas
Route::get('Persona', [PersonaController::class, 'index'])->name('Persona.index');
Route::post('Post-Persona',[PersonaController::class, 'store'])->name('Post-Persona.store');


// Direcciones
Route::get('Direcciones', [DireccionController::class, 'index'])->name('Direcciones.index');

//Bancos
Route::get('Banco', [BancoController::class, 'index'])->name('Banco.index');

//Correos
Route::get('Correo', [CorreoController::class, 'index'])->name('Correo.index');


//Estudios
Route::get('Estudio', [EstudioController::class, 'index'])->name('Estudio.index');

//Sucursal
Route::get('Sucursal', [SucursalController::class, 'index'])->name('Sucursal.index');
Route::post('Post-Sucursal',[SucursalController::class, 'store'])->name('Post-Sucursal.store');

//Departamento de empresa
Route::get('DeptoEmpresa', [DeptoEmpresaController::class, 'index'])->name('DeptoEmpresa.index');
Route::post('Post-DeptoEmpresa',[DeptoEmpresaController::class, 'store'])->name('Post-DeptoEmpresa.store');

