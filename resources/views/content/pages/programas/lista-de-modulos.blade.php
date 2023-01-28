<div>
    <div style="align-items: center; display: inline-flex; justify-content: space-between;">
        <div class="row">
            <div class="d-flex">
                <h5 class="card-header">Listado de Modulos Registrados </h5>
                <div>
                    <button id="agregar-modulo-btn" style="margin-top: 20px;" type="button" class="btn btn-sm btn-primary">Añadir</button>
                </div>
            </div>
            <div class="container d-flex">
                <div class="col-4">
                    <div class="form-group" style="margin-right: 5px;">
                        <input id="mod_program_nro" name="mod_program_nro" value="{{ old('mod_program_nro') }}" placeholder="Nro de modulo" type="number" min="0" class="form-control" />
                    </div>
                    </textarea>
                </div>

                <div class="col-4">
                    <div class="form-group" style="margin-right: 5px;">
                        <input id="mod_program_nom" name="mod_program_nom" value="{{ old('mod_program_nom') }}" placeholder="Nombre del Modulo" type="text" class="form-control" />
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <select name="docente" class="form-select" id="inputGroupSelectDocente">
                            <option value="0">Selecionar Docente...</option>
                            @foreach($docentes AS $docente)
                            <option value="{{$docente->per_id}}">{{ $docente->per_nom . " ".$docente->per_appm}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="tabla-modulos" class="table">
            <thead>
                <tr>
                    <th>Nro</th>
                    <th>Nombre</th>
                    <th>Docente</th>
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
    Debes ingresar todos los campos
    <button id="btn-close-alert" type="button" class="btn-close" aria-label="Close"></button>
</div>


<script>
    window.onload = function() {
        document.getElementById("btn-close-alert").addEventListener("click", function() {
            document.getElementById("mod-error").style.display = "none";
        });
        //Agregar módulo a la tabla al presionar el botón "Agregar" en la ventana modal
        document.getElementById("agregar-modulo-btn").addEventListener("click", function() {
            var nro = document.getElementById("mod_program_nro").value;
            var nombre = document.getElementById("mod_program_nom").value;
            var docente = document.getElementById("inputGroupSelectDocente").value;

            if (nombre && docente != 0 && nro) {
                var table = document.getElementById("tabla-modulos");
                var row = table.insertRow(-1);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);

                cell1.innerHTML = nro;
                cell2.innerHTML = nombre;
                cell3.innerHTML = docente;
                var button = document.createElement("button");
                button.innerHTML = "Quitar";
                button.setAttribute("class", "btn btn-sm btn-danger");
                cell4.appendChild(button);
                button.addEventListener("click", function() {
                    deleteRow(this);
                });

                //Limpiar los campos de la ventana modal
                document.getElementById("mod_program_nro").value = "";
                document.getElementById("mod_program_nom").value = "";
                document.getElementById("inputGroupSelectDocente").value = "0";
            } else {
                document.getElementById("mod-error").style.display = "block";
                document.getElementById("mod_program_nro").value = nro;
                document.getElementById("mod_program_nom").value = nombre;
                document.getElementById("inputGroupSelectDocente").value = docente;

            }

        });

        //Enviar formulario al presionar el botón "Enviar"
        var formulario = document.getElementById("form-program");
        document.getElementById("form-program").addEventListener("submit", function(e) {
            e.preventDefault();


            //Recolectar los datos de los módulos agregados a la tabla
            var modulos = [];
            var tabla = document.getElementById("tabla-modulos");
            for (var i = 1; i < tabla.rows.length; i++) {
                modulos.push({
                    nro: tabla.rows[i].cells[0].innerHTML,
                    nombre: tabla.rows[i].cells[1].innerHTML,
                    docente: tabla.rows[i].cells[2].innerHTML
                });
            }

            //Añadir los datos de los módulos al formulario
            document.getElementById("modulos").value = JSON.stringify(modulos);
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