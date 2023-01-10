@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Registrar Pago')

@section('content-body')

<h4 class="fw-bold py-3 mb-4">Registrar Pago</h4>



@if($errors->any())
@include('layouts.errors')
@endif

<!-- Basic Layout & Basic with Icons -->
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header ">
                <h5 class="mb-0">Datos del Pago</h5> <small class="text-muted float-end"></small>
                <br>
                <h6 class="mb-2">Alumno: {{ $plan->inscripcion_programa->persona->per_nom }} {{ $plan->inscripcion_programa->persona->per_appm }}</h6>
                <h6 class="mb-2">Programa: {{ $plan->inscripcion_programa->program->program_nom }}</h6>
                <h6 class="mb-2">Precio del Programa: {{ $plan->inscripcion_programa->program->program_precio }} Bs.</h6>

            </div>
            <div class="card-body">
                <form action="{{ route('pagos.update', $plan->plan_pago_nro) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Descripcion</label>
                        <div class="col-sm-10">
                            <input name="plan_pago_descrip" value="{{$plan->plan_pago_descrip}}" type="text" class="form-control" id="basic-default-name" placeholder="Descripcion del pago" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Total a Pagar</label>
                        <div class="col-sm-10">
                            <input name="plan_pago_pagtot" required value="{{ $plan->plan_pago_pagtot }}" type="number" min="0" class="form-control" id="basic-default-name" placeholder="Total a pagar" />
                            @error('plan_pago_pagtot')
                            <small style="color: red;">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    @livewire('lista-pagos', ['plan'=> $plan])


                    <div class="d-flex" style="margin-top: 20px;">
                        <button type="submit" style="margin: 3px;" class="btn btn-primary">Registrar</button>
                        <a style="margin: 2px;" href="{{ route('pagos.delete', $plan->plan_pago_nro) }}" class="btn btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection