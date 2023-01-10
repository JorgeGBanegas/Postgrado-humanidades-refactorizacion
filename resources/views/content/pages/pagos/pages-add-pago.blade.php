@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Agregar Pago')

@section('content-body')

<h4 class="fw-bold py-3 mb-4">Agregar Pago</h4>


<!-- Basic Layout & Basic with Icons -->
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Datos del Pago</h5> <small class="text-muted float-end"></small>
            </div>
            <div class="card-body">

                @if($tipo == 1)
                <form action="{{ route('pago.store', $plan) }}" method="POST">

                    @csrf
                    @method('POST')
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-ci">Concepto</label>
                        <div class="col-sm-10">
                            <input name="pago_concepto" value="{{ old('pago_concepto') }}" required type="text" class="form-control" id="basic-default-ci" placeholder="Concepto del pago" />
                            @error('pago_concepto')
                            <small style="color: red;">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Fecha de Cobro</label>
                        <div class="col-sm-10">
                            <input name="pago_fecha_cobro" value="{{ old('pago_fecha_cobro') }}" required type="date" class="form-control" id="basic-default-name" placeholder="Fecha de cobro" />
                            @error('pago_fecha_cobro')
                            <small style="color: red;">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-appm">Monto</label>
                        <div class="col-sm-10">
                            <input name="pago_monto" value="{{ old('pago_monto') }}" required type="number" class="form-control" id="basic-default-appm" placeholder="Monto" />
                            @error('pago_monto')
                            <small style="color: red;">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </div>
                    </div>
                </form>
                @else
                <form action="{{ route('pago.updatePago', $plan) }}" method="POST">

                    @csrf
                    @method('POST')
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-ci">Concepto</label>
                        <div class="col-sm-10">
                            <input name="pago_concepto" value="{{ old('pago_concepto') }}" required type="text" class="form-control" id="basic-default-ci" placeholder="Concepto del pago" />
                            @error('pago_concepto')
                            <small style="color: red;">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Fecha de Cobro</label>
                        <div class="col-sm-10">
                            <input name="pago_fecha_cobro" value="{{ old('pago_fecha_cobro') }}" required type="date" class="form-control" id="basic-default-name" placeholder="Fecha de cobro" />
                            @error('pago_fecha_cobro')
                            <small style="color: red;">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-appm">Monto</label>
                        <div class="col-sm-10">
                            <input name="pago_monto" value="{{ old('pago_monto') }}" required type="number" class="form-control" id="basic-default-appm" placeholder="Monto" />
                            @error('pago_monto')
                            <small style="color: red;">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex">
                        <button style="margin: 3px;" type="submit" class="btn btn-primary">Registrar</button>
                        <a style="margin: 3px;" class="btn btn-danger" href="{{url()->previous() }}">Cancelar</a>
                    </div>
                </form>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection