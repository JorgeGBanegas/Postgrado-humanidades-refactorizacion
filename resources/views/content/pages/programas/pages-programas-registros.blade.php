@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Registrar Programa')

@section('content-body')

@include('layouts.errors')

<h4 class="fw-bold py-3 mb-4">Crear Programa</h4>

<!-- Basic Layout & Basic with Icons -->
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Datos del Programa</h5> <small class="text-muted float-end"></small>
            </div>
            <div class="card-body">
                <form id="form-program" method="POST" action="{{route('programas.store')}}">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Nombre</label>
                        <div class="col-sm-10">
                            <input id="program_nom" name="program_nom" value="{{ old('program_nom') }}" required type="text" class="form-control" placeholder="Nombre" />
                            @error('program_nom')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-appm">Precio</label>
                        <div class="col-sm-10">
                            <input id="program_precio" name="program_precio" value="{{ old('program_precio') }}" required type="number" min=0 class="form-control " placeholder="Precio del programa" />
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
                                <option value="diplomado">Diplomado</option>
                                <option value="maestria">Maestria</option>
                                <option value="especialidad">Especialidad </option>
                                <option value="doctorado">Doctorado </option>
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
                                <option value="presencial">Presencial</option>
                                <option value="virtual">Virtual</option>
                                <option value="semipresencial">Semipresencial</option>
                            </select>
                            @error('program_modalidad')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-tipo">Carrera</label>
                        <div class="col-sm-10">
                            <select id="program_carrera" name="program_carrera" required class="form-select">
                                <option value="">Selecionar...</option>
                                @foreach($carreras as $carrera)
                                <option value="{{$carrera->carr_id}}">{{$carrera->carr_nom}}</option>
                                @endforeach
                            </select>
                            @error('program_carrera')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <input type="hidden" name="modulos" id="modulos" value="">
                    </div>
                    <!--- Listado de modulos--->
                    @include('content.pages.programas.lista-de-modulos')

                    <div id="mod-error" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <strong>Ups!!! Ocurrio un error: </strong>
                        Debes ingresar todos los campos
                        <button id="btn-close-alert" type="button" class="btn-close" aria-label="Close"></button>
                    </div>
                    <div class="d-flex">
                        <button style="margin-top: 10px; margin-right: 5px;" type="submit" class="btn btn-primary">Registrar</button>
                        <a style="margin-top: 10px;" class="btn btn-danger" href="{{route('programas.index')}}">Cancelar</a>
                    </div>
                </form>


            </div>


        </div>
    </div>
</div>
@endsection

@section('visitas')
<code>Visitas: {{$visitas->contador}}</code>
@endsection