<div>
    @include('layouts.sections.navbar.nav-search')

    <!-- Basic Bootstrap Table -->
    <button style="margin-bottom: 25px;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
        Registrar
    </button>

    @if($errors->any())
    @include('layouts.errors')
    @endif


    <!-- Modal -->
    <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('pagos.store') }}" method="POST">
                    @csrf()
                    @method('POST')

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Registrar Pago</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col">
                            <label for="DataListEstudiantes" class="form-label">Buscar Estudiantes Registrados</label>
                            <input name="inscripcion_alumno" required class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
                            <datalist id="datalistOptions">
                                @foreach($inscripciones as $inscripcion)
                                <option value="{{ $inscripcion->inscrip_program_nro}}"> {{ $inscripcion->persona->per_nom}} {{ $inscripcion->persona->per_appm}} - {{$inscripcion->program->program_nom}}
                                    @endforeach
                            </datalist>
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



    <!--- Listado--->
    <div class="card">
        <div style="align-items: center; display: inline-flex; justify-content: space-between;">
            <h5 class="card-header">Listado de Pagos</h5>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nro Inscripcion</th>
                        <th>Estudiante</th>
                        <th>Programa</th>
                        <th>Descripcion Pago</th>
                        <th>Total a pagar</th>
                        <th>Tipo De pago</th>
                        <th>Acciones</th>

                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <tr>
                        @foreach($PlanesDePago as $plan)
                        <td>{{$plan->inscripcion_programa->inscrip_program_nro}}</td>
                        <td>{{$plan->inscripcion_programa->persona->per_nom}} {{$plan->inscripcion_programa->persona->per_appm}}</td>
                        <td>{{$plan->inscripcion_programa->program->program_nom}}</td>
                        <td>{{$plan->plan_pago_descrip}}</td>
                        <td>{{$plan->plan_pago_pagtot}}</td>
                        @php
                        $cantPagos = count($plan->pagos)

                        @endphp
                        @if($cantPagos == 1 && $plan->pagos[0]->pago_monto == $plan->plan_pago_pagtot)
                        <td>Pago al contado</td>
                        @else
                        <td>Plan de pagos</td>
                        @endif
                        <td>
                            <div class="d-flex">
                                <a style="margin: 2px;" href="{{route('pagos.show', $plan->plan_pago_nro)}}" class="btn btn-primary btn-sm">Ver</a>
                                <a style="margin: 2px;" href="{{route('pagos.edit', $plan->plan_pago_nro)}}" class=" btn btn-warning btn-sm">Editar</a>
                                <a style="margin: 2px;" href="{{route('pagos.delete', $plan->plan_pago_nro)}}" class="btn btn-danger btn-sm">Eliminar</a>

                            </div>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="container" style="margin-top:20px">
        {!! $PlanesDePago -> links()!!}
    </div>
</div>