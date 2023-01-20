<?php

namespace App\Http\Livewire;

use App\Models\Curso;
use Livewire\Component;
use Livewire\WithPagination;

class ListCursos extends Component
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

        $cursos = Curso::where('curs_nom', 'ilike', '%' . $this->search . '%')
            ->orwhere('curs_modalidad', 'ilike', '%' . $this->search . '%')
            ->orderBy('curs_id', 'DESC')
            ->paginate(5);
        return view('livewire.list-cursos', [
            'cursos' => $cursos
        ]);
    }
}
