@extends('layout')
@section('title', '/ Certificado / Editar '. $certificado->CERT_codigo )


@section('content')
	<h1 class="page-header">Editar Certificado {{ $certificado->CERT_codigo }}</h1>

	@include('partials/errors')

	{{ Form::model($certificado, [ 'action' => ['CertificadoController@update', $certificado->CERT_id], 'method' => 'PUT' ]) }}

		<div class="form-group">
			{{ Form::label('CERT_titulo', 'Título') }}
			{{ Form::text('CERT_titulo', old('CERT_titulo'), [ 'class' => 'form-control', 'required' ]) }}
		</div>
		
		<div class="form-group">
			{{ Form::label('CERT_descripcion', 'Descripción') }}
			{{ Form::textarea('CERT_descripcion', old('CERT_descripcion'), ['class' => 'form-control', 'size' => '20x3', 'placeholder' => 'Escriba aquí...', 'style' => 'resize: vertical', 'required']) }}
		</div>

		<div class="form-group ">
			{{ Form::label('CERT_fechavigencia', 'Vigencia') }}
			<div class='input-group date' id='dttmpicker'>
				{{ Form::text('CERT_fechavigencia', old('CERT_fechavigencia'), [ 'class' => 'form-control', 'required']) }}
				<span class="input-group-addon">
					<span class="fa fa-calendar"></span>
				</span>
			</div>
		</div>


		<!-- Botones -->
		<div class="text-right">
			<a class="btn btn-primary" role="button" href="{{ URL::to('certificados/'. $certificado->CERT_id ) }}">
				<i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar
			</a>
			{{ Form::button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Actualizar', [ 'class'=>'btn btn-primary', 'type'=>'submit' ]) }}
		</div>

	{{ Form::close() }}

@endsection