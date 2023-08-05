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
use App\Http\Controllers\ModuloReportes\EstadisticaController;
use App\Http\Controllers\ModuloPersonas\EmpleadoController;
use App\Http\Controllers\ModuloSeguridad\AuthController;
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

Route::get('/admin', function () {
    return view('admin.admin');
})->name('dashboard');
/*
Route::get('/HoraExtra', function () {
    return view('horaextra.index');
});*/

//Login
Route::get('/',[AuthController::class,'ShowLogin'])->name('ModuloSeguridad.Login');
Route::post('login',[AuthController::class,'SendLogin'])->name('ModuloSeguridad.enviar');

//Preguntas
Route::get('preguntas',[AuthController::class,'ShowPreguntas'])->name('ModuloSeguridad.Preguntas');
//Registro
Route::get('registro',[AuthController::class,'ShowRegistro'])->name('ModuloSeguridad.Registro');


// Horas Extras
Route::get('HoraExtra',[HoraExtraController::class, 'index'])->name('HoraExtra.index');
Route::post('Post-HoraExtra',[HoraExtraController::class, 'store'])->name('Post-HoraExtra.store');
Route::get('HEmpleado',[HoraExtraController::class, 'create'])->name('HEmpleado.create');

// Vacaciones
Route::get('Vacaciones', [VacacionesController::class, 'index'])->name('Vacaciones.index');
Route::post('Post-Vacaciones', [VacacionesController::class, 'store'])->name('Post-Vacaciones.store');

// Planillas
Route::get('Planilla', [PlanillaController::class, 'index'])->name('Planilla.index');
Route::post('Post-Planilla', [PlanillaController::class, 'store'])->name('Post-Planilla.Store');

//Reportes
Route::get('Reportes', [ReportesController::class, 'index'])->name('Reportes.index');

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

// Municipios
Route::get('Municipios', [MunicipioController::class, 'index'])->name('Muncipio.index');
Route::post('Post-Municipio', [MunicipioController::class, 'store'])->name('Post-Municipio.store');

// Estadisticas
Route::get('Estadistica', [EstadisticaController::class, 'index'])->name('Estadistica.index');

// Empleado
Route::get('Empleado', [EmpleadoController::class, 'index'])->name('Empleado.index');
Route::post('Post-Empleado', [EmpleadoController::class, 'store'])->name('Post-Empleado.store');