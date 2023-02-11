<div class="container">

    <div class="d-flex">
        <div class="col-6">
            <label class="form-label">Cursos</label>
            <select name="inscripcion_curso" id="inscripcion_curso" required class="form-select">
                <option value="" selected>Seleccionar ...</option>
                @foreach($cursos as $curso)
                <option value="{{ $curso -> curs_id }}">{{ $curso -> curs_nom}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6" style="margin-left: 5px;">
            <label class="form-label">Grupos</label>
            <select name="inscripcion_grupo" id="inscripcion_grupo" required class="form-select">
                <option value="">Seleccionar ...</option>
            </select>
        </div>

    </div>
    <div class="col-12">
        <div class="col" id="horarios">

        </div>
    </div>
</div>


@section('vendor-script')
<script>
    let selectCourse = document.getElementById('inscripcion_curso');
    selectCourse.onchange = function() {

        let selectedValue = selectCourse.value;
        let token = document.head.querySelector('meta[name="csrf-token"]').content;
        let route = "{{route('inscripciones-cursos-grupos.horarios', ':selectedValue')}}";
        route = route.replace(':selectedValue', selectedValue);

        fetch(route, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                },
            }).then(response => response.json())
            .then(data => {
                // Obtén el elemento select
                const select = document.getElementById('inscripcion_grupo');
                const divInfo = document.getElementById('horarios');

                while (select.firstChild) {
                    select.removeChild(select.firstChild);
                }
                let option = document.createElement("option");
                option = document.createElement("option");
                option.text = "Seleccionar ...";
                option.value = "";
                select.add(option);
                divInfo.innerHTML = '';

                // Recorre los datos obtenidos
                data.groups.forEach(function(item) {
                    // Aquí se escribe el código que se desea ejecutar por cada elemento del array
                    option = document.createElement("option");
                    option.text = item.grup_curs_cod;
                    option.value = item.grup_curs_id;
                    select.add(option);

                    select.onchange = function() {
                        divInfo.innerHTML = '';
                        let selectedOption = select.options[select.selectedIndex];
                        let selectedValue = selectedOption.value;

                        // Busca el elemento correspondiente en el array data.groups
                        let selectedGroup = data.groups.find(function(group) {
                            return group.grup_curs_id == selectedValue;
                        });

                        // Si se encontró un elemento con el id seleccionado
                        if (selectedGroup) {
                            let listHoras = "";
                            selectedGroup.horario_cursos.forEach(function(horario) {
                                let hora = horario.hora_curs_dia + "(" + horario.hora_curs_hini + " - " + horario.hora_curs_hfin + ")";
                                listHoras += hora + "<br>";
                            });
                            divInfo.innerHTML = `<br><label class='form-label'>Horarios: <br> ${listHoras}</label>`;
                        }
                    };
                });
            });
    };
</script>
@endsection