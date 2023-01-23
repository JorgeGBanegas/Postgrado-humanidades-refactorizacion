@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Listado de Personas')

@section('content-body')

@livewire('lista-personas')

@endsection
@section('visitas')
<code>Visitas: {{$visitas->contador}}</code>
@endsection