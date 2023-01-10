<?php

namespace App\Http\Livewire;

use App\Models\Curso;
use App\Models\GrupoPrograma;
use App\Models\Programa;
use App\Models\HorarioPrograma;
use App\Models\GrupoCurso;
use App\Models\HorarioCurso;
use Livewire\Component;
use stdClass;

class SelectAnidado extends Component
{
    public $selectedTipoInscripcion;
    public $selectedPrograma;
    public $selectedCurso;
    public $selectedGrupos;


    public $programas = [];
    public $grupos = [];
    public $horarios = [];

    public function render()
    {
        $this->programas = Programa::get();

        return view('livewire.select-anidado', ['programas' => $this->programas]);
    }

    public function updatedselectedPrograma($id)
    {

        if (is_numeric($id)) {
            $this->grupos = GrupoPrograma::where('programa', [$id])->get();
        }
    }

    public function updatedselectedGrupos($id)
    {
        if (is_numeric($id)) {
            $this->horarios = HorarioPrograma::where('grup_program', [$id])->get();
        }
    }
}
