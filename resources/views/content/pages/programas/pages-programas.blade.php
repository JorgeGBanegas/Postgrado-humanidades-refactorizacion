@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Listado de Personas')

@section('content-body')

@livewire('list-programas')

@endsection


@section('visitas')
<code>Visitas: {{$visitas->contador}}</code>
@endsection