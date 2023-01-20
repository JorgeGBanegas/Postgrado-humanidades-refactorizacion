@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Editar curso')

@section('content-body')
@include('layouts.errors')

<h4 class="fw-bold py-3 mb-4">Editar Curso</h4>

<!-- Basic Layout & Basic with Icons -->
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Datos del Curso</h5> <small class="text-muted float-end"></small>
            </div>
            <div class="card-body">
                <form id="form-program" method="POST" action="{{route('cursos.update', $curso->curs_id)}}">
                    @csrf
                    @method('PATCH')
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Nombre</label>
                        <div class="col-sm-10">
                            <input id="curs_nom" name="curs_nom" value="{{ $curso->curs_nom }}" required type="text" class="form-control" placeholder="Nombre" />
                            @error('curs_nom')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-appm">Precio</label>
                        <div class="col-sm-10">
                            <input id="curs_precio" name="curs_precio" value="{{ $curso->curs_precio }}" required type="number" min=0 class="form-control " placeholder="Precio del curso" />
                            @error('curs_precio')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-fnac">Fecha de Inicio</label>
                        <div class="col-sm-10">
                            <input name="curs_fini" value="{{ $curso->curs_fini }}" required type="date" id="basic-default-fnac" class="form-control" />
                            @error('curs_fini')
                            <small style="color: red;">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-tipo">Modalidad</label>
                        <div class="col-sm-10">
                            <select id="curs_modalidad" name="curs_modalidad" required class="form-select" id="inputGroupSelectTipo">
                                <option value="0">Selecionar...</option>
                                <option value="presencial" @if($curso->curs_modalidad == "presencial") selected @endif >Presencial</option>
                                <option value="virtual" @if($curso->curs_modalidad == "virtual") selected @endif>Virtual</option>
                                <option value="semipresencial" @if($curso->curs_modalidad == "semipresencial") selected @endif>Semipresencial</option>
                            </select>
                            @error('curs_modalidad')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-appm">Duracion</label>
                        <div class="col-sm-10">
                            <input id="curs_duracion" name="curs_duracion" value="{{ $curso->curs_duracion }}" required type="number" min=1 class="form-control " placeholder="Duracion del curso (horas)" />
                            @error('curs_duracion')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex">
                        <button style="margin-top: 10px; margin-right: 5px;" type="submit" class="btn btn-primary">Guardar</button>
                        <a style="margin-top: 10px;" class="btn btn-danger" href="{{route('cursos.index')}}">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection