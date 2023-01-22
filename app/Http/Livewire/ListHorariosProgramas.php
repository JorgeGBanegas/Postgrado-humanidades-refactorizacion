<?php

namespace App\Http\Livewire;

use App\Models\GrupoPrograma;
use App\Models\HorarioPrograma;
use Livewire\Component;
use Livewire\WithPagination;

class ListHorariosProgramas extends Component
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

        $gruposHorarios = GrupoPrograma::join('programa', 'program_id', 'grupo_programa.programa')
            ->where(function ($q) {
                $q->where('grup_program_cod', 'ilike', '%' . $this->search . '%')
                    ->orWhere('grup_program_vers', 'ilike', '%' . $this->search . '%')
                    ->orWhere('grup_program_edic', 'ilike', '%' . $this->search . '%')
                    ->orWhere('programa.program_nom', 'ilike', '%' . $this->search . '%');
            })
            //            ->orderBy('programa.program_nom', 'ASC')
            ->orderBy('grup_program_id', 'DESC')
            ->paginate(5);
        return view('livewire.list-horarios-programas', [
            'gruposHorarios' => $gruposHorarios
        ]);
    }
}
