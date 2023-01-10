<?php

namespace App\Http\Livewire;

use App\Models\Curso;
use App\Models\GrupoCurso;
use App\Models\HorarioCurso;
use Livewire\Component;

class SelectAnidadoCursos extends Component
{
    public $selectedCurso;
    public $selectedGrupos;


    public $cursos = [];
    public $grupos = [];
    public $horarios = [];

    public function render()
    {
        $this->cursos = Curso::get();

        return view('livewire.select-anidado-cursos', ['programas' => $this->cursos]);
    }

    public function updatedselectedCurso($id)
    {

        if (is_numeric($id)) {
            $this->grupos = GrupoCurso::where('curso', [$id])->get();
        }
    }

    public function updatedselectedGrupos($id)
    {
        if (is_numeric($id)) {
            $this->horarios = HorarioCurso::where('grup_curs', [$id])->get();
        }
    }
}
