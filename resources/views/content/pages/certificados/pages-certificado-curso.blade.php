@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Certificados Cursos')

@section('content-body')

<div>
    @livewire('certificados-cursos')
</div>

@endsection
@section('visitas')
<code>Visitas: {{$visitas->contador}}</code>
@endsection