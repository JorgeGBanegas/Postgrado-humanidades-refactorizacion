@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Listado de Descuentos')

@section('content-body')

<div>
    @include('layouts.sections.navbar.nav-search')

    @include('layouts.errors')


    <!-- Basic Bootstrap Table -->
    <a style="margin-bottom: 25px;" href="{{route('descuentos.create')}}" class="btn btn-primary">Registrar</a>

    <!--- Listado--->
    <div class="card">
        <div style="align-items: center; display: inline-flex; justify-content: space-between;">
            <h5 class="card-header">Listado de Descuentos Registrados </h5>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Motivo</th>
                        <th>Descripcion</th>
                        <th>Porcentaje</th>
                        <th>Programa</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($descuentos AS $descuento)
                    <tr>
                        <td>{{ $descuento -> desc_motivo}}</td>
                        <td>{{ $descuento -> desc_descrip}}</td>
                        <td>{{ $descuento -> desc_porce}} %</td>
                        <td>{{ $descuento -> programa ->program_nom}}</td>
                        @if($descuento -> desc_est)
                        <td>
                            <a style="margin: 2px;" href="{{route('descuentos.changeStatus', $descuento->desc_id)}}">
                                <span class="badge bg-label-success me-1">Activo</span>
                            </a>
                        </td>
                        @else
                        <td>
                            <a style="margin: 2px;" href="{{route('descuentos.changeStatus',$descuento->desc_id)}}">
                                <span class="badge bg-label-danger me-1">Inactivo</span>
                            </a>
                        </td>
                        @endif
                        <td>
                            <div class="d-flex">
                                <a style="margin: 2px;" href="{{ route('descuentos.edit', $descuento->desc_id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('descuentos.destroy', $descuento->desc_id) }}" method="POST">
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
        {{ $descuentos -> appends(['busqueda'=> $busqueda]) }}
    </div>
</div>
@endsection
@section('visitas')
<code>Visitas: {{$visitas->contador}}</code>
@endsection