@extends('layouts.sections.menu.burguerMenu')
@extends('layouts.sections.footer.footer')
@section('title', 'Home')

@section('content-body')

<div style="text-align: center;">
    <img src="{{ asset('assets/img/logo/postgradoHumanidades.jpg') }}" alt="">
</div>
@endsection

@section('visitas')
<code>Visitas: {{$visitas->contador}}</code>
@endsection