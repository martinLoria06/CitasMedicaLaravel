<?php

use App\Http\Controllers\Admin\chartController;
use App\Http\Controllers\Admin\DoctorController as AdminDoctorController;
use App\Http\Controllers\Admin\PatientController as AdminPatientController;
use App\Http\Controllers\Admin\SpecialtyController as AdminSpecialtyController;
use App\Http\Controllers\Api\HorarioController as ApiHorarioController;
use App\Http\Controllers\Api\SpecialtyController as ApiSpecialtyController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Doctor\HorarioController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SpecialtyController;
use App\Models\Appoinment;
use App\Models\Specialty;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::redirect('/','login');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth','admin'])->group(function(){
    //Rutas Especialidades
    Route::get('/especialidades',[AdminSpecialtyController::class, 'index'])->name('especialidades.index');
    Route::get('/especialidades/create',[AdminSpecialtyController::class, 'create'])->name('especialidades.create');
    Route::get('/especialidades/{specialty}/editar',[AdminSpecialtyController::class, 'edit'])->name('especialidades.edit');
    Route::post('/especialidades',[AdminSpecialtyController::class, 'sendData'])->name('especialidades.senData');
    Route::put('/especialidades/{specialty}',[AdminSpecialtyController::class, 'update'])->name('especialidades.update');
    Route::delete('/especialidades/{specialty}',[AdminSpecialtyController::class, 'destroy'])->name('especialidades.destroy');

    //Rutas de doctores
    Route::resource('/medicos',AdminDoctorController::class);

    //Rutas de Pacientes
    Route::resource('/pacientes',AdminPatientController::class);
    //Rutas Reportes
    Route::get('/reportes/citas/line',[chartController::class, 'appointments'])->name('graficas.appointments');
});

Route::group(['middleware' => 'doctor'], function () {
    Route::prefix('horario')
    ->controller(HorarioController::class)
    ->group(function(){
        Route::get('/','edit')->name('horario.edit');
        Route::post('/','store')->name('horario.store');

    });
});

Route::middleware('auth')->group(function(){
    Route::get('/reservarcitas', [AppointmentController::class ,'create'])->name('appoinmente.create');
    Route::post('/reservarcitas', [AppointmentController::class ,'store'])->name('reservarcita.store');
    Route::get('/miscitas', [AppointmentController::class ,'index'])->name('miscitas.index');
    Route::get('/miscitas/{appointment}', [AppointmentController::class ,'show'])->name('miscitas.show');
    Route::get('/miscitas/{appointment}/cancel', [AppointmentController::class ,'formCancel'])->name('miscitas.formCancel');
    Route::post('/miscitas/{appointment}/confirm', [AppointmentController::class ,'confirm'])->name('miscitas.confirm');
    Route::post('/miscitas/{appointment}/cancel', [AppointmentController::class ,'cancelar'])->name('miscitas.cancelar');

    //JSON
    Route::get('/especialidades/{specialty}/medicos',[ApiSpecialtyController::class,'doctors'])->name('especialidades.doctors');
    Route::get('/horario/horas',[ApiHorarioController::class,'hours'])->name('horarios.horas');
});
// Route::prefix('/reservarcitas')
//     ->controller()
//     ->group(function(){
//         Route::get('/create','create')->name('appoinmente.create');
//         Route::post('/create','create')->name('appoinmente.create');
//     });
