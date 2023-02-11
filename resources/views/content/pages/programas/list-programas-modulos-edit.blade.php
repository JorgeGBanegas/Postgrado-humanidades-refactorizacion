<div>

    <div class="d-flex">
        <h5 class="card-header">Modulos</h5>
        <div>
            <button type="button" id="agregar-modulo-btn" style="margin-top: 20px;" class="btn btn-sm btn-primary">Añadir</button>
        </div>
    </div>

    <div id="mod-error" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
    </div>
    <div class="container d-flex">
        <div class="col-4">
            <div class="form-group" style="margin-right: 5px;">
                <input id="mod_program_nro" name="mod_program_nro" placeholder="Nro de modulo" type="number" min="0" class="form-control" />
            </div>
        </div>

        <div class="col-4">
            <div class="form-group" style="margin-right: 5px;">
                <input id="mod_program_nom" name="mod_program_nom" placeholder="Nombre del Modulo" type="text" class="form-control" />
            </div>
        </div>

        <div class="col-4">
            <div class="form-group">
                <select name="docente" class="form-select" id="docente">
                    <option value="0">Selecionar Docente...</option>
                    @foreach($docentes AS $docente)
                    <option value="{{$docente->per_id}}">{{ $docente->per_nom . " ".$docente->per_appm}}</option>
                    @endforeach
                </select>

            </div>
        </div>
        <input type="hidden" id="programa" name="programa" value="{{$programa->program_id}}" />
    </div>


    <!-- Lista de modulos--->
    <div class="table-responsive text-nowrap">
        <table id="tabla_modulos" class="table card-table">
            <thead>
                <tr>
                    <th>Nro</th>
                    <th>Nombre</th>
                    <th>Docente</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($programa->modulo_programas AS $modulo)
                <tr id="{{$modulo->mod_program_id}}">
                    <td>{{ $modulo->mod_program_nro}}</td>
                    <td>{{ $modulo->mod_program_nom}}</td>
                    <td>{{ $modulo->docente}}</td>

                    <td>
                        <div class="d-flex">
                            <button style="margin: 2px;" type="button" class="btn btn-danger btn-sm" onclick="deleteModule('{{$modulo->mod_program_id}}')">Eliminar</button>
                        </div>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</div>

@section('vendor-script')

<script>
    document.getElementById('agregar-modulo-btn').addEventListener('click', function() {
        let modulo_nro = document.getElementById("mod_program_nro").value;
        let modulo_nom = document.getElementById("mod_program_nom").value;
        let docente = document.getElementById("docente").value;
        let programa = document.getElementById("programa").value;
        //let token = document.querySelector('input[name="_token"]').value;
        let token = document.head.querySelector('meta[name="csrf-token"]').content;
        let ruta = "{{route('modulo.create')}}";
        console.log(modulo_nro, modulo_nom, docente, programa, token, ruta);
        fetch(ruta, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                },

                body: JSON.stringify({
                    mod_program_nro: modulo_nro,
                    mod_program_nom: modulo_nom,
                    docente: docente,
                    program_id: programa
                })
            })
            .then(response => {
                console.log(response.status);
                if (response.status == 200) {
                    addRow(modulo_nro, modulo_nom, docente)
                }
                return response.json();
            }).then(data => {

                if (data.errors) {
                    let errorMessage = "";
                    Object.entries(data.errors).forEach(([field, messages]) => {
                        errorMessage += messages + "\n";
                    });
                    displayErrorMessage(errorMessage);
                }

            })
            .catch(error => {
                console.log(error)
            })

        document.querySelectorAll('small[id^="error-"]').forEach(elem => elem.style.display = "none");

    });

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

    function addRow(nro, nombre, docente) {
        var table = document.getElementById("tabla_modulos");
        var row = table.insertRow();
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);

        cell1.innerHTML = nro;
        cell2.innerHTML = nombre;
        cell3.innerHTML = docente;
        var button = document.createElement("button");
        button.innerHTML = "Eliminar";
        button.setAttribute("class", "btn btn-sm btn-danger");
        cell4.appendChild(button);
        button.addEventListener("click", function() {
            deleteRow(this);
        });

        document.getElementById("mod_program_nro").value = "";
        document.getElementById("mod_program_nom").value = "";
        document.getElementById("docente").value = "0";
    }

    function deleteRow(btn) {
        // Obtener la celda seleccionada
        var cell = btn.parentNode;
        // Obtener la fila seleccionada
        var row = cell.parentNode;

        // Eliminar la fila del DOM
        row.remove();
    }

    function deleteModule(idModulo) {
        let ruta = "{{ route('modulo.delete', ':idModulo') }}";
        ruta = ruta.replace(':idModulo', idModulo);
        let token = document.head.querySelector('meta[name="csrf-token"]').content;
        fetch(ruta, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            })
            .then(response => {
                if (response.status === 200) {
                    // Eliminar la fila correspondiente de la tabla
                    console.log(response);
                    let tr = document.getElementById(idModulo);
                    tr.remove();
                }
                return response.json();
            })
            .then(data => {
                if (data.errors) {
                    // Mostrar el mensaje de error
                    console.log(data.errors);
                }
            })
            .catch(error => {
                console.error(error);
            });
    }
</script>

@endsection