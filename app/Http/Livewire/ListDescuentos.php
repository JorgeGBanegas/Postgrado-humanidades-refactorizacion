<?php

namespace App\Http\Livewire;

use App\Models\Descuento;
use Livewire\Component;
use Livewire\WithPagination;

class ListDescuentos extends Component
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
        $descuentos = Descuento::join('programa', 'programa.program_id', 'descuento.program_id')
            ->where(function ($q) {
                $q->where('programa.program_nom', 'ilike', '%' . $this->search . '%')
                    ->orwhere('descuento.desc_motivo', 'ilike', '%' . $this->search . '%')
                    ->orwhere('descuento.desc_descrip', 'ilike', '%' . $this->search . '%');
            })->orderBy('descuento.desc_id', 'DESC')->paginate(5);

        return view('livewire.list-descuentos', [
            'descuentos' => $descuentos
        ]);
    }
}
