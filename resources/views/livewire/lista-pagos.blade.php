<div>
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="basic-default-tipo">Tipo de Pago</label>
        <div class="col-sm-10">
            <select id="pago_tipo" name="pago_tipo" required class="form-select" onChange="pagoOnChange(this)">
                @if(sizeof($listaPagos) > 0)
                <option value="1">Al contado</option>
                <option value="2" selected>Plan de Pago</option>
                @else
                <option value="1" selected>Al contado</option>
                <option value="2">Plan de Pago</option>
                @endif
            </select>
        </div>
    </div>
    @if(sizeof($listaPagos) > 0)
    <div class="card" id="lista_pagos">
        @else
        <div class="card" style="display: none;" id="lista_pagos">
            @endif
            <div class="d-flex">
                <div>
                    <h5 class="card-header">Listado de Pagos</h5>
                </div>
                <div>
                    <a href="{{route('pago.create', [$plan, '1'])}}" style="margin-top: 20px;" type="button" class="btn btn-sm btn-primary">Añadir</a>
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
                        @foreach($listaPagos as $pago)
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

    <script>
        function pagoOnChange(sel) {
            if (sel.value == "1") {
                divC = document.getElementById("lista_pagos");
                divC.style.display = "none ";

            } else {
                divC = document.getElementById("lista_pagos");
                divC.style.display = "";

            }
        }
    </script>