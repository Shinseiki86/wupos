@extends('layouts.menu')
@section('title', '/ Usuario Editar')

@section('page_heading', 'Editar Usuario')

@section('section')	
{{ Form::model($usuario, ['action' => ['Auth\RegisterController@update', $usuario->id ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}
	<div class='col-md-8 col-md-offset-2'>

		<!-- Elementos del formulario -->
		@rinclude('form-inputs')
		
		<!-- Botones -->
		@include('widgets.forms.buttons', ['url' => 'auth/usuarios'])

	</div>
{{ Form::close() }}
@endsection
