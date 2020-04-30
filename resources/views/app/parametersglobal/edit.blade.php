@extends('layouts.menu')
@section('page_heading', 'Editar Parametro General')

@section('section')
{{ Form::model($parameterglobal, ['action' => ['App\ParameterGlobalController@update', $parameterglobal->PGLO_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'app/parametersglobal'])

{{ Form::close() }}
@endsection