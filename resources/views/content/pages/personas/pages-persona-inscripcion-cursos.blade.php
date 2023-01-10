@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Incribir Alumno')

@section('content-body')
@include('layouts.errors')


<h4 class="fw-bold py-3 mb-4">Formulario de Inscripcion</h4>

<!-- Basic Layout & Basic with Icons -->
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Datos de inscripcion</h5> <small class="text-muted float-end"></small>
            </div>
            <div class="card-body">
                <form action="{{route('inscripcion-curso.store')}}" method="POST">
                    @csrf
                    <div class="container">
                        <div class="row mb-3">
                            <div class="col-10">
                                <label for="DataListEstudiantes" class="form-label">Buscar Estudiantes Registrados</label>
                                <input name="inscripcion_alumno" required class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
                                <datalist id="datalistOptions">
                                    @foreach($listaEstudiantes as $estudiante)
                                    <option value="{{ $estudiante->per_ci}}"> {{ $estudiante->per_nom}} {{ $estudiante->per_appm}}
                                        @endforeach
                                </datalist>
                            </div>
                            <div class="col-2">
                                <label for="NuevoEstudiantes" class="form-label">Estudiante</label>
                                <a style="margin-bottom: 25px;" href="{{ route('personas.create')}}" class="btn btn-primary">Nuevo</a>
                            </div>
                        </div>
                    </div>
                    @livewire('select-anidado-cursos')

                    <div class="container d-flex">
                        <button style="margin-top: 10px; margin-bottom: 10px;" type="submit" class="btn btn-primary">Inscribir</button>
                        <a style="margin-top: 10px; margin-bottom: 10px; margin-left: 5px;" class="btn btn-danger" href="{{route('inscripcion-curso.index')}}">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection