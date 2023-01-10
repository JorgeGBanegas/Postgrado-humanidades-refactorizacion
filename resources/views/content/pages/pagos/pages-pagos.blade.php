@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Pagos de Programas')

@section('page-script')
<script src="{{asset('assets/js/ui-modals.js')}}"></script>
@endsection


@section('content-body')

@livewire('listado-index-plan-pago-prog')


@endsection