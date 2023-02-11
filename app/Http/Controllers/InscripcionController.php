<?php

namespace App\Http\Controllers;

use App\Models\InscripcionCurso;
use App\Models\InscripcionPrograma;
use App\Models\Persona;
use App\Models\Programa;
use App\Models\Visitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class InscripcionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:' . config('variables.rol_admin') . '|' . config('variables.rol_admin_inscrip'));
    }

    public function updateVisitCount($path)
    {
        $visit = Visitas::firstOrNew(['ruta' => $path]);
        $visit->increment('contador');
        $visit->save();
    }

    public function index(Request $request)
    {
        $route = Route::currentRouteName();
        $search = trim($request->input('search'));


        $path = request()->path();
        $this->updateVisitCount($path);
        $visitas = Visitas::where('ruta', $path)->first();

        $inscritos = InscripcionPrograma::join('persona', 'per_id', 'inscripcion_programa.estudiante')
            ->where(function ($q) use ($search) {
                $q->where('persona.per_appm', 'ilike', '%' . $search . '%')
                    ->orwhere('persona.per_nom', 'ilike', '%' . $search . '%')
                    ->orwhere('persona.per_ci', 'ilike', '%' . $search . '%');
            })->where('inscrip_program_estado', '=', 'true')->paginate(5);

        return view('content.pages.personas.pages-persona-inscritos', ['inscritos' => $inscritos, 'visitas' => $visitas, 'ruta' => $route, 'busqueda' => $search]);
    }


    public function create()
    {
        $path = request()->path();
        $this->updateVisitCount($path);
        $visitas = Visitas::where('ruta', $path)->first();

        $estudiantes = Persona::where('per_tipo', [1])->get();
        return view('content.pages.personas.pages-persona-inscripcion', ['listaEstudiantes' => $estudiantes, 'visitas' => $visitas]);
    }


    public function store(Request $request)
    {

        $alumno = Persona::where('per_ci', [$request->input('inscripcion_alumno')])->get()->all();
        if (sizeof($alumno) == 0) {
            return redirect()->back()->withErrors(['er' => 'NO existe el C.I.']);
        }

        $inscripcion =  InscripcionPrograma::where([
            ['estudiante', '=',  $alumno[0]->per_id],
            ['programa', '=', $request->input('inscripcion_programa')],
            ['grupo', '=', $request->input('inscripcion_grupo')]
        ])->orderBy('inscrip_program_nro', 'desc')->get();;

        if (sizeof($inscripcion) == 0 || $inscripcion[0]->inscrip_program_estado == false) {
            InscripcionPrograma::create([
                'inscrip_program_fecha' => now(),
                'estudiante' => $alumno[0]->per_id,
                'programa' => $request->input('inscripcion_programa'),
                'grupo' => $request->input('inscripcion_grupo')
            ]);
        } else {
            return redirect()->back()->withErrors(['er' => 'Ya esta inscritos en este programa']);
        }

        return to_route('inscripciones.index');
    }

    public function showProgram($id)
    {
        $path = request()->path();
        $basepath = preg_replace("/\/[0-9]+/", "/*", $path);
        $this->updateVisitCount($basepath);
        $visitas = Visitas::where('ruta', $basepath)->first();
        $inscripcion = InscripcionPrograma::find($id);
        $tipo = 1;
        return view('content.pages.personas.page-persona-boleta', ['inscripcion' => $inscripcion, 'tipo' => $tipo, 'visitas' => $visitas]);
    }


    public function destroyProgram($id)
    {
        $inscrProgram = InscripcionPrograma::find($id);
        $inscrProgram->inscrip_program_estado = false;
        $inscrProgram->save();
        return to_route('inscripciones.index');
    }
}
