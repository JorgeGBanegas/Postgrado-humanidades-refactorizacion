<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EstadisticasControler extends Controller
{

    public function programas()
    {
        return view('content.pages.graficos.grafico-inscripcion-programa');
    }

    public function cursos()
    {
        return view('content.pages.graficos.grafico-inscripcion-curso');
    }
}
