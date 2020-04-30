@extends('layouts.menu')
@section('title', '/ Agencia Crear')

@section('page_heading', 'Crear Agencia')

@section('section')
{{ Form::open(['route' => 'gyf.agencias.store', 'class' => 'form-horizontal']) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

{{ Form::close() }}
@endsection
