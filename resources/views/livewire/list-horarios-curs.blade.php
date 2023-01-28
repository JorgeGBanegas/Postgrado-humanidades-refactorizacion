<div>
    <div>

        <div style="align-items: center; display: inline-flex; justify-content: space-between;">
            <div class="row">
                <div class="d-flex">
                    <h5 class="card-header">Listado de Horarios Registrados </h5>
                    <div>
                        <button wire:click="agregarHorarios" id="agregar-horario-btn" style="margin-top: 20px;" type="button" class="btn btn-sm btn-primary">Añadir</button>
                    </div>
                </div>
                <div class="container d-flex">

                    <div class="col-4">
                        <div class="form-group" style="margin-right: 5px;">
                            <select name="hora_curs_dia" wire:model.lazy="hora_curs_dia" required class="form-select" id="inputGroupSelectDia">
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
                            <input id="hora_curs_hini" name="hora_curs_hini" wire:model.lazy="hora_curs_hini" value="{{ old('hora_curs_hini') }}" placeholder="Hora de inicio" type="time" class="form-control" />
                            @if($errors->has('hora_curs_hini'))
                            <small id="error-nom" style="color: red;">{{ $errors->first('hora_curs_hini') }}</small>
                            @endif
                        </div>
                    </div>


                    <div class="col-4">
                        <div class="form-group" style="margin-right: 5px;">
                            <input id="hora_curs_hfin" name="hora_curs_hfin" wire:model.lazy="hora_curs_hfin" value="{{ old('hora_curs_hfin') }}" placeholder="Hora de inicio" type="time" class="form-control" />
                            @if($errors->has('hora_curs_hfin'))
                            <small id="error-nom" style="color: red;">{{ $errors->first('hora_curs_hfin') }}</small>
                            @endif
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
                    @foreach($horarios AS $horario)
                    <tr>
                        <td>{{ $horario->hora_curs_dia}}</td>
                        <td>{{ $horario->hora_curs_hini}}</td>
                        <td>{{ $horario->hora_curs_hfin}}</td>

                        <td>
                            <div class="d-flex">
                                <button wire:click.prevent="eliminarHorario({{ $horario->hora_curs_id }})" type="submit" style="margin: 2px;" class="btn btn-danger btn-sm">Eliminar</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="mod-error" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
        <strong>Ups!!! Ocurrio un error: </strong>
        <span id="error-message"></span>
        <button id="btn-close-alert" type="button" class="btn-close" aria-label="Close"></button>
    </div>

</div>