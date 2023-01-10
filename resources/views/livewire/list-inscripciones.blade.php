<div>
    @include('layouts.sections.navbar.nav-search')
    <a style="margin-bottom: 25px;" href="{{ route('inscripciones.create')}}" class="btn btn-primary">Inscribir</a>

    <div class="card">
        <div style="align-items: center; display: inline-flex; justify-content: space-between;">
            <h5 class="card-header">Listado de Inscripciones a Programas</h5>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nro inscripcion</th>
                        <th>Fecha de inscripcion</th>
                        <th>Programa</th>
                        <th>Grupo</th>
                        <th>Alumno</th>
                        <th>Acciones</th>

                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($inscritos AS $inscripcion)
                    <tr>
                        <td>{{ $inscripcion-> inscrip_program_nro}}</td>
                        <td>{{ $inscripcion-> inscrip_program_fecha}}</td>
                        <td>{{ $inscripcion-> program -> program_nom}}</td>
                        <td>{{ $inscripcion-> grupo_programa -> grup_program_cod}}</td>
                        <td>{{ $inscripcion-> persona -> per_nom ." ".$inscripcion-> persona -> per_appm}}</td>

                        <td>
                            <div class="d-flex">

                                <a style="margin: 2px;" href="{{ route('inscripciones.showProgram', $inscripcion->inscrip_program_nro) }}" class="btn btn-primary btn-sm">Ver</a>

                                <form action="{{ route('inscripciones.destroyProgram', $inscripcion->inscrip_program_nro) }}" method="POST">
                                    @csrf()
                                    @method('PATCH')

                                    <button type="submit" style="margin: 2px;" class="btn btn-danger btn-sm">Anular</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="container" style="margin-top:20px">
        {!! $inscritos -> links()!!}
    </div>
</div>