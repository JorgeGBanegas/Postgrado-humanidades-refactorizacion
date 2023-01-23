@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Registrar Descuento')

@section('content-body')

@include('layouts.errors')

<h4 class="fw-bold py-3 mb-4">Crear Descuento</h4>

<!-- Basic Layout & Basic with Icons -->
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Datos del Descuento</h5> <small class="text-muted float-end"></small>
            </div>
            <div class="card-body">
                <form id="form-program" method="POST" action="{{route('descuentos.store')}}">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Motivo</label>
                        <div class="col-sm-10">
                            <input id="desc_motivo" name="desc_motivo" value="{{ old('desc_motivo') }}" required type="text" class="form-control" placeholder="Motivo" />
                            @error('desc_motivo')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-appm">Descripcion</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="desc_descrip" id="desc_descrip" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Porcentaje</label>
                        <div class="col-sm-10">
                            <input id="desc_porce" name="desc_porce" value="{{ old('desc_porce') }}" required type="number" min=0 max=100 class="form-control" placeholder="Porcentaje" />
                            @error('desc_porce')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-tipo">Programa</label>
                        <div class="col-sm-10">
                            <select id="program_id" name="program_id" required class="form-select" id="inputGroupSelectPrograma">
                                <option value="0">Selecionar...</option>
                                @foreach($programas as $programa)
                                <option value="{{$programa->program_id}}">{{$programa->program_nom}}</option>
                                @endforeach
                            </select>
                            @error('programas')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex">
                        <button style="margin-top: 10px; margin-right: 5px;" type="submit" class="btn btn-primary">Registrar</button>
                        <a style="margin-top: 10px;" class="btn btn-danger" href="{{route('descuentos.index')}}">Cancelar</a>
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