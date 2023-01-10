<div>
    @include('layouts.sections.navbar.nav-search')
    <a style="margin-bottom: 25px;" href="{{ route('inscripcion-curso.create')}}" class="btn btn-primary">Inscribir</a>

    <div class="card">
        <div style="align-items: center; display: inline-flex; justify-content: space-between;">
            <h5 class="card-header">Listado de Inscripciones a Cursos</h5>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nro inscripcion</th>
                        <th>Fecha de inscripcion</th>
                        <th>Curso</th>
                        <th>Grupo</th>
                        <th>Alumno</th>
                        <th>Acciones</th>

                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($inscritos AS $inscripcion)
                    <tr>
                        <td>{{ $inscripcion-> inscrip_curs_id}}</td>
                        <td>{{ $inscripcion-> inscrip_curs_fecha}}</td>
                        <td>{{ $inscripcion-> curs -> curs_nom}}</td>
                        <td>{{ $inscripcion-> grupo_curso -> grup_curs_cod}}</td>
                        <td>{{ $inscripcion-> persona -> per_nom ." ".$inscripcion-> persona -> per_appm}}</td>

                        <td>
                            <div class="d-flex">

                                <a style="margin: 2px;" href="{{ route('inscripcion-curso.show', $inscripcion->inscrip_curs_id) }}" class="btn btn-primary btn-sm">Ver</a>

                                <form action="{{ route('inscripcion-curso.update', $inscripcion->inscrip_curs_id) }}" method="POST">
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