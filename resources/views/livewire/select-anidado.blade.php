<div class="container">

    <div class="d-flex">
        <div class="col-6">
            <label class="form-label">Programas</label>
            <select name="inscripcion_programa" required wire:model="selectedPrograma" class="form-select">
                <option value="" selected>Seleccionar ...</option>
                @foreach($programas as $progr)
                <option value="{{ $progr -> program_id }}">{{ $progr -> program_nom}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6" style="margin-left: 5px;">
            <label class="form-label">Grupos</label>
            <select name="inscripcion_grupo" required wire:model="selectedGrupos" class="form-select">
                <option value="" selected>Seleccionar ...</option>
                @foreach($grupos as $grupo)
                <option value="{{ $grupo -> grup_program_id }}">{{ $grupo -> grup_program_cod}}</option>
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
            <label class="form-label">{{$horario->hora_program_dia}} ({{ $horario->hora_program_hini}} - {{$horario->hora_program_hfin}}) </label>
            @endforeach
        </div>
        @else
        <br>
        <label class="form-label">Sin horarios</label>
        @endif
    </div>
</div>
</div>