@extends('layouts.menu')
@section('title', '/ Permiso Editar')

@section('page_heading', 'Editar Permiso')

@section('section')
{{ Form::model($permiso, ['action' => ['Auth\PermissionController@update', $permiso->id ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

{{ Form::close() }}
@endsection