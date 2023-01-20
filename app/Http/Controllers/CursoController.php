<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCursosRequest;
use App\Models\Curso;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CursoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:' . config('variables.rol_admin') . '|' . config('variables.rol_admin_progr'));
    }

    public function index()
    {
        return view('content.pages.cursos.pages-cursos');
    }

    public function create()
    {
        return view('content.pages.cursos.pages-cursos-registro');
    }

    public function store(StoreCursosRequest $request)
    {

        Curso::create($request->all());
        return to_route('cursos.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $curso = Curso::findOrFail($id);
        return view('content.pages.cursos.pages-cursos-update', ['curso' => $curso]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'curs_nom'  => 'required | string | unique:curso,curs_nom,' . $id . ',curs_id',
                'curs_fini' => 'required | date | after:today',
                'curs_precio' => 'required | numeric | min:0',
                'curs_modalidad'
                => [
                    'required',
                    Rule::in(["presencial", "semipresencial", "virtual"])
                ],
                'curs_duracion' => 'required | numeric | min:1'
            ]
        )->validate();

        $curso = Curso::findOrFail($id);

        $curso->update($validator);
        return to_route('cursos.index');
    }

    public function destroy($id)
    {

        try {
            $curso = Curso::findOrFail($id);
            $curso->delete();
            return to_route('cursos.index');
        } catch (QueryException $e) {
            if ($e->getCode() == "23503") {
                return redirect()->back()->withErrors(['err' => 'No puedes eliminar el curso, hay registros que dependen de el']);
            }
            return redirect()->back()->withErrors(['err' => 'Error de conexion intente mas tarde']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['err' => $e->getMessage()]);
        }
    }
}
