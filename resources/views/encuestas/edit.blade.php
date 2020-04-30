@extends('layouts.menu')
@section('title', '/ Editar '.$strTitulo)
@section('page_heading', 'Editar '.$strTitulo.' '.$encuesta->ENCU_ID)

@section('section')
{{ Form::model($encuesta, ['action'=>['Encuestas\EncuestaController@update', $encuesta->ENCU_ID ], 'method'=>'PUT', 'class'=>'form-vertical' ]) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	<div class="col-xs-12">
		@include('widgets.forms.buttons', ['url' => route(strtolower($strTitulo).'s.show',['ENCU_ID'=>$encuesta->ENCU_ID])])
	</div>

{{ Form::close() }}
@endsection
