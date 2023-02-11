@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Listado de Usuarios')

@section('content-body')

<div>
    @include('layouts.sections.navbar.nav-search')

    @include('layouts.errors')


    <!-- Basic Bootstrap Table -->
    <a style="margin-bottom: 25px;" href="{{route('register')}}" class="btn btn-primary">Registrar</a>

    <!--- Listado--->
    <div class="card">
        <div style="align-items: center; display: inline-flex; justify-content: space-between;">
            <h5 class="card-header">Listado de Personas Registradas </h5>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($users AS $user)
                    <tr>
                        <td>{{ $user -> name}}</td>
                        <td>{{ $user -> last_name}}</td>
                        <td>{{ $user -> email}}</td>
                        <td>{{ $user -> roles()->first()->name}}</td>
                        <td>
                            <div class="d-flex">
                                <a style="margin: 2px;" href="{{route('user.edit', $user->id)}}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{route('user.delete', $user->id)}}" method="POST">
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
        {{ $users -> appends(['busqueda'=> $busqueda]) }}
    </div>
</div>

@endsection
@section('visitas')
<code>Visitas: {{$visitas->contador}}</code>
@endsection