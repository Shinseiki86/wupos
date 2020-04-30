@extends('layouts.menu')
@section('title', '/ Tipo Pregunta Editar')

@section('page_heading', 'Editar Tipo Pregunta')

@section('section')
{{ Form::model($preguntatipo, ['action' => ['Encuestas\PreguntaTipoController@update', $preguntatipo->PRTI_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

{{ Form::close() }}
@endsection