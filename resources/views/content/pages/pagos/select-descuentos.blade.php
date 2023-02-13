<div>
    <div id="mod-error" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">

    </div>
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="basic-default-name">Buscar inscripcion</label>
        <div class="col-sm-10">
            <input required name="inscripcion_alumno" id="inscripcion_alumno" required class="form-control" list="listInscritos" placeholder="Type to search..." onchange="selectInscription()">
            <datalist id="listInscritos">
                @foreach($listaDeInscritos as $inscrip)
                <option value="{{ $inscrip->inscrip_program_nro}}"> {{ $inscrip->persona->per_nom ." - ". $inscrip->program->program_nom}} </option>
                @endforeach
            </datalist>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="basic-default-name">Seleccionar descuento</label>
        <div class="col-sm-10">
            <select required id="descuentos" name="descuentos" class="form-select" onchange="selectDescuento()">
                <option value="" selected>Seleccionar ...</option>
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="basic-default-name">Descripcion</label>
        <div class="col-sm-10">
            <input name="plan_pago_descrip" required value="{{old('plan_pago_descrip')}}" type="text" class="form-control" id="basic-default-name" placeholder="Descripcion del pago" />
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="basic-default-name">Precio del programa</label>
        <div class="col-sm-10">
            <input id="pago_total" name="pago_total" required type="number" min="0" class="form-control" id="basic-default-name" />
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="basic-default-name">Total a pagar</label>
        <div class="col-sm-10">
            <input id="pago_descuento" name="pago_descuento" required type="number" min="0" class="form-control" id="basic-default-name" />
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="basic-default-name">Seleccionar descuento</label>
        <div class="col-sm-10">
            <select id="tipo_pagos" required name="tipo_pago" class="form-select" onchange="paymentType()">
                <option value="" selected>Seleccionar ...</option>
                <option value="1">Al contado</option>
                <option value="2">Plan de Pagos</option>
            </select>
        </div>
    </div>

    <!-----------Aqui agregar para insertar pagos del plan------------------->

    <div id="div_plan" style="display: none;">
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

    <!----------------------------------------------------------------------->
    <div>
        <input type="hidden" name="pagosList" id="pagosList" value="">
    </div>
</div>

@section('vendor-script')
<script>
    function selectDescuento() {
        let idDiscount = document.getElementById('descuentos').value;
        //let idDiscount = 3425342;
        let numInscription = document.getElementById('inscripcion_alumno').value;
        let inputFullPayment = document.getElementById('pago_total');
        let inputPaymentDiscount = document.getElementById('pago_descuento');
        let route = `{{route('descuento.precio')}}?desc=${idDiscount}&inscrip=${numInscription}`;
        let token = document.head.querySelector('meta[name="csrf-token"]').content;
        cleanInput(inputFullPayment, inputPaymentDiscount);

        if (idDiscount == "") {
            return;
        }

        fetch(route, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.errors) {
                    displayErrorMessage(data.errors);
                } else {
                    inputFullPayment.value = data.precioTotal;
                    inputPaymentDiscount.value = data.precioAPagar;
                }
            })
            .catch(errorMessage => console.error(errorMessage));

    }

    function selectInscription() {
        let selectDiscount = document.getElementById('descuentos');
        let nroInscription = document.getElementById('inscripcion_alumno').value;
        nroInscription = nroInscription.trim();
        let route = "{{route('descuentos.list', ':nroInscription')}}";
        route = route.replace(':nroInscription', nroInscription);
        let token = document.head.querySelector('meta[name="csrf-token"]').content;
        cleanSelect(selectDiscount);
        fetch(route, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.errors) {
                    displayErrorMessage(data.errors);
                } else {
                    const option = document.createElement('option');
                    option.value = "0";
                    option.text = "Sin descuento";
                    selectDiscount.appendChild(option);

                    data.descuentos.forEach((item) => {
                        const option = document.createElement('option');
                        option.value = item.desc_id;
                        option.text = item.desc_motivo;
                        selectDiscount.appendChild(option);
                    });
                }
            })
            .catch(errorMessage => console.error(errorMessage));
    };

    function cleanInput(...inputs) {
        inputs.forEach(input => {
            input.value = '';
        });
    }

    function cleanSelect(select) {
        select.options.length = 0;
        const option = document.createElement('option');
        option.value = "";
        option.text = "Seleccionar ...";
        select.appendChild(option);

    }

    function displayErrorMessage(errorMessage) {
        document.getElementById("mod-error").style = "display: block;"
        document.getElementById("mod-error").innerHTML = "<strong>Error:</strong> " + errorMessage;
        let button = document.createElement("button");
        button.id = "btn-close-alert";
        button.className = "btn-close";
        button.setAttribute("type", "button");
        button.setAttribute("aria-label", "Close");
        button.innerHTML = '<span aria-hidden="true">&times;</span>';

        let parent = document.getElementById("mod-error");
        parent.appendChild(button);

        document.getElementById("btn-close-alert").addEventListener("click", function() {
            document.getElementById("mod-error").style.display = "none";
        });

    }

    function addPayment() {
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
                displayErrorMessage("El monto de cada pago debe ser mayor a 0");
            }

        } else {

            displayErrorMessage("Debes llenar todos los campos para el pago.");
            document.getElementById("pago_concepto").value = concepto;
            document.getElementById("pago_fecha_cobro").value = fecha_cobro;
            document.getElementById("pago_monto").value = monto;

        }

    }

    function paymentType() {
        let selectPaymentType = document.getElementById("tipo_pagos").value;
        let divPlan = document.getElementById("div_plan");
        if (selectPaymentType == 2) {
            divPlan.style.display = "block";
        } else {
            divPlan.style.display = "none";
        }
    }

    //Enviar formulario al presionar el botón "Enviar"
    var formulario = document.getElementById("form-pago");
    document.getElementById("form-pago").addEventListener("submit", function(e) {
        var tipo_pago = document.getElementById("tipo_pagos").value;
        e.preventDefault();
        if (tipo_pago == 1) {
            formulario.submit();
        } else if (tipo_pago == 2) {
            addPlan();
        } else {
            displayErrorMessage("Tipo de pago no valido");
        }

    });

    function addPlan() {
        var errorDiv = document.getElementById("mod-error");
        var monto_total = document.getElementById("pago_descuento").value;

        var pagos = [];
        var tabla = document.getElementById("tabla-pagos");
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
            if (sumaPagos == monto_total) {
                document.getElementById("pagosList").value = JSON.stringify(pagos);
                formulario.submit();

            } else {
                displayErrorMessage("La suma de pagos debe ser igual que el precio total a pagar");
            }
        } else {
            formulario.submit();
        }
    }

    function deleteRow(btn) {
        var cell = btn.parentNode;
        var row = cell.parentNode;
        row.remove();
    }
</script>
@endsection