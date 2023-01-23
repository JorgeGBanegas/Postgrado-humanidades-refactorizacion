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

    public function index()
    {
        $path = request()->path();
        $this->updateVisitCount($path);
        $visitas = Visitas::where('ruta', $path)->first();

        return view('content.pages.horarios.horario-programa', ['visitas' => $visitas]);
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
}
