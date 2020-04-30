@extends('layouts.menu')
@section('title', '/ Encuesta '.$ENCU_ID.' / Nueva Pregunta')
@section('page_heading', 'Nueva Pregunta en Encuesta #'.$ENCU_ID )

@section('section')
	{{ Form::open([ 'url' => 'encuestas/'.$ENCU_ID.'/pregs', 'class'=>'form-vertical' ])}}

		<!-- Elementos del formulario -->
		@rinclude('form-inputs')

	{{ Form::close() }}
@endsection
