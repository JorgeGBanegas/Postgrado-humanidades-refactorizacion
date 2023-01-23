@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Estadisticas Cursos')

@section('content-body')

@livewire('graficas-inscritos-cursos')

@endsection
@section('visitas')
<code>Visitas: {{$visitas->contador}}</code>
@endsection