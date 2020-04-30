@extends('layouts.menu')
@section('page_heading', 'Nuevo Parametro General')

@section('section')
{{ Form::open(['route' => 'app.parametrosgenerales.store', 'class' => 'form-horizontal']) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'app/parametrosgenerales'])

{{ Form::close() }}
@endsection
