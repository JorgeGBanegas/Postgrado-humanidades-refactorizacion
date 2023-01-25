<div>
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="basic-default-name">Buscar inscripcion</label>
        <div class="col-sm-10">
            <input required name="inscripcion_alumno" wire:model="selectedInscripciones" required class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
            <datalist id="datalistOptions">
                @foreach($listaDeInscritos as $inscrip)
                <option value="{{ $inscrip->inscrip_program_nro}}"> {{ $inscrip->persona->per_nom ." - ". $inscrip->program->program_nom}} </option>
                @endforeach
            </datalist>
            @error('inscripcion_alumno')
            <small style="color: red;">{{ $message}}</small>
            @enderror
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="basic-default-name">Seleccionar descuento</label>
        <div class="col-sm-10">
            <select required wire:model="selectedDescuentos" name="descuentos" class="form-select">
                <option value="" selected>Seleccionar ...</option>
                <option value="0" selected>Sin descuento</option>
                @foreach($descuentos as $descuento)
                <option value="{{ $descuento -> desc_id }}">{{ $descuento -> desc_motivo}}</option>
                @endforeach
            </select>
            @error('descuentos')
            <small style="color: red;">{{ $message}}</small>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="basic-default-name">Descripcion</label>
        <div class="col-sm-10">
            <input name="plan_pago_descrip" required value="{{old('plan_pago_descrip')}}" type="text" class="form-control" id="basic-default-name" placeholder="Descripcion del pago" />
            @error('plan_pago_descrip')
            <small style="color: red;">{{ $message}}</small>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="basic-default-name">Precio del programa</label>
        <div class="col-sm-10">
            <input wire:model="precioTotal" name="pago_total" required type="number" min="0" class="form-control" id="basic-default-name" />
            @error('pago_total')
            <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="basic-default-name">Total a pagar</label>
        <div class="col-sm-10">
            <input wire:model="precioConDescuento" id="pago_descuento" name="pago_descuento" required type="number" min="0" class="form-control" id="basic-default-name" />
            @error('pago_descuento')
            <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="basic-default-name">Seleccionar descuento</label>
        <div class="col-sm-10">
            <select required wire:model="selectedTipoPago" name="tipo_pago" class="form-select">
                <option value="" selected>Seleccionar ...</option>
                <option value="1">Al contado</option>
                <option value="2">Plan de Pagos</option>
            </select>
            @error('tipo_pago')
            <small style="color: red;">{{ $message}}</small>
            @enderror

        </div>
    </div>

    @if($selectedTipoPago == 2)
    @include('content.pages.pagos.lista-de-pagos')
    @endif
    <div>
        <input type="hidden" name="pagosList" id="pagosList" value="">
    </div>
    <div id="mod-error" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
        <strong>Ups!!! Ocurrio un error: </strong>
        <span id="error-message"></span>
        <button id="btn-close-alert" type="button" class="btn-close" aria-label="Close"></button>
    </div>

</div>