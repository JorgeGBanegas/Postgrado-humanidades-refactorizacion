<?php

namespace App\Http\Livewire;

use App\Models\Persona;
use Illuminate\Support\Facades\Auth;
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

        $listaPersonas = $this->obtenerLista();

        return view('livewire.lista-personas', [
            'listaPersonas' => $listaPersonas
        ]);
    }

    private function obtenerLista()
    {
        $user = Auth::user();
        $listaPersonas = null;
        if ($user->hasRole(config('variables.rol_admin'))) {
            $listaPersonas = Persona::join('tipo_usuario', 'persona.per_tipo', 'tipo_usuario.tipo_us_id')
                ->where(function ($q) {
                    $q->where('persona.per_appm', 'ilike', '%' . $this->search . '%')
                        ->orwhere('persona.per_nom', 'ilike', '%' . $this->search . '%')
                        ->orwhere('persona.per_ci', 'ilike', '%' . $this->search . '%');
                })->where('per_tipo', '=', 1)->orwhere('per_tipo', '=', 2)->paginate(5);
        } else if ($user->hasRole(config('variables.rol_admin_progr'))) {
            $listaPersonas = Persona::join('tipo_usuario', 'persona.per_tipo', 'tipo_usuario.tipo_us_id')
                ->where(function ($q) {
                    $q->where('persona.per_appm', 'ilike', '%' . $this->search . '%')
                        ->orwhere('persona.per_nom', 'ilike', '%' . $this->search . '%')
                        ->orwhere('persona.per_ci', 'ilike', '%' . $this->search . '%');
                })->where('per_tipo', '=', 2)->paginate(5);
        } else if ($user->hasRole(config('variables.rol_admin_inscrip'))) {
            $listaPersonas = Persona::join('tipo_usuario', 'persona.per_tipo', 'tipo_usuario.tipo_us_id')
                ->where(function ($q) {
                    $q->where('persona.per_appm', 'ilike', '%' . $this->search . '%')
                        ->orwhere('persona.per_nom', 'ilike', '%' . $this->search . '%')
                        ->orwhere('persona.per_ci', 'ilike', '%' . $this->search . '%');
                })->where('per_tipo', '=', 1)->paginate(5);
        }
        return $listaPersonas;
    }
}
