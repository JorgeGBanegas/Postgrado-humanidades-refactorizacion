<div>
    @include('layouts.sections.navbar.nav-search')

    @include('layouts.errors')


    <!-- Basic Bootstrap Table -->
    <a style="margin-bottom: 25px;" href="{{route('horarios-cursos.create')}}" class="btn btn-primary">Registrar</a>

    <!--- Listado--->
    <div class="card">
        <div style="align-items: center; display: inline-flex; justify-content: space-between;">
            <h5 class="card-header">Listado de Grupos-Horarios </h5>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Horario</th>
                        <th>Curso</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($gruposHorarios AS $gh)
                    <tr>
                        <td>{{ $gh->grup_curs_cod}}</td>

                        <td style="width:18%; min-width:180;">
                            @foreach($gh->horario_cursos as $horario)
                            <p>{{ substr($horario->hora_curs_dia,0,3) }} [{{ date("H:i", strtotime($horario->hora_curs_hini)) }} - {{ date("H:i", strtotime($horario->hora_curs_hfin)) }}]
                            </p>
                            @endforeach
                        </td>

                        <td>{{ $gh->curs->curs_nom}}</td>

                        <td>
                            <div class="d-flex">
                                <a style="margin: 2px;" href="{{route('horarios-cursos.edit', $gh->grup_curs_id)}}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{route('horarios-cursos.destroy',$gh->grup_curs_id)}}" method="POST">
                                    @csrf()
                                    @method('DELETE')
                                    <button type="submit" style="margin: 2px;" class="btn btn-danger btn-sm">Eliminar</button>
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
        {!! $gruposHorarios -> links()!!}
    </div>
</div>