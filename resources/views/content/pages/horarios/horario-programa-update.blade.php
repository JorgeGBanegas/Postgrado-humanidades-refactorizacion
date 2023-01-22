@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Actualizar Grupo-Horario')

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
                <form id="form-horarios" method="POST" action="{{route('horarios-programas.update', $grupoHorario->grup_program_id)}}">
                    @csrf
                    @method('PATCH')
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Codigo</label>
                        <div class="col-sm-10">
                            <input id="grup_program_cod" name="grup_program_cod" value="{{ $grupoHorario->grup_program_cod}}" required type="text" class="form-control" placeholder="Codigo" />
                            @error('grup_program_cod')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-appm">Version</label>
                        <div class="col-sm-10">
                            <input id="grup_program_vers" name="grup_program_vers" value="{{ $grupoHorario->grup_program_vers  }}" required type="text" min=0 class="form-control " placeholder="Version" />
                            @error('grup_program_vers')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-appm">Edicion</label>
                        <div class="col-sm-10">
                            <input id="grup_program_edic" name="grup_program_edic" value="{{ $grupoHorario->grup_program_edic  }}" required type="text" min=0 class="form-control " placeholder="Edicion" />
                            @error('grup_program_edic')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-appm">Fecha de inicio de clases</label>
                        <div class="col-sm-10">
                            <input id="grup_program_fini" name="grup_program_fini" value="{{ $grupoHorario->grup_program_fini  }}" required type="date" class="form-control " placeholder="Inicio de clases" />
                            @error('grup_program_fini')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-tipo">Programa</label>
                        <div class="col-sm-10">
                            <select id="programa" name="programa" required class="form-select" id="inputGroupSelectPrograma">
                                <option value="">Selecionar...</option>
                                @foreach($programas as $programa)
                                <option value="{{$programa->program_id}}" @if($grupoHorario->programa == $programa->program_id) selected @endif >{{$programa->program_nom}}</option>
                                @endforeach
                            </select>
                            @error('programa')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>
                    <!--- Listado de horarios--->
                    @livewire('list-horarios-progr', ['grupoHorario'=>$grupoHorario])


                    <div class="d-flex">
                        <button style="margin-top: 10px; margin-right: 5px;" type="submit" class="btn btn-primary">Guardar</button>
                        <a style="margin-top: 10px;" class="btn btn-danger" href="{{route('horarios-programas.index')}}">Cancelar</a>
                    </div>
                </form>


            </div>


        </div>
    </div>
</div>
@endsection