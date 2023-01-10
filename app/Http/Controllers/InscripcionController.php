<?php

namespace App\Http\Controllers;

use App\Models\InscripcionCurso;
use App\Models\InscripcionPrograma;
use App\Models\Persona;
use App\Models\Programa;
use Illuminate\Http\Request;

class InscripcionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('content.pages.personas.pages-persona-inscritos');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estudiantes = Persona::where('per_tipo', [1])->get();
        return view('content.pages.personas.pages-persona-inscripcion', ['listaEstudiantes' => $estudiantes]);
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
        $inscripcion = InscripcionPrograma::find($id);
        $tipo = 1;
        return view('content.pages.personas.page-persona-boleta', ['inscripcion' => $inscripcion], ['tipo' => $tipo]);
    }


    public function destroyProgram($id)
    {
        $inscrProgram = InscripcionPrograma::find($id);
        $inscrProgram->inscrip_program_estado = false;
        $inscrProgram->save();
        return to_route('inscripciones.index');
    }
}
