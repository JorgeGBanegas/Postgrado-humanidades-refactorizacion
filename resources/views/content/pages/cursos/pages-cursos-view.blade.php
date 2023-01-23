@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Ver Curso')

@section('content-body')

@include('layouts.errors')
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header ">
                <h4 class="mb-0">Datos del Curso</h4> <small class="text-muted float-end"></small>
            </div>
            <div class="card-body">
                <h5 class="mb-2"><b> Nombre : </b> {{$curso->curs_nom}}</h5>
                <h5 class="mb-2"><b> Fecha de Inicio : </b> {{$curso->curs_fini}}</h5>
                <h5 class="mb-2"><b> Precio : </b> {{$curso->curs_precio}} Bs.</h5>
                <h5 class="mb-2"><b> Modalidad:</b> {{$curso->curs_modalidad}}</h5>
                <h5 class="mb-2"><b> Duracion : </b> {{$curso->curs_duracion}}</h5>

                <!-- Table within card -->
                <h5 class="mb-4"><b> Grupos-Horarios: </b></h5>
                <div class="table-responsive text-nowrap">
                    <table class="table card-table">
                        <thead>
                            <tr>
                                <th>Codigo Grupo</th>
                                <th>Horario</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($curso->grupo_cursos as $grupo)
                            <tr>
                                <td>{{ $grupo-> grup_curs_cod}}</td>
                                <td>
                                    @foreach($grupo->horario_cursos as $horario)
                                    <p>{{ substr($horario->hora_curs_dia,0,3) }} [{{ date("H:i", strtotime($horario->hora_curs_hini)) }} - {{ date("H:i", strtotime($horario->hora_curs_hfin)) }}]
                                    </p>
                                    @endforeach
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <form action="{{ route('cursos.index') }}" method="get">
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