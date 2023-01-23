@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Listado de Cursos')

@section('content-body')

@livewire('list-cursos')

@endsection
@section('visitas')
<code>Visitas: {{$visitas->contador}}</code>
@endsection