<?php

use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\InscripcionCursoController;
use App\Http\Controllers\PersonaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('content.inicio');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


/* Personas */
Route::resource('personas', PersonaController::class);
Route::resource('inscripciones', InscripcionController::class);
Route::get('inscripciones/Programas/{inscripcione}', [InscripcionController::class, 'showProgram'])->name('inscripciones.showProgram');
Route::patch('inscripciones/Programas/{inscripcione}', [InscripcionController::class, 'destroyProgram'])->name('inscripciones.destroyProgram');
Route::resource('inscripcion-curso', InscripcionCursoController::class);
