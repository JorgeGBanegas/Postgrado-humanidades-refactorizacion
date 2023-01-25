<?php

namespace App\Http\Livewire;

use App\Models\Descuento;
use App\Models\InscripcionPrograma;
use Livewire\Component;

class SelectDescuentos extends Component
{

    public $inscripciones = [];
    public $descuentos = [];
    public $selectedInscripciones;
    public $selectedDescuentos;
    public $selectedTipoPago = 0;
    public $precioConDescuento = 0;
    public $precioTotal = 0;


    public function render()
    {
        $this->inscripciones = InscripcionPrograma::where('inscrip_program_estado', true)->get();
        return view('livewire.select-descuentos', ['listaDeInscritos' => $this->inscripciones]);
    }

    public function updatedselectedInscripciones($id)
    {
        if (is_numeric($id)) {
            $inscrip = InscripcionPrograma::where('inscrip_program_nro', $id)->where('inscrip_program_estado', true)->first();
            if ($inscrip) {
                $this->descuentos = Descuento::where('program_id', $inscrip->program->program_id)->where('desc_est', true)->get();
            }
        }
    }

    public function updatedselectedDescuentos($id)
    {

        if (is_numeric($id)) {
            if ($id > 0) {
                $des = Descuento::findOrFail($id);
                $this->precioTotal = $des->programa->program_precio;
                $descuento = $this->precioTotal * ($des->desc_porce / 100);
                $this->precioConDescuento = $this->precioTotal - $descuento;
            } else {
                $inscrip = InscripcionPrograma::findOrFail($this->selectedInscripciones);
                $this->precioTotal = $inscrip->program->program_precio;
                $this->precioConDescuento = $inscrip->program->program_precio;
            }
        }
    }
}
