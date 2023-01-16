<?php

namespace App\Http\Livewire;

use App\Models\Programa;
use Livewire\Component;
use Livewire\WithPagination;

class ListProgramas extends Component
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

        $programas = Programa::where('program_nom', 'ilike', '%' . $this->search . '%')
            ->orwhere('program_tipo', 'ilike', '%' . $this->search . '%')
            ->orwhere('program_modalidad', 'ilike', '%' . $this->search . '%')

            ->paginate(5);
        return view('livewire.list-programas', [
            'programas' => $programas
        ]);
    }
}
