<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGrupoHorarioCursosRequest;
use App\Models\Curso;
use App\Models\GrupoCurso;
use App\Models\HorarioCurso;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HorarioCursoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:' . config('variables.rol_admin') . '|' . config('variables.rol_admin_progr'));
    }

    public function index()
    {
        return view('content.pages.horarios.horario-curso');
    }

    public function create()
    {
        $cursos = Curso::get();
        return view('content.pages.horarios.horario-curso-registro', ['cursos' => $cursos]);
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
        $grupoHorario = GrupoCurso::findOrFail($id);
        return view('content.pages.horarios.horario-curso-view', ['grupoHorario' => $grupoHorario]);
    }
    public function edit($id)
    {
        $grupoHorario = GrupoCurso::findOrFail($id);
        $cursos = Curso::get();
        return view('content.pages.horarios.horario-curso-update', ['grupoHorario' => $grupoHorario, 'cursos' => $cursos]);
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
}
