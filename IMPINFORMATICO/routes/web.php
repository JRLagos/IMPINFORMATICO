<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\ModuloPlanillas\VacacionesController;
use App\Http\Controllers\ModuloPlanillas\HoraExtraController;
use App\Http\Controllers\ModuloPlanillas\PlanillaController;
//Reportes
use App\Http\Controllers\ModuloReportes\ReportesGeneradosController;
use App\Http\Controllers\ModuloReportes\ReportesController;
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
    return view('admin.admin');
})->name('dashboard');
/*
Route::get('/HoraExtra', function () {
    return view('horaextra.index');
});*/

Route::get('HoraExtra',[HoraExtraController::class, 'index'])->name('HoraExtra.index');
route::post('Post-HoraExtra',[HoraExtraController::class, 'store'])->name('Post-HoraExtra.store');

Route::get('Vacaciones', [VacacionesController::class, 'index'])->name('Vacaciones.index');
Route::post('Post-Vacaciones', [VacacionesController::class, 'store'])->name('Post-Vacaciones.store');

Route::get('Planilla', [PlanillaController::class, 'index'])->name('Planilla.index');

//Reportes
Route::get('Reportes', [ReportesController::class, 'index'])->name('Reportes.index');
Route::get('ReportesGenerados', [ReportesGeneradosController::class, 'index'])->name('ReportesGenerados.index');