<div>
    @include('layouts.sections.navbar.nav-search')

    @include('layouts.errors')


    <!-- Basic Bootstrap Table -->
    <a style="margin-bottom: 25px;" href="{{route('horarios-programas.create')}}" class="btn btn-primary">Registrar</a>

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
                        <th>Inicio de clases</th>
                        <th>Horario</th>
                        <th>Programa</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($gruposHorarios AS $gh)
                    <tr>
                        <td>{{ $gh->grup_program_cod}}</td>
                        <td>{{ $gh->grup_program_fini}}</td>

                        <td style="width:18%; min-width:180;">
                            @foreach($gh->horario_programas as $horario)
                            <p>{{ substr($horario->hora_program_dia,0,3) }} [{{ date("H:i", strtotime($horario->hora_program_hini)) }} - {{ date("H:i", strtotime($horario->hora_program_hfin)) }}]
                            </p>
                            @endforeach
                        </td>

                        <td>{{ $gh->program->program_nom}}</td>

                        <td>
                            <div class="d-flex">
                                <a style="margin: 2px;" href="{{route('horarios-programas.show', $gh->grup_program_id)}}" class="btn btn-primary btn-sm">Ver</a>
                                <a style="margin: 2px;" href="{{route('horarios-programas.edit', $gh->grup_program_id)}}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{route('horarios-programas.destroy',$gh->grup_program_id)}}" method="POST">
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