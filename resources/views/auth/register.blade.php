@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Registrar Usuario')

@section('content-body')

<h4 class="fw-bold py-3 mb-4">Crear Usuario</h4>

<!-- Basic Layout & Basic with Icons -->
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Datos Personales</h5> <small class="text-muted float-end"></small>
            </div>
            <div class="card-body">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Nombres</label>
                        <div class="col-sm-10">
                            <input name="name" value="{{ old('name') }}" required type="text" class="form-control" placeholder="Nombres" />
                            @error('name')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-appm">Apellidos</label>
                        <div class="col-sm-10">
                            <input name="last_name" value="{{ old('last_name') }}" required type="text" class="form-control " placeholder="Apellido Paterno - Materno" />
                            @error('last_name')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-email">Email</label>
                        <div class="col-sm-10">
                            <input name="email" value="{{ old('email') }}" required type="email" class="form-control " placeholder="Correo electronico" />
                            @error('email')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-email">Contraseña</label>
                        <div class="col-sm-10">
                            <input name="password" value="{{ old('password') }}" required type="password" class="form-control " placeholder="Contraseña" autocomplete="new-password" />
                            @error('password')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-email">Confirmar Contraseña</label>
                        <div class="col-sm-10">
                            <input name="password_confirmation" required type="password" class="form-control" placeholder="Confirmar Contreña" autocomplete="new-password" />
                            @error('password_confirmation')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>


                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-tipo">Tipo de Registro</label>
                        <div class="col-sm-10">
                            <select name="type" required class="form-select" id="inputGroupSelectTipo">
                                <option value="">Selecionar...</option>
                                <option value="administrador">Administrador</option>
                                <option value="administrativo_programas">Administrativo Programas</option>
                                <option value="administrativo_inscripciones">Administrativo Inscripcion</option>
                            </select>
                            @error('type')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex">
                        <button style="margin: 3px;" type="submit" class="btn btn-primary">Registrar</button>
                        <a style="margin: 3px;" class="btn btn-danger" href="{{route('user.index')}}">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection