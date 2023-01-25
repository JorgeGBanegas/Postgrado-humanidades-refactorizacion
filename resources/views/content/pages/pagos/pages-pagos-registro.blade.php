@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Registrar Pago')

@section('content-body')

<h4 class="fw-bold py-3 mb-4">Registrar Pago</h4>

@include('layouts.errors')

<!-- Basic Layout & Basic with Icons -->
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header ">
                <h5 class="mb-0">Datos del Pago</h5> <small class="text-muted float-end"></small>
            </div>
            <div class="card-body">
                <form id="form-pago" action="{{ route('pagos.store') }}" method="POST">
                    @csrf

                    @livewire('select-descuentos')

                    <div class="d-flex" style="margin-top: 20px;">
                        <button type="submit" style="margin: 3px;" class="btn btn-primary">Registrar</button>
                        <a style="margin: 2px;" href="{{ route('pagos.index') }}" class="btn btn-danger">Cancelar</a>
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