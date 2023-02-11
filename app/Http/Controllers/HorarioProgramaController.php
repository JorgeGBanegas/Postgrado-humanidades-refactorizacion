<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGrupoHorarioProgramasRequest;
use App\Models\GrupoPrograma;
use App\Models\HorarioPrograma;
use App\Models\Programa;
use App\Models\Visitas;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HorarioProgramaController extends Controller
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

        $gruposHorarios = GrupoPrograma::join('programa', 'program_id', 'grupo_programa.programa')
            ->where(function ($q) use ($search) {
                $q->where('grup_program_cod', 'ilike', '%' . $search . '%')
                    ->orWhere('grup_program_vers', 'ilike', '%' . $search . '%')
                    ->orWhere('grup_program_edic', 'ilike', '%' . $search . '%')
                    ->orWhere('programa.program_nom', 'ilike', '%' . $search . '%');
            })
            //            ->orderBy('programa.program_nom', 'ASC')
            ->orderBy('grup_program_id', 'DESC')
            ->paginate(5);
        return view('content.pages.horarios.horario-programa', ['gruposHorarios' => $gruposHorarios, 'visitas' => $visitas, 'ruta' => $route, 'busqueda' => $search]);
    }

    public function create()
    {
        $path = request()->path();
        $this->updateVisitCount($path);
        $visitas = Visitas::where('ruta', $path)->first();

        $programas = Programa::get();
        return view('content.pages.horarios.horario-programa-registro', ['programas' => $programas, 'visitas' => $visitas]);
    }

    public function store(StoreGrupoHorarioProgramasRequest $request)
    {
        DB::beginTransaction();
        try {


            $existeGrupo =
                GrupoPrograma::where('grup_program_cod', '=', $request->input('grup_program_cod'))
                ->where('programa', '=', $request->input('programa'))
                ->where('grup_program_vers', '=', $request->input('grup_program_vers'))
                ->where('grup_program_edic', '=', $request->input('grup_program_edic'))
                ->exists();

            if ($existeGrupo) {
                return redirect()->back()->withErrors(['err' => 'Ya existe un grupo con este codigo en este programa']);
            }

            $grupo = GrupoPrograma::create([
                'grup_program_cod' => $request->input('grup_program_cod'),
                'grup_program_vers' => $request->input('grup_program_vers'),
                'grup_program_edic' => $request->input('grup_program_edic'),
                'grup_program_fini' => $request->input('grup_program_fini'),
                'programa' => $request->input('programa'),
            ]);
            $listaDeHorarios =  json_decode($request->horarios, true);
            foreach ($listaDeHorarios as $horario) {
                $dia = $horario['dia'];
                $hini = $horario['hini'];
                $hfin = $horario['hfin'];
                $grupoId = $grupo->grup_program_id;

                $existeHorario = HorarioPrograma::where('hora_program_dia', '=', $dia)
                    ->where('hora_program_hini', '=', $hini)->where('hora_program_hfin', '=', $hfin)->where('grup_program', '=', $grupoId)->exists();

                if (!$existeHorario) {
                    HorarioPrograma::create([
                        'hora_program_dia' => $dia,
                        'hora_program_hini' => $hini,
                        'hora_program_hfin' => $hfin,
                        'grup_program' => $grupoId
                    ]);
                }
            }
            DB::commit();
            return to_route('horarios-programas.index');
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

        $grupoHorario = GrupoPrograma::findOrFail($id);
        return view('content.pages.horarios.horario-programa-view', ['grupoHorario' => $grupoHorario, 'visitas' => $visitas]);
    }
    public function edit($id)
    {
        $path = request()->path();
        $basepath = preg_replace('/\/\d+/', '/*', $path);
        $this->updateVisitCount($basepath);
        $visitas = Visitas::where('ruta', $basepath)->first();

        $grupoHorario = GrupoPrograma::findOrFail($id);
        $programas = Programa::get();
        return view('content.pages.horarios.horario-programa-update', ['grupoHorario' => $grupoHorario, 'programas' => $programas, 'visitas' => $visitas]);
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'grup_program_cod' => 'required | string',
                'grup_program_vers' => 'required | string',
                'grup_program_edic' => 'required | string',
                'grup_program_fini' => 'required | date ',
                'programa' => 'required | numeric',

            ]
        )->validate();


        $horario = GrupoPrograma::findOrFail($id);
        $horario->update($validator);
        return to_route('horarios-programas.index');
    }

    public function destroy($id)
    {
        try {
            $grupoPrograma = GrupoPrograma::findOrFail($id);
            $grupoPrograma->delete();
            return to_route('horarios-programas.index');
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
            ['hora_program_dia' => $request->hora_program_dia, 'hora_program_hini' => $request->hora_program_hini, 'hora_program_hfin' => $request->hora_program_hfin, 'grup_program' => $request->grupo_horario],
            [
                'hora_program_dia' =>
                ['required', Rule::in($validDays)],
                'hora_program_hini' => 'required | date_format:H:i',
                'hora_program_hfin' => 'required | date_format:H:i| after:hora_program_hini',
                'grup_program' => 'required | numeric | exists:grupo_programa,grup_program_id',
            ],
            [
                'hora_program_hfin.after' => 'La hora final debe ser mayor a la hora inicial',
                'grup_program.exists' => 'No hay datos de este grupo',
                'hora_program_hfin.date_format' => 'Formato de hora incorrecto'
            ]
        );

        $validator->after(function ($validator) use ($request) {
            if (HorarioPrograma::where('hora_program_dia', '=', $request->hora_program_dia)->where('hora_program_hini', '=', $request->hora_program_hini)->where('hora_program_hfin', '=', $request->hora_program_hfin)->where('grup_program', '=', $request->grupo_horario)->exists()) {
                $validator->errors()->add('hora_program_dia', 'Ya existe este horario en este programa');
            }
        });

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        HorarioPrograma::create($validator->validate());
        return response()->json(['message' => 'Horario agregado correctamente']);
    }

    public function deleteSchedule($id)
    {
        $horario = HorarioPrograma::find($id);
        if ($horario) {
            $horario->delete();
            return response()->json(['message' => 'Horario eliminado correctamente'], 200);
        }
        return response()->json(['errors' => 'El Horario no existe'], 404);
    }
}
