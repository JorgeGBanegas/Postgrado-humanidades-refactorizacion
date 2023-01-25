<div class="card">
    <div style="align-items: center; display: inline-flex; justify-content: space-between;">
        <div class="row">
            <div class="d-flex">
                <h5 class="card-header">Listado de pagos </h5>
                <div>
                    <button id="agregar-pago-btn" style="margin-top: 20px;" type="button" class="btn btn-sm btn-primary">Añadir</button>
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



<script>
    document.getElementById("btn-close-alert").addEventListener("click", function() {
        document.getElementById("mod-error").style.display = "none";
    });

    document.getElementById("agregar-pago-btn").addEventListener("click", function() {
        var concepto = document.getElementById("pago_concepto").value;
        var fecha_cobro = document.getElementById("pago_fecha_cobro").value;
        var monto = document.getElementById("pago_monto").value;

        var errorDiv = document.getElementById("mod-error");
        var errorMessage = document.getElementById("error-message");

        if (concepto && fecha_cobro && monto) {
            if (monto > 0) {
                var table = document.getElementById("tabla-pagos");
                var row = table.insertRow(-1);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);

                cell1.innerHTML = concepto;
                cell2.innerHTML = fecha_cobro;
                cell3.innerHTML = monto;
                var button = document.createElement("button");
                button.innerHTML = "Quitar";
                button.setAttribute("class", "btn btn-sm btn-danger");
                cell4.appendChild(button);
                button.addEventListener("click", function() {
                    deleteRow(this);
                });

                //Limpiar los campos de la ventana modal
                document.getElementById("pago_concepto").value = "";
                document.getElementById("pago_fecha_cobro").value = "";
                document.getElementById("pago_monto").value = "0";
            } else {
                errorMessage.innerHTML = "El monto debe ser mayor a 0";
                errorDiv.style.display = "block";
            }

        } else {
            errorMessage.innerHTML = "Debes llenar todos los campos.";
            errorDiv.style.display = "block";
            document.getElementById("pago_concepto").value = concepto;
            document.getElementById("pago_fecha_cobro").value = fecha_cobro;
            document.getElementById("pago_monto").value = monto;

        }

    });

    //Enviar formulario al presionar el botón "Enviar"
    var formulario = document.getElementById("form-pago");
    document.getElementById("form-pago").addEventListener("submit", function(e) {
        e.preventDefault();

        var errorDiv = document.getElementById("mod-error");
        var errorMessage = document.getElementById("error-message");
        var monto_total = document.getElementById("pago_descuento").value;


        var pagos = [];
        var tabla = document.getElementById("tabla-pagos");
        console.log(tabla);
        var sumaPagos = 0;
        if (tabla != null) {
            for (var i = 1; i < tabla.rows.length; i++) {
                var monto = parseFloat(tabla.rows[i].cells[2].innerHTML);
                sumaPagos += monto;
                pagos.push({
                    pago_concepto: tabla.rows[i].cells[0].innerHTML,
                    pago_fecha_cobro: tabla.rows[i].cells[1].innerHTML,
                    pago_monto: tabla.rows[i].cells[2].innerHTML
                });
            }
            console.log(sumaPagos);
            if (sumaPagos == monto_total) {
                document.getElementById("pagosList").value = JSON.stringify(pagos);
                formulario.submit();

            } else {
                errorMessage.innerHTML = "La suma de pagos debe ser igual que el precio total a pagar";
                errorDiv.style.display = "block";
            }
        } else {
            formulario.submit();
        }

        //Añadir los datos de los módulos al formulario
        var monto_total = parseFloat(document.getElementById("pago_descuento").value);
        var errorDiv = document.getElementById("mod-error");
        var errorMessage = document.getElementById("error-message");

    });

    function deleteRow(btn) {
        var cell = btn.parentNode;
        var row = cell.parentNode;
        row.remove();
    }
</script>