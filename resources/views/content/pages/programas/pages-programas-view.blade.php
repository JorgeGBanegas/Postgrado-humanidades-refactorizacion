@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Registrar Programa')

@section('content-body')

@include('layouts.errors')
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header ">
                <h4 class="mb-0">Datos del Programa</h4> <small class="text-muted float-end"></small>
            </div>
            <div class="card-body">
                <h5 class="mb-2"><b> Nombre : </b>{{$programa->program_nom}}</h5>
                <h5 class="mb-2"><b> Precio : </b> {{$programa->program_precio}} Bs.</h5>
                <h5 class="mb-2"><b> Modalidad:</b> {{$programa->program_modalidad}}</h5>
                <h5 class="mb-2"><b> Tipo : </b> {{$programa->program_tipo}}</h5>

                <!-- Table within card -->
                <h5 class="mb-4"><b> Modulos </b></h5>
                <div class="table-responsive text-nowrap">
                    <table class="table card-table">
                        <thead>
                            <tr>
                                <th>Nro</th>
                                <th>Nombre</th>
                                <th>Docente</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($programa->modulo_programas as $modulo)
                            <tr>
                                <td>{{ $modulo -> mod_program_nro}}</td>
                                <td>{{ $modulo -> mod_program_nom}}</td>
                                <td>{{ $modulo -> persona -> per_nom . " ". $modulo -> persona -> per_appm}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <form action="{{ route('programas.index') }}" method="get">
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