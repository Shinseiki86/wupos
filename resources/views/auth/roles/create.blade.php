@extends('layouts.menu')
@section('title', '/ Rol Crear')

@section('page_heading', 'Crear Rol')

@section('section')
{{ Form::open(['route' => 'auth.roles.store', 'class' => 'form-horizontal']) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

{{ Form::close() }}
@endsection
