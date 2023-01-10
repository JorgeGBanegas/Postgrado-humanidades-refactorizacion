@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Lista de certificados')

@section('content-body')

<div>
    @livewire('certificados-programas')
</div>

@endsection