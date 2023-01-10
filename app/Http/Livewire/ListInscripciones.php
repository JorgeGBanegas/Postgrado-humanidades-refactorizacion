<?php

namespace App\Http\Livewire;

use App\Models\InscripcionCurso;
use App\Models\InscripcionPrograma;
use Livewire\Component;
use Livewire\WithPagination;

class ListInscripciones extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {

        $inscritos = InscripcionPrograma::join('persona', 'per_id', 'inscripcion_programa.estudiante')
            ->where(function ($q) {
                $q->where('persona.per_appm', 'ilike', '%' . $this->search . '%')
                    ->orwhere('persona.per_nom', 'ilike', '%' . $this->search . '%')
                    ->orwhere('persona.per_ci', 'ilike', '%' . $this->search . '%');
            })->where('inscrip_program_estado', '=', 'true')->paginate(5);

        return view('livewire.list-inscripciones', [
            'inscritos' => $inscritos
        ]);
    }
}
