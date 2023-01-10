<?php

namespace App\Http\Livewire;

use App\Models\Pago;
use Livewire\Component;
use stdClass;

class ListaPagos extends Component
{

    public $selectTipoPago;
    //Es al contado por defecto
    public $tipoPago = true;
    public $plan;

    public $listaPagos = [];

    public function mount()
    {

        $this->listaPagos = Pago::where('plan_pago', '=', $this->plan->plan_pago_nro)->get();
    }
    public function render()
    {
        return view('livewire.lista-pagos', ['listaPagos' => $this->listaPagos]);
    }

    public function updatedselectTipoPago($tipo)
    {
        if ($tipo == 1) {
            $this->tipoPago = true;
        } else {
            $this->tipoPago = false;
        }
    }
}
