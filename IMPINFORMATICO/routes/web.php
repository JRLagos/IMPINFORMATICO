<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\ModuloPlanillas\HoraExtraController;
use App\Http\Controllers\ModuloPlanillas\VacacionesController;

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

Route::get('HoraExtra', [HoraExtraController::class, 'index'])->name('horaextra.index');
Route::post('post-HoraExtra', [HoraExtraController::class, 'create'])->name('post-HoraExtra.create');
Route::put('put-HoraExtra', [HoraExtraController::class, 'update'])->name('put-HoraExtra.update');

Route::get('Vacaciones', [VacacionesController::class, 'index'])->name('Vacaciones.index');