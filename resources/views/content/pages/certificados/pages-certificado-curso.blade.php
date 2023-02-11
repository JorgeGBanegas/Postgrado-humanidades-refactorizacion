@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Certificados Cursos')

@section('content-body')

<div>

    @include('layouts.sections.navbar.nav-search')
    @include('content.pages.certificados.modal-certificado-curso')

    @include('layouts.errors')

    <!-- Basic Bootstrap Table -->
    <button style="margin-bottom: 25px;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
        Registrar
    </button>

    <!--- Listado--->
    <div class="card">
        <div style="align-items: center; display: inline-flex; justify-content: space-between;">
            <h5 class="card-header">Listado de Certificados </h5>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nro Certificado</th>
                        <th>Alumno</th>
                        <th>Curso</th>
                        <th>Acciones</th>

                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($certificados AS $certificado)
                    <tr>
                        <td>{{ $certificado -> cert_curs_id}}</td>
                        <td>{{ $certificado -> persona -> per_nom ." ".$certificado -> persona -> per_appm}}</td>
                        <td>{{ $certificado -> curs -> curs_nom}}</td>

                        <td>
                            <div class="d-flex">
                                <a style="margin: 2px;" href="{{ route('certificados-curso.show', $certificado -> cert_curs_id) }}" class="btn btn-primary btn-sm">Ver</a>
                                <a style="margin: 2px;" href="{{ route('certificados-curso.edit', $certificado -> cert_curs_id) }}" class="btn btn-warning btn-sm">Editar</a>

                                <form action="{{route('certificados-curso.destroy', $certificado -> cert_curs_id)}}" method="POST">
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
        {{ $certificados->appends(['busqueda'=> $busqueda])  }}
    </div>
</div>
@endsection
@section('visitas')
<code>Visitas: {{$visitas->contador}}</code>
@endsection