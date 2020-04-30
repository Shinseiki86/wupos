@extends('layouts.menu')
@section('title', '/ Tipo Pregunta Crear')

@section('page_heading', 'Nuevo Tipo Pregunta')

@section('section')
{{ Form::open(['route' => 'encuestas.preguntatipos.store', 'class' => 'form-horizontal']) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

{{ Form::close() }}
@endsection
