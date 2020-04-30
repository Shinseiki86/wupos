@extends('layouts.menu')
@section('title', '/ Operador Editar')

@section('page_heading', 'Editar Operador')

@section('section')
{{ Form::model($model, ['action' => ['Wu\OperadorController@update', $model->getKey() ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

{{ Form::close() }}
@endsection