<div>
    <div>

        <div style="align-items: center; display: inline-flex; justify-content: space-between;">
            <div class="row">
                <div class="d-flex">
                    <h5 class="card-header">Listado de Horarios Registrados </h5>
                    <div>
                        <button id="agregar-horario-btn" style="margin-top: 20px;" type="button" class="btn btn-sm btn-primary" onclick="addSchedule()">Añadir</button>
                    </div>
                </div>
                <div class="container d-flex">

                    <div class="col-4">
                        <div class="form-group" style="margin-right: 5px;">
                            <select name="hora_curs_dia" required class="form-select" id="hora_curs_dia">
                                <option value="0">Selecionar Dia...</option>
                                <option value="lunes">Lunes</option>
                                <option value="martes">Martes</option>
                                <option value="miercoles">Miercoles</option>
                                <option value="jueves">Jueves</option>
                                <option value="viernes">Viernes</option>
                                <option value="sabado">Sabado</option>
                                <option value="domingo">Domingo</option>
                            </select>
                            @if($errors->has('hora_curs_dia'))
                            <small id="error-nom" style="color: red;">{{ $errors->first('hora_curs_dia') }}</small>
                            @endif
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group" style="margin-right: 5px;">
                            <input id="hora_curs_hini" name="hora_curs_hini" value="{{ old('hora_curs_hini') }}" placeholder="Hora de inicio" type="time" class="form-control" />
                            @if($errors->has('hora_curs_hini'))
                            <small id="error-nom" style="color: red;">{{ $errors->first('hora_curs_hini') }}</small>
                            @endif
                        </div>
                    </div>


                    <div class="col-4">
                        <div class="form-group" style="margin-right: 5px;">
                            <input id="hora_curs_hfin" name="hora_curs_hfin" value="{{ old('hora_curs_hfin') }}" placeholder="Hora de inicio" type="time" class="form-control" />
                            @if($errors->has('hora_curs_hfin'))
                            <small id="error-nom" style="color: red;">{{ $errors->first('hora_curs_hfin') }}</small>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            <div>
                <input id="grupo-horario" type="hidden" value="{{$grupoHorario->grup_curs_id}}">
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
                    @foreach($grupoHorario->horario_cursos AS $horario)
                    <tr id="{{$horario->hora_curs_id}}">
                        <td>{{ $horario->hora_curs_dia}}</td>
                        <td>{{ $horario->hora_curs_hini}}</td>
                        <td>{{ $horario->hora_curs_hfin}}</td>

                        <td>
                            <div class="d-flex">
                                <button type="button" style="margin: 2px;" class="btn btn-danger btn-sm" onclick="deleteSchedule('{{$horario->hora_curs_id}}')">Eliminar</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="mod-error" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
    </div>

</div>


@section('vendor-script')

<script>
    function addSchedule() {
        let day = document.getElementById("hora_curs_dia").value;
        let hStart = document.getElementById("hora_curs_hini").value;
        let hEnd = document.getElementById("hora_curs_hfin").value;
        let group = document.getElementById("grupo-horario").value;
        let token = document.head.querySelector('meta[name="csrf-token"]').content;
        let route = "{{route('horarios-cursos.add')}}";
        console.log(day, hStart, hEnd, group, token, route);

        fetch(route, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                },

                body: JSON.stringify({
                    hora_curs_dia: day,
                    hora_curs_hini: hStart,
                    hora_curs_hfin: hEnd,
                    grupo_horario: group
                })
            })
            .then(response => {
                console.log(response.status);
                if (response.status == 200) {
                    addRow(day, hStart, hEnd)
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

    function addRow(day, hStart, hEnd) {
        var table = document.getElementById("tabla-horarios");
        var row = table.insertRow();
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);

        cell1.innerHTML = day;
        cell2.innerHTML = hStart;
        cell3.innerHTML = hEnd;
        var button = document.createElement("button");
        button.innerHTML = "Eliminar";
        button.setAttribute("class", "btn btn-sm btn-danger");
        cell4.appendChild(button);
        button.addEventListener("click", function() {
            deleteRow(this);
        });

        document.getElementById("hora_curs_dia").value = "0";
        document.getElementById("hora_curs_hini").value = "";
        document.getElementById("hora_curs_hfin").value = "";
    }

    function deleteRow(btn) {
        // Obtener la celda seleccionada
        var cell = btn.parentNode;
        // Obtener la fila seleccionada
        var row = cell.parentNode;

        // Eliminar la fila del DOM
        row.remove();
    }

    function deleteSchedule(idSchedule) {
        let ruta = "{{ route('horarios-cursos.delete', ':idSchedule') }}";
        ruta = ruta.replace(':idSchedule', idSchedule);
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
                    let tr = document.getElementById(idSchedule);
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