<div class="container">

    <div class="d-flex">
        <div class="col-6">
            <label class="form-label">Cursos</label>
            <select name="inscripcion_curso" required wire:model="selectedCurso" class="form-select">
                <option value="" selected>Seleccionar ...</option>
                @foreach($cursos as $curso)
                <option value="{{ $curso -> curs_id }}">{{ $curso -> curs_nom}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6" style="margin-left: 5px;">
            <label class="form-label">Grupos</label>
            <select name="inscripcion_grupo" required wire:model="selectedGrupos" class="form-select">
                <option value="" selected>Seleccionar ...</option>
                @foreach($grupos as $grupo)
                <option value="{{ $grupo -> grup_curs_id }}">{{ $grupo -> grup_curs_cod}}</option>
                @endforeach
            </select>
        </div>

    </div>
    <div class="col-12">
        @if(sizeof($horarios) > 0)
        <div class="col">
            <label class="form-label">Horarios</label>
            <br>
            @foreach($horarios as $horario)
            <label class="form-label">{{$horario->hora_curs_dia}} ({{ $horario->hora_curs_hini}} - {{$horario->hora_curs_hfin}}) </label>
            @endforeach
        </div>
        @else
        <br>
        <label class="form-label">Sin horarios</label>
        @endif
    </div>
</div>
</div>