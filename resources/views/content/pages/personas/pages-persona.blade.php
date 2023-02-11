@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Listado de Personas')

@section('content-body')

<div>
    @include('layouts.sections.navbar.nav-search')

    @include('layouts.errors')


    <!-- Basic Bootstrap Table -->
    <a style="margin-bottom: 25px;" href="{{route('personas.create')}}" class="btn btn-primary">Registrar</a>

    <!--- Listado--->
    <div class="card">
        <div style="align-items: center; display: inline-flex; justify-content: space-between;">
            <h5 class="card-header">Listado de Personas Registradas </h5>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>C.I</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Profesion</th>
                        <th>Telefono</th>
                        <th>Celular</th>
                        <th>Email</th>
                        <th>Fecha Nacimiento</th>
                        <th>Lugar de Nacimiento</th>
                        <th>Tipo</th>
                        <th>Acciones</th>

                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($listaPersonas AS $persona)
                    <tr>
                        <td>{{ $persona -> per_ci}}</td>
                        <td>{{ $persona -> per_nom}}</td>
                        <td>{{ $persona -> per_appm}}</td>
                        <td>{{ $persona -> per_prof}}</td>
                        <td>{{ $persona -> per_telf}}</td>
                        <td>{{ $persona -> per_cel}}</td>
                        <td>{{ $persona -> per_email}}</td>
                        <td>{{ $persona -> per_fnac}}</td>
                        <td>{{ $persona -> per_lnac}}</td>
                        <td>{{ $persona -> tipo_us_nombre}}</td>

                        <td>
                            <div class="d-flex">
                                <a style="margin: 2px;" href="{{ route('personas.edit', $persona->per_id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('personas.destroy', $persona->per_id) }}" method="POST">
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
        {{ $listaPersonas -> appends(['busqueda'=> $busqueda]) }}
    </div>
</div>

@endsection
@section('visitas')
<code>Visitas: {{$visitas->contador}}</code>
@endsection