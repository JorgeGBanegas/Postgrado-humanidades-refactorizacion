@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Boleta de Inscripcion')

@section('content-body')


<div class="card">

    <div class="container" style="align-items: center; ">
        <div style="margin: 0px;">
            <h5 class="card-header" style="text-align: center;">Boleta de inscripcion</h5>
        </div>
        @if($tipo == 1)
        <label> <b> Fecha de Inscripcion: </b>{{$inscripcion->inscrip_program_fecha }}</label>
        <br>
        <label> <b> Estudiante: </b> {{$inscripcion->persona->per_nom }} {{$inscripcion->persona->per_appm}}</label>
        <br>
        <label> <b> C.I :</b> {{$inscripcion->persona->per_ci }}</label>
        <br>
        <label><b> Nombre del programa: </b>{{$inscripcion->program->program_nom }}</label>
        <br>
        <label><b> Grupo:</b> {{$inscripcion->grupo_programa->grup_program_cod }}</label>
        <br>
        <label><b> Version:</b> {{$inscripcion->grupo_programa->grup_program_vers }}</label>
        <br>
        <label><b> Edicion:</b> {{$inscripcion->grupo_programa->grup_program_edic }}</label>
        <br>
        <label><b> Horario:</b></label>
        <br>
        @foreach($inscripcion->grupo_programa->horario_programas as $horario)
        <label style="margin-left: 20px;">{{$horario->hora_program_dia }} [{{$horario->hora_program_hini }} - {{$horario->hora_program_hfin }}] </label>
        <br>
        @endforeach

        @else

        <label> <b> Fecha de Inscripcion: </b>{{$inscripcion->inscrip_curs_fecha }}</label>
        <br>
        <label> <b> Estudiante: </b> {{$inscripcion->persona->per_nom }} {{$inscripcion->persona->per_appm}}</label>
        <br>
        <label> <b> C.I :</b> {{$inscripcion->persona->per_ci }}</label>
        <br>
        <label><b> Nombre del curso: </b>{{$inscripcion->curs->curs_nom }}</label>
        <br>
        <label><b> Grupo:</b> {{$inscripcion->grupo_curso->grup_curs_cod }}</label>
        <br>
        <label><b> Horario:</b></label>
        <br>
        @foreach($inscripcion->grupo_curso->horario_cursos as $horario)
        <label style="margin-left: 20px;">{{$horario->hora_curs_dia }} [{{$horario->hora_curs_hini }} - {{$horario->hora_curs_hfin }}] </label>
        <br>
        @endforeach


        @endif
    </div>

</div>

@endsection