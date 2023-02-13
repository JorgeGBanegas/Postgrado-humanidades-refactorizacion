<div>
    <div style="align-items: center; display: inline-flex; justify-content: space-between;">
        <div class="row">
            <div class="d-flex">
                <h5 class="card-header">Listado de pagos </h5>
                <div>
                    <button id="agregar-pago-btn" style="margin-top: 20px;" type="button" class="btn btn-sm btn-primary" onclick="addPayment()">Añadir</button>
                </div>
            </div>
            <div class="container d-flex">
                <div class="col-4">
                    <div class="form-group" style="margin-right: 5px;">
                        <input id="pago_concepto" name="pago_concepto" value="{{ old('pago_concepto') }}" placeholder="Concepto" type="text" min="0" class="form-control" />
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group" style="margin-right: 5px;">
                        <input id="pago_fecha_cobro" name="pago_fecha_cobro" value="{{ old('pago_fecha_cobro') }}" min="{{date('Y-m-d')}}" placeholder="Fecha de cobro" type="date" class="form-control" />
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group" style="margin-right: 5px;">
                        <input id="pago_monto" name="pago_monto" value="{{ old('pago_monto') }}" placeholder="Cantidad a pagar " type="number" min="0" class="form-control" />
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="tabla-pagos" class="table">
            <thead>
                <tr>
                    <th>Concepto</th>
                    <th>Fecha de cobro</th>
                    <th>Monto a pagar</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">

            </tbody>
        </table>
    </div>
</div>