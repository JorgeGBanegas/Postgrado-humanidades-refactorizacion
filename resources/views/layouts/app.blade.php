@extends('layouts/commonMaster' )

@section('layoutContent')
<div id="app">
    <main class="py-4">
        @yield('content')
    </main>
</div>
@endsection