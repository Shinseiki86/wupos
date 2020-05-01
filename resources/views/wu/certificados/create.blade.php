@extends('layouts.menu')
@section('title', '/ Certificado Crear')

@section('page_heading', 'Crear Certificado')

@section('section')
{{ Form::open(['route' => 'wu.certificados.store', 'class' => 'form-horizontal']) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

{{ Form::close() }}
@endsection
