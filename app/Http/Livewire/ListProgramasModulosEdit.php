<?php

namespace App\Http\Livewire;

use App\Models\ModuloPrograma;
use App\Models\Persona;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Livewire\WithMagicActions;

use Livewire\Component;

class ListProgramasModulosEdit extends Component
{

    public $modulos;
    public $docentes = [];
    public $progr;

    public $mod_program_nro;
    public $mod_program_nom;
    public $docente;
    public $programa;


    protected $listeners = [
        'agregarModulos', 'actualizarModulos'
    ];
    public function actualizarModulos()
    {
        $this->modulos = ModuloPrograma::where('programa', '=', $this->progr->program_id)->get();
    }

    public function mount()
    {
        $this->docentes = Persona::where('per_tipo', '=', 2)->get();
        $this->modulos = ModuloPrograma::where('programa', '=', $this->progr->program_id)->get();
    }

    public function render()
    {
        return view('livewire.list-programas-modulos-edit', ['modulos' => $this->modulos, 'docentes' => $this->docentes]);
    }

    public function agregarModulos()
    {
        $validator = Validator::make(
            ['mod_program_nro' => $this->mod_program_nro, 'mod_program_nom' => $this->mod_program_nom, 'docente' => $this->docente, 'programa' => $this->progr->program_id],
            [
                'mod_program_nro' => 'required | numeric | min: 1',
                'mod_program_nom' => 'required | string',
                'docente' => 'required | numeric | exists:persona,per_id',
                'programa' => 'required | numeric | exists:programa,program_id',
            ],
            [
                'docente.exists' => 'No hay datos de este docente',
                'programa.exists' => 'No hay datos de este programa',
            ]
        );

        $validator->after(
            function ($validator) {
                if (ModuloPrograma::where('mod_program_nom', '=', $this->mod_program_nom)->where('docente', '=', $this->docente)->where('programa', '=', $this->progr->program_id)->exists()) {
                    $validator->errors()->add('mod_program_nom', 'Ya existe un módulo con el mismo nombre, programa y docente');
                }
            }
        );


        ModuloPrograma::create($validator->validate());
        $this->mod_program_nro = "";
        $this->mod_program_nom = "";
        $this->docente = "0";
        $this->resetErrorBag();
        $this->emit('actualizarModulos');
    }

    public function eliminarModulo($id)
    {
        $modulo = ModuloPrograma::findOrFail($id);
        $modulo->delete();
        $this->emit('actualizarModulos');
    }
}
