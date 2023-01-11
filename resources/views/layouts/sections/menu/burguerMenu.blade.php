@extends('layouts/commonMaster' )

@section('layoutContent')
<div class='dashboard' style="display: flex;
        flex-direction: column;
        min-height: 100vh;">
    <div class="dashboard-nav">
        <header>
            <a href="{{url('/')}}" class="app-brand-link">
                <div>
                    <img src="{{ asset('assets/img/logo/escudo.png') }}" alt class="w-px-50">
                </div>
            </a>
        </header>
        <div class="container">
            <h6 style="text-align: center; color: #ffffff;">Unidad de Postgrado </h6>
            <h6 style="text-align: center; color: #ffffff;">Facultad de Humanidades</h6>
        </div>

        <nav class="dashboard-nav-list">

            <a href="/" class="dashboard-nav-item"><i class="fas fa-home"></i>Home </a>

            <div class='dashboard-nav-dropdown'><a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle"><i class="fas fa-user-graduate"></i> Registros </a>
                <div class='dashboard-nav-dropdown-menu'>

                    @if(@Auth::user()->hasRole(config('variables.rol_admin')))
                    <a href="{{route('personas.index')}}" class="dashboard-nav-dropdown-item">Alumno/Docente</a>
                    <a href="{{route('inscripciones.index')}}" class="dashboard-nav-dropdown-item">Inscribir a Programa</a>
                    <a href="{{route('inscripcion-curso.index')}}" class="dashboard-nav-dropdown-item">Inscribir a Curso</a>
                    @elseif(@Auth::user()->hasRole(config('variables.rol_admin_progr')))
                    <a href="{{route('personas.index')}}" class="dashboard-nav-dropdown-item">Docentes</a>
                    @elseif(@Auth::user()->hasRole(config('variables.rol_admin_inscrip')))
                    <a href="{{route('personas.index')}}" class="dashboard-nav-dropdown-item">Alumnos</a>
                    <a href="{{route('inscripciones.index')}}" class="dashboard-nav-dropdown-item">Inscribir a Programa</a>
                    <a href="{{route('inscripcion-curso.index')}}" class="dashboard-nav-dropdown-item">Inscribir a Curso</a>
                    @endif
                </div>
            </div>

            <a href="{{route('pagos.index')}}" class="dashboard-nav-item"><i class="fas fa-money-bill-wave"></i>Pagos</a>


            <div class='dashboard-nav-dropdown'><a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle"><i class="fas fa-certificate"></i> Certificados </a>
                <div class='dashboard-nav-dropdown-menu'>
                    <a href="{{route('certificados-programa.index')}}" class="dashboard-nav-dropdown-item">Programas</a>
                    <a href="{{route('certificados-curso.index')}}" class="dashboard-nav-dropdown-item">Cursos</a>
                </div>
            </div>

            <div class='dashboard-nav-dropdown'><a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle"><i class="fa fa-pie-chart"></i> Estadisticas </a>
                <div class='dashboard-nav-dropdown-menu'>
                    <a href="{{route('estadistica.programas')}}" class=" dashboard-nav-dropdown-item">Programas</a>
                    <a href="{{route('estadistica.cursos')}}" class=" dashboard-nav-dropdown-item">Cursos</a>
                </div>
            </div>

            <a href="{{route('user.index')}}" class="dashboard-nav-item"><i class="fas fa-users"></i>Usuarios</a>

        </nav>
    </div>
    <div class='dashboard-app'>
        <header class='dashboard-toolbar' style="display: flex;">
            <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
            <div style="margin-right: 10px; margin-top: 10px;">
                <h6> Rol: {{auth()->user()->roles()->first()->name}}</h6>
            </div>
            <div class="d-flex" style="margin-left: auto;">

                <div style="margin-right: 10px; margin-top: 10px;">
                    <h6> {{auth()->user()->name. " ".auth()->user()->last_name}}</h6>
                </div>
                <div class="">
                    <div class="demo-inline-spacing">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary btn-icon rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <form action="{{route('logout')}}" method="POST">
                                    @csrf
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="this.closest('form').submit()">
                                            Cerrar Sesion
                                        </a>
                                    </li>

                                </form>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class='dashboard-content'>
            <div class='container' style=" margin-bottom: 40px;">
                @yield('content-body')
            </div>
        </div>
        @include('layouts/sections/footer/footer')

    </div>
</div>
@endsection