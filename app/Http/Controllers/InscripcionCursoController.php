<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\GrupoCurso;
use App\Models\InscripcionCurso;
use App\Models\Persona;
use App\Models\Visitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class InscripcionCursoController extends Controller
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

        $inscritos = InscripcionCurso::join('persona', 'per_id', 'inscripcion_curso.estudiante')
            ->where(function ($q) use ($search) {
                $q->where('persona.per_appm', 'ilike', '%' . $search . '%')
                    ->orwhere('persona.per_nom', 'ilike', '%' . $search . '%')
                    ->orwhere('persona.per_ci', 'ilike', '%' . $search . '%');
            })->where('inscrip_curs_estado', '=', 'true')->paginate(5);

        return view('content.pages.personas.pages-persona-inscritos-cursos', ['inscritos' => $inscritos, 'visitas' => $visitas, 'ruta' => $route, 'busqueda' => $search]);
    }


    public function create()
    {
        $path = request()->path();
        $this->updateVisitCount($path);
        $visitas = Visitas::where('ruta', $path)->first();

        $estudiantes = Persona::where('per_tipo', [1])->get();
        $cursos = Curso::get();
        return view('content.pages.personas.pages-persona-inscripcion-cursos', ['listaEstudiantes' => $estudiantes, 'cursos' => $cursos, 'visitas' => $visitas]);
    }


    public function store(Request $request)
    {

        $alumno = Persona::where('per_ci', [$request->input('inscripcion_alumno')])->get()->all();
        if (sizeof($alumno) == 0) {
            return redirect()->back()->withErrors(['er' => 'NO existe el C.I.']);
        }

        $inscripcion =  InscripcionCurso::where([
            ['estudiante', '=',  $alumno[0]->per_id],
            ['curso', '=', $request->input('inscripcion_curso')],
            ['grupo', '=', $request->input('inscripcion_grupo')]
        ])->orderBy('inscrip_curs_id', 'desc')->get();

        if (sizeof($inscripcion) == 0 || $inscripcion[0]->inscrip_curs_estado == false) {
            InscripcionCurso::create([
                'inscrip_curs_fecha' => now(),
                'estudiante' => $alumno[0]->per_id,
                'curso' => $request->input('inscripcion_curso'),
                'grupo' => $request->input('inscripcion_grupo')
            ]);
        } else {
            return redirect()->back()->withErrors(['er' => 'Ya esta inscritos en este curso']);
        }

        return to_route('inscripcion-curso.index');
    }

    public function show($id)
    {
        $path = request()->path();
        $basepath = preg_replace("/\/[0-9]+/", "/*", $path);
        $this->updateVisitCount($basepath);
        $visitas = Visitas::where('ruta', $basepath)->first();

        $inscripcion = InscripcionCurso::find($id);
        $tipo = 2;
        return view('content.pages.personas.page-persona-boleta', ['inscripcion' => $inscripcion, 'tipo' => $tipo, 'visitas' => $visitas]);
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $inscrCurso = InscripcionCurso::find($id);
        $inscrCurso->inscrip_curs_estado = false;
        $inscrCurso->save();
        return to_route('inscripcion-curso.index');
    }


    public function getGroupsByCourse($idCourse)
    {
        $groups = GrupoCurso::with('horario_cursos')
            ->where('curso', '=', $idCourse)->get();
        return response()->json(['groups' => $groups]);
    }
}
