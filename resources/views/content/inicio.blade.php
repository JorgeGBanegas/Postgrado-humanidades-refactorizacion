@extends('layouts.sections.menu.burguerMenu')
@section('title', 'Home')

@section('content-body')

<div style="text-align: center;" class="card">
    <img src="{{ asset('assets/img/logo/postgradoHumanidades.png') }}" alt="">
</div>
@endsection

@section('visitas')
<code>Visitas: {{$visitas->contador}}</code>
@endsection