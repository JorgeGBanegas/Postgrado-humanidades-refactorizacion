<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EstadisticasControler extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:' . config('variables.rol_admin'));
    }

    public function programas()
    {
        return view('content.pages.graficos.grafico-inscripcion-programa');
    }

    public function cursos()
    {
        return view('content.pages.graficos.grafico-inscripcion-curso');
    }
}
