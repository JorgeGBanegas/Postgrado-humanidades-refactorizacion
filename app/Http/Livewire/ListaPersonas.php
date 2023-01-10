<?php

namespace App\Http\Livewire;

use App\Models\Persona;
use Livewire\Component;
use Livewire\WithPagination;

class ListaPersonas extends Component
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

        $listaPersonas = Persona::join('tipo_usuario', 'persona.per_tipo', 'tipo_usuario.tipo_us_id')
            ->where('persona.per_appm', 'ilike', '%' . $this->search . '%')
            ->orwhere('persona.per_nom', 'ilike', '%' . $this->search . '%')
            ->orwhere('persona.per_ci', 'ilike', '%' . $this->search . '%')

            ->paginate(5);
        return view('livewire.lista-personas', [
            'listaPersonas' => $listaPersonas
        ]);
    }
}
