<?php

use App\Http\Controllers\SpecialtyController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Rutas Especialidades
Route::get('/especialidades',[SpecialtyController::class, 'index'])->name('especialidades.index');
Route::get('/especialidades/create',[SpecialtyController::class, 'create'])->name('especialidades.create');
Route::get('/especialidades/{specialty}/editar',[SpecialtyController::class, 'edit'])->name('especialidades.edit');
Route::post('/especialidades',[SpecialtyController::class, 'sendData'])->name('especialidades.senData');
Route::put('/especialidades/{specialty}',[SpecialtyController::class, 'update'])->name('especialidades.update');
Route::delete('/especialidades/{specialty}',[SpecialtyController::class, 'destroy'])->name('especialidades.destroy');
