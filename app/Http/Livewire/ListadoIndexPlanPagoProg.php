<?php

namespace App\Http\Livewire;

use App\Models\InscripcionPrograma;
use App\Models\PlanDePago;
use Livewire\Component;
use Livewire\WithPagination;

class ListadoIndexPlanPagoProg extends Component
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
        $inscripciones = InscripcionPrograma::where('inscrip_program_estado', true)->get();
        $PlanesDePago = PlanDePago::join('inscripcion_programa', 'plan_de_pago.inscripcion', 'inscripcion_programa.inscrip_program_nro')
            ->join('persona', 'per_id', 'inscripcion_programa.estudiante')
            ->where(function ($q) {
                $q->where('persona.per_appm', 'ilike', '%' . $this->search . '%')
                    ->orwhere('persona.per_nom', 'ilike', '%' . $this->search . '%')
                    ->orwhere('persona.per_ci', 'ilike', '%' . $this->search . '%');
            })->whereNot('plan_pago_pagtot', 0)
            ->paginate(5);
        return view('livewire.listado-index-plan-pago-prog', [
            'PlanesDePago' => $PlanesDePago,
            'inscripciones' => $inscripciones
        ]);
    }
}
