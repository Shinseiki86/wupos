@extends('layouts.menu')
@section('title', '/ Operador Crear')

@section('page_heading', 'Crear Operador')

@section('section')
{{ Form::open(['route' => 'wu.operadores.store', 'class' => 'form-horizontal']) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

{{ Form::close() }}
@endsection
