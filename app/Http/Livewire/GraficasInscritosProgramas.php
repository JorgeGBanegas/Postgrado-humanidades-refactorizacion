<?php

namespace App\Http\Livewire;

use App\Models\InscripcionPrograma;
use App\Models\Programa;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Livewire\Component;

class GraficasInscritosProgramas extends Component
{
    public $firstRun = true;
    public $cantidadesPorModalidad;
    public $modalidades;
    public $cantidadesPorTipoPrograma;
    public $tipoPrograma;
    public $colores;

    public $cantidadesPorPrograma;

    public $inscripciones;

    public function mount()
    {
        $this->cantidadesPorModalidad = [0, 0, 0];
        $this->modalidades = ['presencial', 'semipresencial', 'virtual'];
        $this->cantidadesPorTipoPrograma = [0, 0, 0, 0];
        $this->tipoPrograma = ['diplomado', 'maestria', 'doctorado', 'especialidad'];
        $this->inscripciones = InscripcionPrograma::where('inscrip_program_estado', true)->get();
        $this->colores = [
            '#E74C3C', '#9B59B6', '#1ABC9C', '#F1C40F', '#E67E22', '#7F8C8D', '#2C3E50', '#17202A',
            '#7B241C', '#7D3C98', '#2471A3', '#0E6655', '#9A7D0A', '#34495E', '#0B5345', '#641E16',
            '#7B7D7D', '#154360', '#85C1E9', '#EC7063', '#58D68D', '#D35400', '#2980B9', '#A93226',
            '#5B2C6F', '#D4AC0D'
        ];

        $this->cantidadesPorPrograma = [];
    }

    public function render()
    {

        $pieChartModel1 = $this->porModalidad();

        $pieChartModel2 = $this->porTipoDePrograma();

        $pieChartModel3 = $this->porPrograma();

        return view('livewire.graficas-inscritos-programas')->with([
            'pieChartModel1' => $pieChartModel1,
            'pieChartModel2' => $pieChartModel2,
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
                if ($mod == $inscripcion->program->program_modalidad) {
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

    private function porTipoDePrograma()
    {
        //Por tipo de programa
        for ($i = 0; $i < sizeof($this->inscripciones); $i++) {
            $inscripcion = $this->inscripciones[$i];
            for ($j = 0; $j < sizeof($this->tipoPrograma); $j++) {
                $tp = $this->tipoPrograma[$j];
                if ($tp == $inscripcion->program->program_tipo) {
                    $this->cantidadesPorTipoPrograma[$j] += 1;
                }
            }
        }
        $pieChartModel2 = (new PieChartModel())
            ->setTitle('Inscritos por Tipo de Programa')
            ->setAnimated($this->firstRun)
            ->withDataLabels();

        for ($i = 0; $i < sizeof($this->cantidadesPorTipoPrograma); $i++) {
            $pieChartModel2->addSlice($this->tipoPrograma[$i], $this->cantidadesPorTipoPrograma[$i], $this->colores[$i]);
        }

        return $pieChartModel2;
    }

    private function porPrograma()
    {
        $programas = Programa::get();

        for ($i = 0; $i < sizeof($programas); $i++) {
            $this->cantidadesPorPrograma[$i] = 0;
        }

        //Por Porgrama
        for ($i = 0; $i < sizeof($this->inscripciones); $i++) {
            $inscripcion = $this->inscripciones[$i];
            for ($j = 0; $j < sizeof($programas); $j++) {
                $programa = $programas[$j];
                if ($programa->program_id == $inscripcion->programa) {
                    $this->cantidadesPorPrograma[$j] += 1;
                }
            }
        }

        $pieChartModel3 = (new PieChartModel())
            ->setTitle('Inscritos por Programa')
            ->setAnimated($this->firstRun)
            ->withDataLabels();

        for ($i = 0; $i < sizeof($this->cantidadesPorPrograma); $i++) {
            $pieChartModel3->addSlice($programas[$i]->program_nom, $this->cantidadesPorPrograma[$i], $this->colores[$i]);
        }

        return $pieChartModel3;
    }
}
