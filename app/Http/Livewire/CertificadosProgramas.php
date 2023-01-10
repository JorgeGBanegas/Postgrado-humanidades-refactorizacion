<?php

namespace App\Http\Livewire;

use App\Models\CertificadoPrograma;
use App\Models\InscripcionPrograma;
use Livewire\Component;
use Livewire\WithPagination;

class CertificadosProgramas extends Component
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

        $inscripciones = InscripcionPrograma::where('inscrip_program_estado', '=', 'true')->get();
        $certificados = CertificadoPrograma::join('persona', 'certificado_programa.estudiante', '=', 'persona.per_id')
            ->where('persona.per_nom', 'ilike', '%' . $this->search . '%')
            ->orwhere('persona.per_appm', 'ilike', '%' . $this->search . '%')
            ->paginate(5);
        return view('livewire.certificados-programas', [
            'certificados' => $certificados,
            'inscripciones' => $inscripciones
        ]);
    }
}
