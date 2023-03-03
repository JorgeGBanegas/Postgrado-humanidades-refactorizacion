<!-- Modal -->
<div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('carreras.store') }}" method="POST">
                @csrf()
                @method('POST')

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Registrar Carrera</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col">
                        <div class="form-group">
                            <label>Nombre de la Carrera</label>
                            <input id="carr_nom" name="carr_nom" type="text" class="form-control" required>
                            @error('carr_nom')
                            <small style="color: red;">{{ $message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-outline-primary">Registrar</button>

                </div>
            </form>
        </div>
    </div>
</div>