@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Ver Grupo-Horario')

@section('content-body')

@include('layouts.errors')
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header ">
                <h4 class="mb-0">Datos del Grupo-Horario</h4> <small class="text-muted float-end"></small>
            </div>
            <div class="card-body">
                <h5 class="mb-2"><b> Codigo : </b> {{$grupoHorario->grup_program_cod}}</h5>
                <h5 class="mb-2"><b> Version : </b> {{$grupoHorario->grup_program_vers}}</h5>
                <h5 class="mb-2"><b> Edicion:</b> {{$grupoHorario->grup_program_edic}}</h5>
                <h5 class="mb-2"><b> Fecha de Inicion : </b> {{$grupoHorario->grup_program_fini}}</h5>
                <h5 class="mb-2"><b> Programa : </b> {{$grupoHorario->program->program_nom}}</h5>

                <!-- Table within card -->
                <h5 class="mb-4"><b> Horarios: </b></h5>
                <div class="table-responsive text-nowrap">
                    <table class="table card-table">
                        <thead>
                            <tr>
                                <th>Dia</th>
                                <th>Hora de Inicio</th>
                                <th>Hora de fin</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($grupoHorario->horario_programas as $horario)
                            <tr>
                                <td>{{ $horario-> hora_program_dia}}</td>
                                <td>{{ date("H:i", strtotime($horario->hora_program_hini))}}</td>
                                <td>{{ date("H:i", strtotime($horario->hora_program_hfin))}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <form action="{{ route('horarios-programas.index') }}" method="get">
                    <button style="margin-top: 25px;" class="btn btn-primary" type="submit">Volver</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
@section('visitas')
<code>Visitas: {{$visitas->contador}}</code>
@endsection