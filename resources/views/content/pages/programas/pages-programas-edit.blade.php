@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Editar Programa')

@section('content-body')

@include('layouts.errors')

<h4 class="fw-bold py-3 mb-4">Editar Programa</h4>

<!-- Basic Layout & Basic with Icons -->
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Datos del Programa</h5> <small class="text-muted float-end"></small>
            </div>
            <div class="card-body">
                <form id="form-program" method="POST" action="{{route('programas.update', $programa->program_id)}}">
                    @csrf
                    @method('PATCH')
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Nombre</label>
                        <div class="col-sm-10">
                            <input id="program_nom" name="program_nom" value="{{ $programa->program_nom }}" required type="text" class="form-control" placeholder="Nombre" />
                            @error('program_nom')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-appm">Precio</label>
                        <div class="col-sm-10">
                            <input id="program_precio" name="program_precio" value="{{ $programa->program_precio }}" required type="number" min=0 class="form-control " placeholder="Precio del programa" />
                            @error('program_precio')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-tipo">Tipo de programa</label>
                        <div class="col-sm-10">
                            <select id="program_tipo" name="program_tipo" required class="form-select" id="inputGroupSelectTipo">
                                <option value="">Selecionar...</option>
                                <option value="diplomado" @if($programa->program_tipo == "diplomado") selected @endif >Diplomado</option>
                                <option value="maestria" @if($programa->program_tipo == "maestria") selected @endif>Maestria</option>
                                <option value="especialidad" @if($programa->program_tipo == "especialidad") selected @endif>Especialidad </option>
                                <option value="doctorado" @if($programa->program_tipo == "doctorado") selected @endif>Doctorado </option>
                            </select>
                            @error('program_tipo')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-tipo">Modalidad</label>
                        <div class="col-sm-10">
                            <select id="program_modalidad" name="program_modalidad" required class="form-select" id="inputGroupSelectTipo">
                                <option value="">Selecionar...</option>
                                <option value="presencial" @if($programa->program_modalidad == "presencial") selected @endif>Presencial</option>
                                <option value="virtual" @if($programa->program_modalidad == "virtual") selected @endif >Virtual</option>
                                <option value="semipresencial" @if($programa->program_modalidad == "semipresencial") selected @endif>Semipresencial</option>
                            </select>
                            @error('program_modalidad')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>



                    <!---- agregar modulos ----->

                    <!-- Lista de modulos--->
                    @livewire('list-programas-modulos-edit', ['progr'=> $programa])
                    <!----------------------------------------------->

                    <div class="d-flex">
                        <button style="margin-top: 10px; margin-right: 5px;" type="submit" class="btn btn-primary">Guardar</button>
                        <a style="margin-top: 10px;" class="btn btn-danger" href="{{route('programas.index')}}">Cancelar</a>
                    </div>
                </form>


            </div>


        </div>
    </div>
</div>
@endsection