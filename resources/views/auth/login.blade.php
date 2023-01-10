@extends('layouts.app')

@section('title', 'Iniciar Sesion')

@section('content')
<!-- Navbar-->
<header class="header">
    <nav class="navbar navbar-expand-lg navbar-light py-3">
        <div class="container">
            <!-- Navbar Brand -->
            <a href="#" class="navbar-brand">
                <img src="{{ asset('assets/img/logo/logo.png') }}" alt="logo" width="200" />
            </a>
        </div>
    </nav>
</header>

<div class="container">
    <div class="row py-5 mt-4 align-items-center">
        <!-- For Demo Purpose -->
        <div class="col-md-5 pr-lg-5 mb-5 mb-md-0">
            <img src="{{ asset('assets/img/logo/escudo.png') }}" alt="" class="img-fluid mb-3 d-none d-md-block" />

        </div>
        <!-- Registeration Form -->
        <div class="col-md-7 col-lg-6 ml-auto">

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="row">

                    <!-- Email Address -->
                    <div class="input-group input-group-lg" style="margin-bottom: 20px;">
                        <span class="input-group-text" id="basic-addon11"><i class="fa fa-envelope"></i></span>
                        <input required type="email" name="email" value=" {{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email" aria-label="Email" aria-describedby="basic-addon11" />
                        @error('email')
                        <small style="color: red;">{{ $message}}</small>
                        @enderror

                    </div>

                    <!-- Password -->
                    <div class="input-group input-group-lg" style="margin-bottom: 20px;">
                        <span id=" basic-default-password2" class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        <input required name="password" type=" password" class="form-control input-group-lg @error('password') is-invalid @enderror" id="basic-default-password12" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="basic-default-password2" />
                        @error('password')
                        <small style="color: red;">{{ $message}}</small>
                        @enderror

                    </div>
                    <!-- Submit Button -->
                    <div class="">
                        <button type="submit" class="btn btn-primary col-12">Iniciar Sesion</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection