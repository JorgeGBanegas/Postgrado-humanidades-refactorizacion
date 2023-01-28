@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Listado de Usuarios')

@section('content-body')

@livewire('list-user')

@endsection
@section('visitas')
<code>Visitas: {{$visitas->contador}}</code>
@endsection