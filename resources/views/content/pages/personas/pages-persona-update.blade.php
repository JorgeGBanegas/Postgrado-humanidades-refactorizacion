@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Actualizar Personas')

@section('content-body')


<h4 class="fw-bold py-3 mb-4">Actualizar datos</h4>

<!-- Basic Layout & Basic with Icons -->
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Datos Personales</h5> <small class="text-muted float-end"></small>
            </div>
            <div class="card-body">
                <form action="{{ route('personas.update', $persona->per_id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-ci">C.I.</label>
                        <div class="col-sm-10">
                            <input name="per_ci" value="{{ $persona->per_ci }}" required type="text" class="form-control" id="basic-default-ci" placeholder="Cedula de identidad" />
                            @error('per_ci')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Nombres</label>
                        <div class="col-sm-10">
                            <input name="per_nom" value="{{ $persona->per_nom }}" required type="text" class="form-control" id="basic-default-name" placeholder="Nombres" />
                            @error('per_nom')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-appm">Apellidos</label>
                        <div class="col-sm-10">
                            <input name="per_appm" value="{{ $persona->per_appm}}" required type="text" class="form-control" id="basic-default-appm" placeholder="Apellido Paterno - Materno" />
                            @error('per_appm')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-prof">Profesion</label>
                        <div class="col-sm-10">
                            <input name="per_prof" value="{{ $persona->per_prof }}" required type="text" id="basic-default-prof" class="form-control" placeholder="Profesion" />
                            @error('per_prof')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-telf">Telefono</label>
                        <div class="col-sm-10">
                            <input name="per_telf" value="{{ $persona->per_telf }}" required type="text" id="basic-default-telf" class="form-control phone-mask" placeholder="Telefono" />
                            @error('per_telf')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-cel">Celular</label>
                        <div class="col-sm-10">
                            <input name="per_cel" value="{{ $persona->per_cel }}" required type="text" id="basic-default-cel" class="form-control phone-mask" placeholder="Celular" />
                            @error('per_cel')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-email">Email</label>
                        <div class="col-sm-10">
                            <input name="per_email" value="{{ $persona->per_email}}" required type="email" id="basic-default-email" class="form-control" placeholder="Correo electronico" />
                            @error('per_email')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-fnac">Fecha de Nacimiento</label>
                        <div class="col-sm-10">
                            <input name="per_fnac" value="{{ $persona->per_fnac}}" required type="date" id="basic-default-fnac" class="form-control" />
                            @error('per_fnac')
                            <small style="color: red;">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-lnac">Lugar de Nacimiento</label>
                        <div class="col-sm-10">
                            <input name="per_lnac" value="{{ $persona->per_lnac}}" required type="text" id="basic-default-lnac" class="form-control" placeholder="Lugar de nacimiento" />
                            @error('per_lnac')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-tipo">Tipo de Registro</label>
                        <div class="col-sm-10">
                            <select name="per_tipo" required class="form-select" id="inputGroupSelectTipo">
                                <option value="">Selecionar...</option>
                                @foreach($listaTipos AS $tipo)
                                <option value="{{$tipo -> tipo_us_id}}" @if($persona->per_tipo == $tipo -> tipo_us_id) selected @endif>{{ $tipo -> tipo_us_nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="d-flex">
                        <button style="margin: 3px;" type="submit" class="btn btn-primary">Actualizar</button>
                        <a style="margin: 3px;" class="btn btn-danger" href="{{route('personas.index')}}">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection