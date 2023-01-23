@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Listado de Descuentos')

@section('content-body')

@livewire('list-descuentos')

@endsection
@section('visitas')
<code>Visitas: {{$visitas->contador}}</code>
@endsection