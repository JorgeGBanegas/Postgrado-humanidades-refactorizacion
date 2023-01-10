<?php

namespace App\Http\Controllers;

use App\Models\InscripcionCurso;
use App\Models\Persona;
use Illuminate\Http\Request;

class InscripcionCursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('content.pages.personas.pages-persona-inscritos-cursos');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estudiantes = Persona::where('per_tipo', [1])->get();
        return view('content.pages.personas.pages-persona-inscripcion-cursos', ['listaEstudiantes' => $estudiantes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inscripcion = InscripcionCurso::find($id);
        $tipo = 2;
        return view('content.pages.personas.page-persona-boleta', ['inscripcion' => $inscripcion], ['tipo' => $tipo]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $inscrCurso = InscripcionCurso::find($id);
        $inscrCurso->inscrip_curs_estado = false;
        $inscrCurso->save();
        return to_route('inscripcion-curso.index');
    }
}
