@extends('layouts.menu')
@section('title', '/ Certificado Editar')

@section('page_heading', 'Editar Certificado')

@section('section')
{{ Form::model($model, ['action' => ['Wu\CertificadoController@update', $model->getKey() ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

{{ Form::close() }}
@endsection