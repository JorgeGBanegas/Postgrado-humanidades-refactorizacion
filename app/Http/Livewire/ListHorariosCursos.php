<?php

namespace App\Http\Livewire;

use App\Models\GrupoCurso;
use Livewire\Component;
use Livewire\WithPagination;

class ListHorariosCursos extends Component
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

        $gruposHorarios = GrupoCurso::join('curso', 'curs_id', 'grupo_curso.curso')
            ->where(function ($q) {
                $q->where('grup_curs_cod', 'ilike', '%' . $this->search . '%')
                    ->orWhere('curso.curs_nom', 'ilike', '%' . $this->search . '%');
            })
            //            ->orderBy('curso.curs_nom', 'ASC')
            ->orderBy('grup_curs_id', 'DESC')
            ->paginate(5);
        return view('livewire.list-horarios-cursos', [
            'gruposHorarios' => $gruposHorarios
        ]);
    }
}
