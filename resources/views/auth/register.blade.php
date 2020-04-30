@extends('layouts.menu')
@section('title', 'Usuario Crear')

@section('page_heading', 'Crear Usuario')

@section('section')
{{ Form::open(['url' => 'register', 'class' => 'form-horizontal']) }}
	<div class='col-md-8 col-md-offset-2'>

		<!-- Elementos del formulario -->
		@rinclude('form-inputs')

		@include('widgets.forms.input', ['type'=>'password', 'name'=>'password', 'label'=>'Contraseña' ])
		@include('widgets.forms.input', ['type'=>'password', 'name'=>'password_confirmation', 'label'=>'Confirmar Contraseña' ])

		<!-- Botones -->
		@include('widgets.forms.buttons', ['url' => 'auth/usuarios'])

	</div>
{{ Form::close() }}
@endsection
