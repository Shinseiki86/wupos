@extends('layouts.menu')
@section('page_heading', 'Nuevo Item del Menú')

@section('section')
{{ Form::open(['route' => 'app.menu.store', 'class' => 'form-horizontal']) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'app/menu'])

{{ Form::close() }}
@endsection
