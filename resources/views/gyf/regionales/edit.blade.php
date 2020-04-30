@extends('layouts.menu')
@section('title', '/ Regional Editar')

@section('page_heading', 'Editar Regional')

@section('section')
{{ Form::model($model, ['action' => ['Gyf\RegionalController@update', $model->getKey() ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

{{ Form::close() }}
@endsection