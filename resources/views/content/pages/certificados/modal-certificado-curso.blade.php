<!-- Modal -->
<div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('certificados-curso.store') }}" method="POST">
                @csrf()
                @method('POST')

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Generar Certificado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col">
                        <label for="DataListEstudiantes" class="form-label">Buscar Estudiantes Registrados</label>
                        <input name="inscrip_curs_id" required class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
                        <datalist id="datalistOptions">
                            @foreach($inscripciones as $inscripcion)
                            <option value="{{ $inscripcion->inscrip_curs_id}}"> {{ $inscripcion->persona->per_ci . " - " .$inscripcion->persona->per_nom . " " . $inscripcion->persona->per_appm . " - " . $inscripcion->curs->curs_nom}}
                                @endforeach
                        </datalist>
                    </div>

                    <div class="col">
                        <div class="form-group">
                            <label>Descripcion del Certificado</label>
                            <textarea class="form-control rounded-0" required name="cert_curs_descrip" rows="3"></textarea>
                        </div>
                        </textarea>
                    </div>

                    <div class="col">
                        <label class="col-sm-2 col-form-label" for="basic-default-fnac">Fecha</label>
                        <div>
                            <input name="cert_curs_fecha" required type="date" class="form-control" />
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