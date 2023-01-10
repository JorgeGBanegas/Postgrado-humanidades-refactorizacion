@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Editar Certificado Curso')

@section('content-body')

<h4 class="fw-bold py-3 mb-4">Editar Certificado</h4>




<!-- Basic Layout & Basic with Icons -->
<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header ">
                <h5 class="mb-0">Informacion del Certificado</h5> <small class="text-muted float-end"></small>
            </div>
            <div class="card-body">
                <form action="{{ route('certificados-curso.update', $certificado->cert_curs_id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="row mb-3">
                        <div class="form-group">
                            <label>Descripcion del Certificado</label>
                            <textarea class="form-control rounded-0" required name="cert_curs_descrip" rows="3">{{$certificado->cert_curs_descrip}}</textarea>
                        </div>
                        @error('cert_curs_descrip')
                        <small style="color: red;">{{ $message}}</small>
                        @enderror
                        </textarea>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-fnac">Fecha</label>
                        <div>
                            <input name="cert_curs_fecha" required value="{{$certificado->cert_curs_fecha->format('Y-m-d')}}" type="date" class="form-control" />
                        </div>
                        @error('cert_curs_fecha')
                        <small style="color: red;">{{ $message}}</small>
                        @enderror
                    </div>

                    <div class="d-flex" style="margin-top: 20px;">
                        <button type="submit" style="margin: 3px;" class="btn btn-primary">Guardar</button>
                        <a style="margin: 2px;" href="{{ route('certificados-curso.index')}}" class="btn btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection