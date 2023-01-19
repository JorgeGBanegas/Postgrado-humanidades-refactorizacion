<div>
    <div class="d-flex">
        <h5 class="card-header">Modulos</h5>
        <div>
            <button id="agregar-modulo-btn" style="margin-top: 20px;" type="button" class="btn btn-sm btn-primary" wire:click="agregarModulos">Añadir</button>
        </div>
    </div>

    <div id="mod-error" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
        <strong>Ups!!! Ocurrio un error: </strong>
        Debes ingresar todos los campos
        <button id="btn-close-alert" type="button" class="btn-close" aria-label="Close"></button>
    </div>
    <div class="container d-flex">
        <div class="col-4">
            <div class="form-group" style="margin-right: 5px;">
                <input id="mod_program_nro" wire:model.lazy="mod_program_nro" name="mod_program_nro" placeholder="Nro de modulo" type="number" min="0" class="form-control" />

                @if($errors->has('mod_program_nro'))
                <small id="error-nro" style="color: red;">{{ $errors->first('mod_program_nro') }}</small>
                @endif

            </div>
        </div>

        <div class="col-4">
            <div class="form-group" style="margin-right: 5px;">
                <input id="mod_program_nom" wire:model.lazy="mod_program_nom" name="mod_program_nom" placeholder="Nombre del Modulo" type="text" class="form-control" />
                @if($errors->has('mod_program_nom'))
                <small id="error-nom" style="color: red;">{{ $errors->first('mod_program_nom') }}</small>
                @endif
            </div>
        </div>

        <div class="col-4">
            <div class="form-group">
                <select wire:model.lazy="docente" name="docente" class="form-select" id="inputGroupSelectDocente">
                    <option value="0">Selecionar Docente...</option>
                    @foreach($docentes AS $docente)
                    <option value="{{$docente->per_id}}">{{ $docente->per_nom . " ".$docente->per_appm}}</option>
                    @endforeach
                </select>
                @if($errors->has('docente'))
                <small id="error-doc" style="color: red;">{{ $errors->first('docente') }}</small>
                @endif
            </div>
        </div>
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
                @foreach($progr->modulo_programas AS $modulo)
                <tr>
                    <td>{{ $modulo->mod_program_nro}}</td>
                    <td>{{ $modulo->mod_program_nom}}</td>
                    <td>{{ $modulo->docente}}</td>

                    <td>
                        <div class="d-flex">
                            <button wire:click.prevent="eliminarModulo({{ $modulo->mod_program_id }})" type="submit" style="margin: 2px;" class="btn btn-danger btn-sm">Eliminar</button>
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
    document.getElementById("btn-close-alert").addEventListener("click", function() {
        document.getElementById("mod-error").style.display = "none";
    });


    document.getElementById('agregar-modulo-btn').addEventListener('click', function() {
        document.querySelectorAll('small[id^="error-"]').forEach(elem => elem.style.display = "none");

    });
</script>

@endsection