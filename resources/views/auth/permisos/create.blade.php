@extends('layouts.menu')
@section('title', '/ Permiso Crear')

@section('page_heading', 'Crear Permiso')

@section('section')
{{ Form::open(['route' => 'auth.permisos.store', 'class' => 'form-horizontal']) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

{{ Form::close() }}
@endsection
