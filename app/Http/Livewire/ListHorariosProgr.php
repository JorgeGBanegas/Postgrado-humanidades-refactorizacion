<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\HorarioPrograma;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ListHorariosProgr extends Component
{

    public $horarios;
    public $grupoHorario;

    public $hora_program_dia;
    public $hora_program_hini;
    public $hora_program_hfin;


    protected $listeners = [
        'agregarHorarios', 'actualizarHorarios'
    ];
    public function actualizarHorarios()
    {
        $this->horarios = HorarioPrograma::where('grup_program', '=', $this->grupoHorario->grup_program_id)->get();
    }

    public function mount()
    {

        $this->horarios = HorarioPrograma::where('grup_program', '=', $this->grupoHorario->grup_program_id)->get();
    }

    public function render()
    {
        return view('livewire.list-horarios-progr', ['horarios' => $this->horarios]);
    }

    public function agregarHorarios()
    {


        $validDays = ["lunes", "martes", "miercoles", "jueves", "viernes", "sabado", "domingo"];
        $validator = Validator::make(
            ['hora_program_dia' => $this->hora_program_dia, 'hora_program_hini' => $this->hora_program_hini, 'hora_program_hfin' => $this->hora_program_hfin, 'grup_program' => $this->grupoHorario->grup_program_id],
            [
                'hora_program_dia' =>
                ['required', Rule::in($validDays)],
                'hora_program_hini' => 'required | date_format:H:i',
                'hora_program_hfin' => 'required | date_format:H:i| after:hora_program_hini',
                'grup_program' => 'required | numeric | exists:grupo_programa,grup_program_id',
            ],
            [
                'hora_program_hfin.after' => 'La hora final debe ser mayor a la hora inicial',
                'grup_program.exists' => 'No hay datos de este grupo',
                'hora_program_hfin.date_format' => 'Formato de hora incorrecto'
            ]
        );

        $validator->after(function ($validator) {
            if (HorarioPrograma::where('hora_program_dia', '=', $this->hora_program_dia)->where('hora_program_hini', '=', $this->hora_program_hini)->where('hora_program_hfin', '=', $this->hora_program_hfin)->where('grup_program', '=', $this->grupoHorario->grup_program_id)->exists()) {
                $validator->errors()->add('hora_program_dia', 'Ya existe este horario en este programa');
            }
        });


        HorarioPrograma::create($validator->validate());
        $this->hora_program_dia = "";
        $this->hora_program_hini = "";
        $this->hora_program_hfin = "0";
        $this->resetErrorBag();
        $this->emit('actualizarHorarios');
    }

    public function eliminarHorario($id)
    {
        $horario = HorarioPrograma::findOrFail($id);
        $horario->delete();
        $this->emit('actualizarHorarios');
    }
}
