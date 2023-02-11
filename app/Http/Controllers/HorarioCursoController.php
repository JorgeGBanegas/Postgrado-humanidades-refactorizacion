<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGrupoHorarioCursosRequest;
use App\Models\Curso;
use App\Models\GrupoCurso;
use App\Models\HorarioCurso;
use App\Models\Visitas;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HorarioCursoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:' . config('variables.rol_admin') . '|' . config('variables.rol_admin_progr'));
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

        $gruposHorarios = GrupoCurso::join('curso', 'curs_id', 'grupo_curso.curso')
            ->where(function ($q) use ($search) {
                $q->where('grup_curs_cod', 'ilike', '%' . $search . '%')
                    ->orWhere('curso.curs_nom', 'ilike', '%' . $search . '%');
            })
            //            ->orderBy('curso.curs_nom', 'ASC')
            ->orderBy('grup_curs_id', 'DESC')
            ->paginate(5);

        return view('content.pages.horarios.horario-curso', ['gruposHorarios' => $gruposHorarios, 'visitas' => $visitas, 'ruta' => $route, 'busqueda' => $search]);
    }

    public function create()
    {
        $path = request()->path();
        $this->updateVisitCount($path);
        $visitas = Visitas::where('ruta', $path)->first();

        $cursos = Curso::get();
        return view('content.pages.horarios.horario-curso-registro', ['cursos' => $cursos, 'visitas' => $visitas]);
    }

    public function store(StoreGrupoHorarioCursosRequest $request)
    {
        DB::beginTransaction();
        try {


            $existeGrupo =
                GrupoCurso::where('grup_curs_cod', '=', $request->input('grup_curs_cod'))
                ->where('curso', '=', $request->input('curso'))
                ->exists();

            if ($existeGrupo) {
                return redirect()->back()->withErrors(['err' => 'Ya existe un curso con este codigo en este programa']);
            }

            $grupo = GrupoCurso::create([
                'grup_curs_cod' => $request->input('grup_curs_cod'),
                'curso' => $request->input('curso'),
            ]);
            $listaDeHorarios =  json_decode($request->horarios, true);
            foreach ($listaDeHorarios as $horario) {
                $dia = $horario['dia'];
                $hini = $horario['hini'];
                $hfin = $horario['hfin'];
                $grupoId = $grupo->grup_curs_id;

                $existeHorario = HorarioCurso::where('hora_curs_dia', '=', $dia)
                    ->where('hora_curs_hini', '=', $hini)->where('hora_curs_hfin', '=', $hfin)->where('grup_curs', '=', $grupoId)->exists();

                if (!$existeHorario) {
                    HorarioCurso::create([
                        'hora_curs_dia' => $dia,
                        'hora_curs_hini' => $hini,
                        'hora_curs_hfin' => $hfin,
                        'grup_curs' => $grupoId
                    ]);
                }
            }
            DB::commit();
            return to_route('horarios-cursos.index');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['err' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $path = request()->path();
        $basepath = preg_replace("/\/[0-9]+/", "/*", $path);
        $this->updateVisitCount($basepath);
        $visitas = Visitas::where('ruta', $basepath)->first();

        $grupoHorario = GrupoCurso::findOrFail($id);
        return view('content.pages.horarios.horario-curso-view', ['grupoHorario' => $grupoHorario, 'visitas' => $visitas]);
    }
    public function edit($id)
    {
        $path = request()->path();
        $basepath = preg_replace('/\/\d+/', '/*', $path);
        $this->updateVisitCount($basepath);
        $visitas = Visitas::where('ruta', $basepath)->first();

        $grupoHorario = GrupoCurso::findOrFail($id);
        $cursos = Curso::get();
        return view('content.pages.horarios.horario-curso-update', ['grupoHorario' => $grupoHorario, 'cursos' => $cursos, 'visitas' => $visitas]);
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'grup_curs_cod' => 'required | string',
                'curso' => 'required | numeric',

            ]
        )->validate();


        $horario = GrupoCurso::findOrFail($id);
        $horario->update($validator);
        return to_route('horarios-cursos.index');
    }

    public function destroy($id)
    {
        try {
            $grupoCurso = GrupoCurso::findOrFail($id);
            $grupoCurso->delete();
            return to_route('horarios-cursos.index');
        } catch (QueryException $e) {
            if ($e->getCode() == "23503") {
                return redirect()->back()->withErrors(['err' => 'No puedes eliminar el grupo-hotario, hay registros que dependen de el']);
            }
            return redirect()->back()->withErrors(['err' => 'Error de conexion intente mas tarde']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['err' => $e->getMessage()]);
        }
    }

    public function addOneSchedule(Request $request)
    {

        $validDays = ["lunes", "martes", "miercoles", "jueves", "viernes", "sabado", "domingo"];
        $validator = Validator::make(
            ['hora_curs_dia' => $request->hora_curs_dia, 'hora_curs_hini' => $request->hora_curs_hini, 'hora_curs_hfin' => $request->hora_curs_hfin, 'grup_curs' => $request->grupo_horario],
            [
                'hora_curs_dia' =>
                ['required', Rule::in($validDays)],
                'hora_curs_hini' => 'required | date_format:H:i',
                'hora_curs_hfin' => 'required | date_format:H:i| after:hora_curs_hini',
                'grup_curs' => 'required | numeric | exists:grupo_curso,grup_curs_id',
            ],
            [
                'hora_curs_hfin.after' => 'La hora final debe ser mayor a la hora inicial',
                'grup_curs.exists' => 'No hay datos de este grupo',
                'hora_curs_hfin.date_format' => 'Formato de hora incorrecto'
            ]
        );

        $validator->after(function ($validator) use ($request) {
            if (HorarioCurso::where('hora_curs_dia', '=', $request->hora_curs_dia)->where('hora_curs_hini', '=', $request->hora_curs_hini)->where('hora_curs_hfin', '=', $request->hora_curs_hfin)->where('grup_curs', '=', $request->grupo_horario)->exists()) {
                $validator->errors()->add('hora_curs_dia', 'Ya existe este horario en este curso');
            }
        });

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        HorarioCurso::create($validator->validate());
        return response()->json(['message' => 'Horario agregado correctamente']);
    }

    public function deleteSchedule($id)
    {
        $horario = HorarioCurso::find($id);
        if ($horario) {
            $horario->delete();
            return response()->json(['message' => 'Horario eliminado correctamente'], 200);
        }
        return response()->json(['errors' => 'El Horario no existe'], 404);
    }
}
