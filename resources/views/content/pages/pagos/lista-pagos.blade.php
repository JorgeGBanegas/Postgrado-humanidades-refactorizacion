<div>
    <div class="card" id="lista_pagos">
        <div class="d-flex">
            <div>
                <h5 class="card-header">Listado de Pagos</h5>
            </div>
            <div>
                <a href="{{route('pago.create', [$plan, 2])}}" style="margin-top: 20px;" type="button" class="btn btn-sm btn-primary">Añadir</a>
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
</div>