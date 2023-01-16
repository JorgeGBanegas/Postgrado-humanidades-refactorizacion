<div>
    @include('layouts.sections.navbar.nav-search')

    @include('layouts.errors')


    <!-- Basic Bootstrap Table -->
    <a style="margin-bottom: 25px;" href="{{route('programas.create')}}" class="btn btn-primary">Registrar</a>

    <!--- Listado--->
    <div class="card">
        <div style="align-items: center; display: inline-flex; justify-content: space-between;">
            <h5 class="card-header">Listado de Programas Registradas </h5>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Modalidad</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($programas AS $programa)
                    <tr>
                        <td>{{ $programa -> program_nom}}</td>
                        <td>{{ $programa -> program_precio}}</td>
                        <td>{{ $programa -> program_modalidad}}</td>
                        <td>{{ $programa -> program_tipo}}</td>
                        <td>
                            <div class="d-flex">
                                <a style="margin: 2px;" href="" class="btn btn-primary btn-sm">Ver</a>
                                <a style="margin: 2px;" href="" class="btn btn-warning btn-sm">Editar</a>
                                <form action="" method="POST">
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
        {!! $programas -> links()!!}
    </div>
</div>