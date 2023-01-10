@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Ver Pago')

@section('content-body')
<h4 class="mb-0">Pago</h4> <small class="text-muted float-end"></small>
<br>
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header ">
                <h4 class="mb-0">Datos del Pago</h4> <small class="text-muted float-end"></small>
            </div>
            <div class="card-body">
                <h6 class="mb-2">Alumno: {{ $plan->inscripcion_programa->persona->per_nom }} {{ $plan->inscripcion_programa->persona->per_appm }}</h6>
                <h6 class="mb-2">Programa: {{ $plan->inscripcion_programa->program->program_nom }}</h6>
                <h6 class="mb-2">Precio del Programa: {{ $plan->inscripcion_programa->program->program_precio }} Bs.</h6>
                <h6 class="mb-2">Total a pagar: {{ $plan->plan_pago_pagtot }} Bs.</h6>

                @if(sizeof($plan->pagos) == 1 && $plan->pagos[0]->pago_monto == $plan->plan_pago_pagtot)

                <h6 class="mb-2">Tipo de pago: Pago al contado</h6>

                @else
                <h6 class="mb-2">Tipo de pago: Plan de Pagos</h6>

                <div class="card" id="lista_pagos">
                    <div class="d-flex">
                        <div>
                            <h5 class="card-header">Listado de Pagos</h5>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Concepto</th>
                                    <th>Fecha de Cobro</th>
                                    <th>Monto</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach($plan->pagos as $pago)
                                <tr>
                                    <td>{{$pago->pago_concepto}}</td>
                                    <td>{{$pago->pago_fecha_cobro}}</td>
                                    <td>{{$pago->pago_monto}}</td>
                                    @if($pago->pago_estado)
                                    <td>Pagado</td>
                                    @else
                                    <td>Pendiente</td>
                                    @endif
                                    <td>
                                        @if(!$pago->pago_estado)
                                        <div class="d-flex">
                                            <form action="{{route('pago.updateEstado', $pago->pago_nro)}}" method="POST">
                                                @csrf()
                                                @method('PATCH')
                                                <button type="submit" style="margin: 2px;" class="btn btn-primary btn-sm">Marcar como Pagado</button>
                                            </form>
                                        </div>
                                        @else
                                        <div class="d-flex">
                                            <button type="button" disabled style="margin: 2px;" class="btn btn-success btn-sm">Pagado</button>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                <form action="{{ route('pagos.index') }}" method=" get">
                    <button style="margin-top: 25px;" class="btn btn-primary" type="submit">Volver</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection