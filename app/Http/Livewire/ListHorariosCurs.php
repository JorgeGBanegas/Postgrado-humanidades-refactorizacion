<?php

namespace App\Http\Livewire;

use App\Models\HorarioCurso;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ListHorariosCurs extends Component
{
    public $horarios;
    public $grupoHorario;

    public $hora_curs_dia;
    public $hora_curs_hini;
    public $hora_curs_hfin;


    protected $listeners = [
        'agregarHorarios', 'actualizarHorarios'
    ];
    public function actualizarHorarios()
    {
        $this->horarios = HorarioCurso::where('grup_curs', '=', $this->grupoHorario->grup_curs_id)->get();
    }

    public function mount()
    {

        $this->horarios = HorarioCurso::where('grup_curs', '=', $this->grupoHorario->grup_curs_id)->get();
    }

    public function render()
    {
        return view('livewire.list-horarios-curs', ['horarios' => $this->horarios]);
    }

    public function agregarHorarios()
    {


        $validDays = ["lunes", "martes", "miercoles", "jueves", "viernes", "sabado", "domingo"];
        $validator = Validator::make(
            ['hora_curs_dia' => $this->hora_curs_dia, 'hora_curs_hini' => $this->hora_curs_hini, 'hora_curs_hfin' => $this->hora_curs_hfin, 'grup_curs' => $this->grupoHorario->grup_curs_id],
            [
                'hora_curs_dia' =>
                ['required', Rule::in($validDays)],
                'hora_curs_hini' => 'required | date_format:H:i',
                'hora_curs_hfin' => 'required | date_format:H:i| after:hora_curs_hini',
                'grup_curs' => 'required | numeric | exists:grupo_curso,grup_curs_id',
            ],
            [
                'hora_curs_hfin.after' => 'La hora final debe ser mayor a la hora inicial',
                'grup_curs.exists' => 'No hay datos de este grupo',
                'hora_curs_hfin.date_format' => 'Formato de hora incorrecto'
            ]
        );

        $validator->after(function ($validator) {
            if (HorarioCurso::where('hora_curs_dia', '=', $this->hora_curs_dia)->where('hora_curs_hini', '=', $this->hora_curs_hini)->where('hora_curs_hfin', '=', $this->hora_curs_hfin)->where('grup_curs', '=', $this->grupoHorario->grup_curs_id)->exists()) {
                $validator->errors()->add('hora_curs_dia', 'Ya existe este horario en este curso');
            }
        });


        HorarioCurso::create($validator->validate());
        $this->hora_curs_dia = "";
        $this->hora_curs_hini = "";
        $this->hora_curs_hfin = "0";
        $this->resetErrorBag();
        $this->emit('actualizarHorarios');
    }

    public function eliminarHorario($id)
    {
        $horario = HorarioCurso::findOrFail($id);
        $horario->delete();
        $this->emit('actualizarHorarios');
    }
}
