@extends('layouts.menu')
@section('title', '/ '. $strTitulo .' / '.$encuesta->ENCU_ID)

@section('page_heading')
	<div class="row">
		<div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
			{{$strTitulo}} # {{ $encuesta->ENCU_ID }} <small>{{ $encuesta->ENCU_TITULO }}</small>
		</div>
		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
			@rinclude('show-BtnsHeader')
		</div>
	</div>
@endsection

@section('section')
	@rinclude('show-info')
	@include('encuestas/preguntas/index')
	@rinclude('show-modalLink')
	@rinclude('show-modalPublicar')
	@rinclude('show-modalCerrar')
@endsection