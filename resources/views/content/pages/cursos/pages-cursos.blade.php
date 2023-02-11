@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Listado de Cursos')

@section('content-body')

<div>
    @include('layouts.sections.navbar.nav-search')

    @include('layouts.errors')


    <!-- Basic Bootstrap Table -->
    <a style="margin-bottom: 25px;" href="{{route('cursos.create')}}" class="btn btn-primary">Registrar</a>

    <!--- Listado--->
    <div class="card">
        <div style="align-items: center; display: inline-flex; justify-content: space-between;">
            <h5 class="card-header">Listado de Cursos Registrados </h5>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha de inicio</th>
                        <th>precio</th>
                        <th>Modalidad</th>
                        <th>Duracion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($cursos AS $curso)
                    <tr>
                        <td>{{ $curso->curs_nom}}</td>
                        <td>{{ $curso->curs_fini}}</td>
                        <td>{{ $curso->curs_precio}} Bs.</td>
                        <td>{{ $curso->curs_modalidad}}</td>
                        <td>{{ $curso->curs_duracion}} Horas</td>
                        <td>
                            <div class="d-flex">
                                <a style="margin: 2px;" href="{{route('cursos.show', $curso->curs_id)}}" class="btn btn-primary btn-sm">Ver</a>
                                <a style="margin: 2px;" href="{{route('cursos.edit', $curso->curs_id)}}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{route('cursos.destroy',$curso->curs_id)}}" method="POST">
                                    @csrf()
                                    @method('DELETE')
                                    <button type="submit" style="margin: 2px;" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="container" style="margin-top:20px">
        {{ $cursos -> appends(['busqueda'=> $busqueda]) }}
    </div>
</div>

@endsection
@section('visitas')
<code>Visitas: {{$visitas->contador}}</code>
@endsection