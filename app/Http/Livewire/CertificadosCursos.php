<?php

namespace App\Http\Livewire;

use App\Models\CertificadoCurso;
use App\Models\InscripcionCurso;
use Livewire\Component;
use Livewire\WithPagination;

class CertificadosCursos extends Component
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

        $inscripciones = InscripcionCurso::where('inscrip_curs_estado', '=', 'true')->get();
        $certificados = CertificadoCurso::join('persona', 'certificado_curso.estudiante', '=', 'persona.per_id')
            ->where('persona.per_nom', 'ilike', '%' . $this->search . '%')
            ->orwhere('persona.per_appm', 'ilike', '%' . $this->search . '%')
            ->paginate(5);
        return view('livewire.certificados-cursos', [
            'certificados' => $certificados,
            'inscripciones' => $inscripciones
        ]);
    }
}
