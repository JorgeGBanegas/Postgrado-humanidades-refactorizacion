@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Estadisticas Programas')

@section('content-body')

@livewire('graficas-inscritos-programas')

@endsection
@section('visitas')
<code>Visitas: {{$visitas->contador}}</code>
@endsection