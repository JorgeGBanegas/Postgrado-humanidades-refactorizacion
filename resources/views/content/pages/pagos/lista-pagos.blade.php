<div>
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

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>