@extends('layouts.menu')
@section('title', '/ Regional Crear')

@section('page_heading', 'Crear Regional')

@section('section')
{{ Form::open(['route' => 'gyf.regionales.store', 'class' => 'form-horizontal']) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

{{ Form::close() }}
@endsection
