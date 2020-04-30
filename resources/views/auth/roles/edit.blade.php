@extends('layouts.menu')
@section('title', '/ Rol Editar')

@section('page_heading', 'Editar Operador')

@section('section')
{{ Form::model($rol, ['action' => ['Auth\RoleController@update', $rol->id ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')


{{ Form::close() }}
@endsection