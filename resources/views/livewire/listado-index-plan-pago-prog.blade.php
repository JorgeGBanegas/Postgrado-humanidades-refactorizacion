<div>
    @include('layouts.sections.navbar.nav-search')

    <!-- Basic Bootstrap Table -->
    <a type="button" href="{{route('pagos.create')}}" style="margin-bottom: 25px;" type="button" class="btn btn-primary">
        Registrar
    </a>

    @include('layouts.errors')

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
                                @if(@Auth::user()->hasRole(config('variables.rol_admin')))
                                <form action="{{route('pagos.destroy', $plan->plan_pago_nro)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button style="margin: 2px;" type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>

                                @endif
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