@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Listado de Carreras')

@section('content-body')

<div>
    @include('layouts.sections.navbar.nav-search')

    @include('layouts.errors')
    @include('content.pages.carreras.modal-carreras-registro')
    @include('content.pages.carreras.modal-carreras-edit')


    <!-- Basic Bootstrap Table -->
    <button style="margin-bottom: 25px;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
        Registrar
    </button>
    <!--- Listado--->
    <div class="card">
        <div style="align-items: center; display: inline-flex; justify-content: space-between;">
            <h5 class="card-header">Listado de Carreras Registradas </h5>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($carreras AS $carrera)
                    <tr>
                        <td>{{ $carrera->carr_nom}}</td>
                        <td>
                            <div class="d-flex">
                                <button style="margin: 2px;" type="button" class="btn btn-sm btn-warning btn-edit" data-bs-toggle="modal" data-bs-target="#modal-edit-carr" data-id="{{ $carrera->carr_id }}" data-nombre="{{ $carrera->carr_nom }}">
                                    Editar
                                </button>
                                <form action="{{route('carreras.destroy',$carrera->carr_id)}}" method="POST">
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
        {{ $carreras -> appends(['busqueda'=> $busqueda]) }}
    </div>
</div>

@endsection
@section('visitas')
<code>Visitas: {{$visitas->contador}}</code>
@endsection

@section('vendor-script')
<script>
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('btn-edit')) {
            var id = event.target.dataset.id;
            var nombre = event.target.dataset.nombre;
            var myForm = document.getElementById('form-edit-carr');
            myForm.action = "{{ route('carreras.update', ':id') }}".replace(':id', id);
            document.querySelector('#carr_nom_edit').value = nombre;
            console.log(myForm);
        }
    });
</script>
@endsection