<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CertificadoCursoController;
use App\Http\Controllers\CertificadoProgramaController;
use App\Http\Controllers\EstadisticasControler;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\InscripcionCursoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\PagosController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*use Spatie\Permission\Models\Role;

Role::create(['name' => 'administrador']);
Role::create(['name' => 'administrativo_programas']);
Role::create(['name' => 'administrativo_inscripciones']);
*/

App::setLocale("es");

Route::get('/home', function () {
    return view('content.inicio');
});

Route::get('/', function () {
    return redirect("/home");
});

//Auth::routes();
Route::get("/login", [LoginController::class, 'showLoginForm'])->name('showLoginForm');
Route::post("/login", [LoginController::class, 'login'])->name('login');
Route::post("/logout", [LoginController::class, 'logout'])->name('logout');

Route::get("/register", [RegisterController::class, 'showRegistrationForm'])->name('showRegistrationForm');
Route::post("/register", [RegisterController::class, 'store'])->name('register');


/* Personas */
Route::resource('personas', PersonaController::class);
Route::resource('inscripciones', InscripcionController::class);
Route::get('inscripciones/Programas/{inscripcione}', [InscripcionController::class, 'showProgram'])->name('inscripciones.showProgram');
Route::patch('inscripciones/Programas/{inscripcione}', [InscripcionController::class, 'destroyProgram'])->name('inscripciones.destroyProgram');
Route::resource('inscripcion-curso', InscripcionCursoController::class);


/* Estadisiticas */
Route::get('estadisticas/programas', [EstadisticasControler::class, 'programas'])->name('estadistica.programas');
Route::get('estadisticas/cursos', [EstadisticasControler::class, 'cursos'])->name('estadistica.cursos');

/** Certificados */
Route::resource('certificados-programa', CertificadoProgramaController::class);
Route::resource('certificados-curso', CertificadoCursoController::class);

/** Pagos */

Route::resource('pagos', PagosController::class);
Route::get('pagos/create/{planPago}', [PagosController::class, 'create'])->name('pagos.create');
Route::get('pagos/delete/{planPago}', [PagosController::class, 'delete'])->name('pagos.delete');
Route::patch('pagos/update/{planPago}', [PagosController::class, 'updatePlan'])->name('pagos.updatePlan');


Route::resource('pago', PagoController::class);
Route::post('pago/{planPago}', [PagoController::class, 'store'])->name('pago.store');
Route::get('pago/create/{planPago}/{tipo}', [PagoController::class, 'create'])->name('pago.create');
Route::patch('pago/pagar/{pago}', [PagoController::class, 'updateEstado'])->name('pago.updateEstado');


Route::post('pago/udpate/{planPago}', [PagoController::class, 'updatePago'])->name('pago.updatePago');


/**Users */
Route::get('/users', [UserController::class, 'index'])->name('user.index');
