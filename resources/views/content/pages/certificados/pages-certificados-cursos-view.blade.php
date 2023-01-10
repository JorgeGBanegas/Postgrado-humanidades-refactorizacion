@extends('layouts.sections.menu.burguerMenu')

@section('title', 'Ver Certificado')

@section('content-body')

<div class="container d-flex" style="
        width: 800px;
        height: 600px;
        padding: 20px;
        text-align: center;
        border: 10px solid #29387d;
        background-color: #ffffff;
      text-align: center;">
    <div style="
          width: 750px;
          height: 550px;
          padding: 20px;
          text-align: center;
          border: 5px solid #29387d;
          margin: 0px auto;
           display: flex;
  flex-direction: column;
        ">
        <div>
            <span style="font-size: 25px; font-weight: bold">Universidad Autonoma "Gabriel Rene Moreno"</span>
            <br>
            <span style="font-size: 20px"><i>Facultad de humanidades</i></span>
            <br>
            <span style="font-size: 20px"><i>Unidad de Postgrado</i></span>
            <br>
        </div>
        <br>
        <div>
            <span style="font-size: 30px; font-family: serif; font-style: italic"><b>Certificado de Finalizacion </b></span><br /><br />
            <span style="font-size: 20px; "><b>{{$certificado->curs->curs_nom}}</b></span><br /><br />
            <br>
            <span style="font-size: 25px"><i>Otorgado a: {{ $certificado->persona->per_nom. " ".$certificado->persona->per_appm}}</i></span>
            <br>
            <span style="font-size: 18px">{{$certificado->cert_curs_descrip}}</span> <br /><br />
            <br>

        </div>

        <div style="text-align: right;">
            <span style="font-size: 15px;"><i>Bolivia, {{strftime(' %e de %B de %Y', $certificado->cert_curs_fecha->getTimestamp())}}</i></span><br />
        </div>


    </div>
</div>
<div class="container">
    <a type="button" style="margin-top: 20px;" class="btn btn-primary" href="{{route('certificados-curso.index')}}">Volver</a>
</div>
@endsection