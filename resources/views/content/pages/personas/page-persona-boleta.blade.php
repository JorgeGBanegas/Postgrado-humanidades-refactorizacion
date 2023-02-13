@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Boleta de Inscripcion')

@section('content-body')


<div class="card">

    <div class="container" style="align-items: center; ">
        <div style="margin: 0px;">
            <h5 class="card-header" style="text-align: center;">Boleta de inscripcion</h5>
        </div>
        @if($tipo == 1)
        <h6> <b> Fecha de Inscripcion: </b>{{$inscripcion->inscrip_program_fecha }}</h6>
        <h6> <b> Estudiante: </b> {{$inscripcion->persona->per_nom }} {{$inscripcion->persona->per_appm}}</h6>
        <h6> <b> C.I :</b> {{$inscripcion->persona->per_ci }}</h6>
        <h6><b> Nombre del programa: </b>{{$inscripcion->program->program_nom }}</h6>
        <h6><b> Grupo:</b> {{$inscripcion->grupo_programa->grup_program_cod }}</h6>
        <h6><b> Version:</b> {{$inscripcion->grupo_programa->grup_program_vers }}</h6>
        <h6><b> Edicion:</b> {{$inscripcion->grupo_programa->grup_program_edic }}</h6>
        <h6><b> Horario:</b></h6>
        @foreach($inscripcion->grupo_programa->horario_programas as $horario)
        <h6 style="margin-left: 20px;">{{$horario->hora_program_dia }} [{{$horario->hora_program_hini }} - {{$horario->hora_program_hfin }}] </h6>
        <br>
        @endforeach

        @else

        <h6> <b> Fecha de Inscripcion: </b>{{$inscripcion->inscrip_curs_fecha }}</h6>
        <h6> <b> Estudiante: </b> {{$inscripcion->persona->per_nom }} {{$inscripcion->persona->per_appm}}</h6>
        <h6> <b> C.I :</b> {{$inscripcion->persona->per_ci }}</h6>
        <h6><b> Nombre del curso: </b>{{$inscripcion->curs->curs_nom }}</h6>
        <h6><b> Grupo:</b> {{$inscripcion->grupo_curso->grup_curs_cod }}</h6>
        <h6><b> Horario:</b></h6>
        @foreach($inscripcion->grupo_curso->horario_cursos as $horario)
        <h6 style="margin-left: 20px;">{{$horario->hora_curs_dia }} [{{$horario->hora_curs_hini }} - {{$horario->hora_curs_hfin }}] </h6>
        <br>
        @endforeach


        @endif
    </div>

</div>
@if($tipo == 1)
<div class="container">
    <a type="button" style="margin-top: 20px;" class="btn btn-primary" href="{{route('inscripciones.index')}}">Volver</a>
</div>
@else
<div class="container">
    <a type="button" style="margin-top: 20px;" class="btn btn-primary" href="{{route('inscripcion-curso.index')}}">Volver</a>
</div>

@endif

@endsection


@section('visitas')
<code>Visitas: {{$visitas->contador}}</code>
@endsection