<div class="card">
    <div style="align-items: center; display: inline-flex; justify-content: space-between;">
        <div class="row">
            <div class="d-flex">
                <h5 class="card-header">Listado de Horarios Registrados </h5>
                <div>
                    <button id="agregar-horario-btn" style="margin-top: 20px;" type="button" class="btn btn-sm btn-primary">Añadir</button>
                </div>
            </div>
            <div class="container d-flex">

                <div class="col-4">
                    <div class="form-group" style="margin-right: 5px;">
                        <select name=" hora_program_dia" required class="form-select" id="inputGroupSelectDia">
                            <option value="0">Selecionar Dia...</option>
                            <option value="lunes">Lunes</option>
                            <option value="martes">Martes</option>
                            <option value="miercoles">Miercoles</option>
                            <option value="jueves">Jueves</option>
                            <option value="viernes">Viernes</option>
                            <option value="sabado">Sabado</option>
                            <option value="domingo">Domingo</option>
                        </select>
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group" style="margin-right: 5px;">
                        <input id="hora_curs_hini" name="hora_curs_hini" value="{{ old('hora_curs_hini') }}" placeholder="Hora de inicio" type="time" class="form-control" />
                    </div>
                </div>


                <div class="col-4">
                    <div class="form-group" style="margin-right: 5px;">
                        <input id="hora_curs_hfin" name="hora_curs_hfin" value="{{ old('hora_curs_hfin') }}" placeholder="Hora de inicio" type="time" class="form-control" />
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="tabla-horarios" class="table">
            <thead>
                <tr>
                    <th>Dia</th>
                    <th>Hora de inicio</th>
                    <th>Hora de fin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">

            </tbody>
        </table>
    </div>
</div>

<div id="mod-error" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
    <strong>Ups!!! Ocurrio un error: </strong>
    <span id="error-message"></span>
    <button id="btn-close-alert" type="button" class="btn-close" aria-label="Close"></button>
</div>


<script>
    window.onload = function() {
        document.getElementById("btn-close-alert").addEventListener("click", function() {
            document.getElementById("mod-error").style.display = "none";
        });
        //Agregar horario a la tabla al presionar el botón "Agregar" en la ventana modal
        document.getElementById("agregar-horario-btn").addEventListener("click", function() {
            var dia = document.getElementById("inputGroupSelectDia").value;
            var hini = document.getElementById("hora_curs_hini").value;
            var hfin = document.getElementById("hora_curs_hfin").value;
            var errorDiv = document.getElementById("mod-error");
            var errorMessage = document.getElementById("error-message");
            console.log(dia, hini, hfin);
            if (dia != 0 && hini && hfin) {

                if (Date.parse("1970-01-01T" + hini) >= Date.parse("1970-01-01T" + hfin)) {
                    errorMessage.innerHTML = "La hora final debe ser después de la hora inicial.";
                    errorDiv.style.display = "block";
                    //alert("La hora final debe ser después de la hora inicial.");
                } else {
                    var table = document.getElementById("tabla-horarios");
                    var row = table.insertRow(-1);
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    var cell3 = row.insertCell(2);
                    var cell4 = row.insertCell(3);

                    cell1.innerHTML = dia;
                    cell2.innerHTML = hini;
                    cell3.innerHTML = hfin;
                    var button = document.createElement("button");
                    button.innerHTML = "Quitar";
                    button.setAttribute("class", "btn btn-sm btn-danger");
                    cell4.appendChild(button);
                    button.addEventListener("click", function() {
                        deleteRow(this);
                    });

                    //Limpiar los campos
                    document.getElementById("hora_curs_hini").value = "";
                    document.getElementById("hora_curs_hfin").value = "";
                    document.getElementById("inputGroupSelectDia").value = "0";
                }


            } else {
                errorMessage.innerHTML = "Debes llenar todos los campos.";
                errorDiv.style.display = "block";
                document.getElementById("hora_curs_hini").value = hfin;
                document.getElementById("hora_curs_hfin").value = hfin;
                document.getElementById("inputGroupSelectDia").value = dia;

            }

        });

        //Enviar formulario al presionar el botón "Enviar"
        var formulario = document.getElementById("form-horarios");
        document.getElementById("form-horarios").addEventListener("submit", function(e) {
            e.preventDefault();


            //Recolectar los datos de los horarios agregados a la tabla
            var horarios = [];
            var tabla = document.getElementById("tabla-horarios");
            for (var i = 1; i < tabla.rows.length; i++) {
                horarios.push({
                    dia: tabla.rows[i].cells[0].innerHTML,
                    hini: tabla.rows[i].cells[1].innerHTML,
                    hfin: tabla.rows[i].cells[2].innerHTML
                });
            }

            //Añadir los datos de los módulos al formulario
            document.getElementById("horarios").value = JSON.stringify(horarios);
            formulario.submit();
        });

        function deleteRow(btn) {
            // Obtener la celda seleccionada
            var cell = btn.parentNode;
            // Obtener la fila seleccionada
            var row = cell.parentNode;

            // Eliminar la fila del DOM
            row.remove();
        }
    }
</script>