<?php

namespace App\Http\Livewire;

use App\Models\Curso;
use App\Models\InscripcionCurso;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Livewire\Component;

class GraficasInscritosCursos extends Component
{
    public $firstRun = true;
    public $cantidadesPorModalidad;
    public $modalidades;

    public $colores;

    public $cantidadesPorCurso;

    public $inscripciones;

    public function mount()
    {
        $this->cantidadesPorModalidad = [0, 0, 0];
        $this->modalidades = ['presencial', 'semipresencial', 'virtual'];

        $this->inscripciones = InscripcionCurso::where('inscrip_curs_estado', true)->get();
        $this->colores = [
            '#E74C3C', '#9B59B6', '#1ABC9C', '#F1C40F', '#E67E22', '#7F8C8D', '#2C3E50', '#17202A',
            '#7B241C', '#7D3C98', '#2471A3', '#0E6655', '#9A7D0A', '#34495E', '#0B5345', '#641E16',
            '#7B7D7D', '#154360', '#85C1E9', '#EC7063', '#58D68D', '#D35400', '#2980B9', '#A93226',
            '#5B2C6F', '#D4AC0D'
        ];

        $this->cantidadesPorCurso = [];
    }

    public function render()
    {

        $pieChartModel1 = $this->porModalidad();


        $pieChartModel3 = $this->porCurso();

        return view('livewire.graficas-inscritos-cursos')->with([
            'pieChartModel1' => $pieChartModel1,
            'pieChartModel3' => $pieChartModel3
        ]);
    }

    private function porModalidad()
    {
        //Por modalidad
        for ($i = 0; $i < sizeof($this->inscripciones); $i++) {
            $inscripcion = $this->inscripciones[$i];
            for ($j = 0; $j < sizeof($this->modalidades); $j++) {
                $mod = $this->modalidades[$j];
                if ($mod == $inscripcion->curs->curs_modalidad) {
                    $this->cantidadesPorModalidad[$j] += 1;
                }
            }
        }
        $pieChartModel1 = (new PieChartModel())
            ->setTitle('Inscritos por Modalidad')
            ->setAnimated($this->firstRun)
            ->withDataLabels();

        for ($i = 0; $i < sizeof($this->cantidadesPorModalidad); $i++) {
            $pieChartModel1->addSlice($this->modalidades[$i], $this->cantidadesPorModalidad[$i], $this->colores[$i]);
        }

        return $pieChartModel1;
    }

    private function porCurso()
    {
        $cursos = Curso::get();

        for ($i = 0; $i < sizeof($cursos); $i++) {
            $this->cantidadesPorCurso[$i] = 0;
        }

        //Por Porgrama
        for ($i = 0; $i < sizeof($this->inscripciones); $i++) {
            $inscripcion = $this->inscripciones[$i];
            for ($j = 0; $j < sizeof($cursos); $j++) {
                $curso = $cursos[$j];
                if ($curso->curs_id == $inscripcion->curso) {
                    $this->cantidadesPorCurso[$j] += 1;
                }
            }
        }

        $pieChartModel3 = (new PieChartModel())
            ->setTitle('Inscritos por Curso')
            ->setAnimated($this->firstRun)
            ->withDataLabels();

        for ($i = 0; $i < sizeof($this->cantidadesPorCurso); $i++) {
            $pieChartModel3->addSlice($cursos[$i]->curs_nom, $this->cantidadesPorCurso[$i], $this->colores[$i]);
        }

        return $pieChartModel3;
    }
}
