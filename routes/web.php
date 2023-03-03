<?php

use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\PagosController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DescuentosController;
use App\Http\Controllers\EstadisticasControler;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\HorarioCursoController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\ModuloProgramaController;
use App\Http\Controllers\HorarioProgramaController;
use App\Http\Controllers\CertificadoCursoController;
use App\Http\Controllers\InscripcionCursoController;
use App\Http\Controllers\CertificadoProgramaController;

/*use Spatie\Permission\Models\Role;

Role::create(['name' => 'administrador']);
Role::create(['name' => 'administrativo_programas']);
Role::create(['name' => 'administrativo_inscripciones']);
*/

App::setLocale("es");

Route::get('/home', [HomeController::class, 'index'])->name('home.index');

Route::get('/', function () {
    return to_route('home.index');
});

//Auth::routes();
Route::get("/login", [LoginController::class, 'showLoginForm'])->name('showLoginForm');
Route::post("/login", [LoginController::class, 'login'])->name('login');
Route::post("/logout", [LoginController::class, 'logout'])->name('logout');

Route::get("/register", [UserController::class, 'showRegistrationForm'])->name('showRegistrationForm');
Route::post("/register", [UserController::class, 'store'])->name('register');


/* Personas verificado con roles*/
Route::resource('personas', PersonaController::class)->middleware('auth');

Route::resource('inscripciones', InscripcionController::class);
Route::get('inscripciones/Programas/{inscripcione}', [InscripcionController::class, 'showProgram'])->name('inscripciones.showProgram');
Route::patch('inscripciones/Programas/{inscripcione}', [InscripcionController::class, 'destroyProgram'])->name('inscripciones.destroyProgram');
Route::get('inscripcion-programa/grupo-horario/{programa}', [InscripcionController::class, 'getGroupsByProgram'])->name('inscripciones-grupos.horarios');


Route::resource('inscripcion-curso', InscripcionCursoController::class);
Route::get('inscripcion-curso/grupo-horario/{curso}', [InscripcionCursoController::class, 'getGroupsByCourse'])->name('inscripciones-cursos-grupos.horarios');


/* Estadisiticas verificado con roles*/
Route::get('estadisticas/programas', [EstadisticasControler::class, 'programas'])->name('estadistica.programas');
Route::get('estadisticas/cursos', [EstadisticasControler::class, 'cursos'])->name('estadistica.cursos');

/** Certificados verificado con roles*/
Route::resource('certificados-programa', CertificadoProgramaController::class);
Route::resource('certificados-curso', CertificadoCursoController::class);

/** Pagos verificado con roles*/

Route::resource('pagos', PagosController::class);
//Route::get('pagos/create/{planPago}', [PagosController::class, 'create'])->name('pagos.create');
//Route::get('pagos/delete/{planPago}', [PagosController::class, 'delete'])->name('pagos.delete');
Route::patch('pagos/update/{planPago}', [PagosController::class, 'updatePlan'])->name('pagos.updatePlan');


Route::resource('pago', PagoController::class);
//Route::post('pago/{planPago}', [PagoController::class, 'store'])->name('pago.store');
//Route::get('pago/create/{planPago}/{tipo}', [PagoController::class, 'create'])->name('pago.create');
Route::patch('pago/pagar/{pago}', [PagoController::class, 'updateEstado'])->name('pago.updateEstado');


Route::post('pago/udpate/{planPago}', [PagoController::class, 'updatePago'])->name('pago.updatePago');


/**Users verificado con roles*/
Route::get('/users', [UserController::class, 'index'])->name('user.index');
Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
Route::patch('/users/update/{user}', [UserController::class, 'update'])->name('user.update');
Route::delete('/users/delete/{user}', [UserController::class, 'delete'])->name('user.delete');


/**Gestionar Programas */

Route::resource('programas', ProgramaController::class);
Route::post('modulo/create', [ProgramaController::class, 'addModule'])->name('modulo.create');
Route::delete('modulo/{modulo}', [ProgramaController::class, 'deleteModule'])->name('modulo.delete');

/**Gestionar cursos */
Route::resource('cursos', CursoController::class);


/**Gestionar horarios */
Route::resource('horarios-programas', HorarioProgramaController::class);
Route::post('horarios-programas/add', [HorarioProgramaController::class, 'addOneSchedule'])->name('horarios-programas.add');
Route::delete('horarios-programas/delete/{horario}', [HorarioProgramaController::class, 'deleteSchedule'])->name('horarios-programas.delete');


Route::resource('horarios-cursos', HorarioCursoController::class);
Route::post('horarios-cursos/add', [HorarioCursoController::class, 'addOneSchedule'])->name('horarios-cursos.add');
Route::delete('horarios-cursos/delete/{horario}', [HorarioCursoController::class, 'deleteSchedule'])->name('horarios-cursos.delete');

/**Gestionar Descuentos */
Route::resource('descuentos', DescuentosController::class);
Route::get('descuentos/status/{descuento}', [DescuentosController::class, 'changeStatus'])->name('descuentos.changeStatus');;
Route::get('descuentos/programa/{programa}', [DescuentosController::class, 'getDiscountByProgram'])->name('descuentos.list');;
Route::get('descuento/precio', [DescuentosController::class, 'getPrices'])->name('descuento.precio');;

/** Gestionar Carreras */
Route::resource('carreras', CarreraController::class);
