@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Registrar Personas')

@section('content-body')


<h4 class="fw-bold py-3 mb-4">Formulario de Registro</h4>

<!-- Basic Layout & Basic with Icons -->
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Datos Personales</h5> <small class="text-muted float-end"></small>
            </div>
            <div class="card-body">
                <form action="{{ route('personas.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-ci">C.I.</label>
                        <div class="col-sm-10">
                            <input name="per_ci" value="{{ old('per_ci') }}" required type="text" class="form-control" id="basic-default-ci" placeholder="Cedula de identidad" />
                            @error('per_ci')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Nombres</label>
                        <div class="col-sm-10">
                            <input name="per_nom" value="{{ old('per_nom') }}" required type="text" class="form-control" id="basic-default-name" placeholder="Nombres" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-appm">Apellidos</label>
                        <div class="col-sm-10">
                            <input name="per_appm" value="{{ old('per_appm') }}" required type="text" class="form-control" id="basic-default-appm" placeholder="Apellido Paterno - Materno" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-prof">Profesion</label>
                        <div class="col-sm-10">
                            <input name="per_prof" value="{{ old('per_prof') }}" required type="text" id="basic-default-prof" class="form-control" placeholder="Profesion" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-telf">Telefono</label>
                        <div class="col-sm-10">
                            <input name="per_telf" value="{{ old('per_telf') }}" required type="text" id="basic-default-telf" class="form-control phone-mask" placeholder="Telefono" />
                            @error('per_telf')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-cel">Celular</label>
                        <div class="col-sm-10">
                            <input name="per_cel" value="{{ old('per_cel') }}" required type="text" id="basic-default-cel" class="form-control phone-mask" placeholder="Celular" />
                            @error('per_cel')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-email">Email</label>
                        <div class="col-sm-10">
                            <input name="per_email" value="{{ old('per_email') }}" required type="email" id="basic-default-email" class="form-control" placeholder="Correo electronico" />
                            @error('per_email')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-fnac">Fecha de Nacimiento</label>
                        <div class="col-sm-10">
                            <input name="per_fnac" value="{{ old('per_fnac') }}" required type="date" id="basic-default-fnac" class="form-control" />
                            @error('per_fnac')
                            <small style="color: red;">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-lnac">Lugar de Nacimiento</label>
                        <div class="col-sm-10">
                            <input name="per_lnac" value="{{ old('per_lnac') }}" required type="text" id="basic-default-lnac" class="form-control" placeholder="Lugar de nacimiento" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-tipo">Tipo de Registro</label>
                        <div class="col-sm-10">
                            <select name="per_tipo" required class="form-select" id="inputGroupSelectTipo">
                                <option value="">Selecionar...</option>
                                @foreach($listaTipos AS $tipo)
                                <option value="{{$tipo -> tipo_us_id}}">{{ $tipo -> tipo_us_nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="d-flex">
                        <button style="margin: 3px;" type="submit" class="btn btn-primary">Registrar</button>
                        <a style="margin: 3px;" class="btn btn-danger" href="{{route('personas.index')}}">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection