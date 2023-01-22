@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Registrar Grupo-Horario')

@section('content-body')

@include('layouts.errors')

<h4 class="fw-bold py-3 mb-4">Crear Grupo-Horario</h4>

<!-- Basic Layout & Basic with Icons -->
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Datos del Grupo-Horario</h5> <small class="text-muted float-end"></small>
            </div>
            <div class="card-body">
                <form id="form-horarios" method="POST" action="{{route('horarios-cursos.store')}}">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Codigo</label>
                        <div class="col-sm-10">
                            <input id="grup_curs_cod" name="grup_curs_cod" value="{{ old('grup_curs_cod') }}" required type="text" class="form-control" placeholder="Codigo" />
                            @error('grup_curs_cod')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-tipo">Programa</label>
                        <div class="col-sm-10">
                            <select id="curso" name="curso" required class="form-select" id="inputGroupSelectCurso">
                                <option value="">Selecionar...</option>
                                @foreach($cursos as $curso)
                                <option value="{{$curso->curs_id}}">{{$curso->curs_nom}}</option>
                                @endforeach
                            </select>
                            @error('curso')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <input type="hidden" name="horarios" id="horarios" value="">
                    </div>
                    <!--- Listado de horarios--->
                    @include('content.pages.horarios.lista-de-horarios-curs')


                    <div class="d-flex">
                        <button style="margin-top: 10px; margin-right: 5px;" type="submit" class="btn btn-primary">Registrar</button>
                        <a style="margin-top: 10px;" class="btn btn-danger" href="{{route('horarios-cursos.index')}}">Cancelar</a>
                    </div>
                </form>


            </div>


        </div>
    </div>
</div>
@endsection