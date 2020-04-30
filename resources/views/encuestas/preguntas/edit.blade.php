@extends('layouts.menu')
@section('title', '/ Pregunta '.$preg->PREG_ID.' / Editar' )
@section('page_heading', 'Editar Pregunta #'.$preg->PREG_ID.' en Encuesta #'.$preg->encuesta->ENCU_ID)

@section('section')
	{{ Form::model($preg, ['action' => ['Encuestas\PreguntaController@update', $preg->encuesta->ENCU_ID, $preg->PREG_ID], 'method'=>'PUT', 'class'=>'form-vertical']) }}

		<!-- Elementos del formulario -->
		@rinclude('form-inputs')


	{{ Form::close() }}
@endsection