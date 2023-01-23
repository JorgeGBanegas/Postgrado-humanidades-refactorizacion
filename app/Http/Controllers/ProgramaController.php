<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgramaRequest;
use App\Models\ModuloPrograma;
use App\Models\Persona;
use App\Models\Programa;
use App\Models\Visitas;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProgramaController extends Controller
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

        return view('content.pages.programas.pages-programas', ['visitas' => $visitas]);
    }

    public function create()
    {
        $path = request()->path();
        $this->updateVisitCount($path);
        $visitas = Visitas::where('ruta', $path)->first();

        $docentes = Persona::where('per_tipo', '=', '2')->get();
        return view('content.pages.programas.pages-programas-registros', ['docentes' => $docentes, 'visitas' => $visitas]);
    }


    public function store(StoreProgramaRequest $request)
    {

        //Iniciar una transacción
        DB::beginTransaction();

        try {
            // Guardar el programa en la base de datos
            $programa = Programa::create([
                'program_nom' => $request->input('program_nom'),
                'program_precio' => $request->input('program_precio'),
                'program_modalidad' => $request->input('program_modalidad'),
                'program_tipo' => $request->input('program_tipo'),
            ]);

            $listaDeModulos = json_decode($request->modulos, true);
            // Guardar los módulos en la base de datos
            foreach ($listaDeModulos as $modulo) {
                $nro = $modulo['nro'];
                $nombre = $modulo['nombre'];
                $docente = $modulo['docente'];
                $programaId = $programa->program_id;
                $existeModulo = ModuloPrograma::where('mod_program_nom', '=', $nombre)
                    ->where('programa', '=', $programaId)
                    ->where('docente', '=', $docente)
                    ->get();
                if (sizeof($existeModulo) == 0) {
                    ModuloPrograma::create([
                        'mod_program_nro' => $nro,
                        'mod_program_nom' => $nombre,
                        'docente' => $docente,
                        'programa' => $programaId
                    ]);
                }
            }

            // Confirmar la transacción
            DB::commit();
            return to_route('programas.index');
        } catch (\Exception $e) {
            // Realizar un rollback
            DB::rollback();
            return redirect()->back()->withErrors(['err' => $e->getMessage()]);
        }
    }

    public function show($id)
    {

        $path = request()->path();
        $basepath = preg_replace("/\/[0-9]+/", "/*", $path);
        $this->updateVisitCount($basepath);
        $visitas = Visitas::where('ruta', $basepath)->first();

        $programa = Programa::findOrFail($id);
        return view('content.pages.programas.pages-programas-view', ['programa' => $programa, 'visitas' => $visitas]);
    }

    public function edit($id)
    {
        $programa = Programa::findOrFail($id);
        $docentes = Persona::where('per_tipo', '=', 2)->get();

        $path = request()->path();
        $basepath = preg_replace('/\/\d+/', '/*', $path);
        $this->updateVisitCount($basepath);
        $visitas = Visitas::where('ruta', $basepath)->first();

        return view('content.pages.programas.pages-programas-edit', ['programa' => $programa, 'docentes' => $docentes, 'visitas' => $visitas]);
    }

    public function update(Request $request, $id)
    {
        ///dd($request);
        $validator = Validator::make(
            $request->all(),
            [
                'program_nom'  => 'required | string | unique:programa,program_nom,' . $id . ',program_id',
                'program_precio'  => 'required | numeric | min:0',
                'program_tipo' => [
                    'required',
                    Rule::in(["diplomado", "maestria", "especialidad", "doctorado"])
                ],
                'program_modalidad' => [
                    'required',
                    Rule::in(["presencial", "semipresencial", "virtual"])
                ],
            ]
        )->validate();

        $programa = Programa::findOrFail($id);

        $programa->update($validator);
        return to_route('programas.index');
    }

    public function destroy($id)
    {
        try {
            $programa = Programa::findOrFail($id);
            $programa->delete();
            return to_route('programas.index');
        } catch (QueryException $e) {
            if ($e->getCode() == "23503") {
                return redirect()->back()->withErrors(['err' => 'No puedes eliminar el programa, hay registros que dependen de el']);
            }
            return redirect()->back()->withErrors(['err' => 'Error de conexion intente mas tarde']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['err' => $e->getMessage()]);
        }
    }
}
