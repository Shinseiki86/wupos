@extends('layouts.menu')
@section('title', '/ Agencia Editar')

@section('page_heading', 'Editar Agencia')

@section('section')
{{ Form::model($model, ['action' => ['Gyf\AgenciaController@update', $model->getKey() ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

{{ Form::close() }}
@endsection