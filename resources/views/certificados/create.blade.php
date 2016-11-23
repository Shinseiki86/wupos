@extends('layout')
@section('title', '/ Certificado / Crear')

@section('content')

	<h1 class="page-header">Nuevo Certificado</h1>

	@include('partials/errors')

	{{ Form::open( [ 'url' => 'certificados' ] ) }}


		<div class="form-group{{ $errors->has('CERT_codigo') ? ' has-error' : '' }}">
			{{ Form::label('CERT_codigo', 'Código', ['class'=>'col-md-4 control-label', 'for'=>'CERT_codigo']) }}
			<div class="col-md-6">
			{{ Form::number('CERT_codigo', old('CERT_codigo'), [ 'class' => 'form-control', 'min' => '0', 'required' ]) }}
				@if ($errors->has('CERT_codigo'))
					<span class="help-block">
						<strong>{{ $errors->first('CERT_codigo') }}</strong>
					</span>
				@endif
			</div>
		</div>


		<div class="form-group{{ $errors->has('CERT_equipo') ? ' has-error' : '' }}">
			{{ Form::label('CERT_equipo', 'Nombre', ['class'=>'col-md-4 control-label', 'for'=>'CERT_equipo']) }}
			<div class="col-md-6">
				{{ Form::text('CERT_equipo', old('CERT_equipo'), [ 'class' => 'form-control', 'max' => '100', 'required' ]) }}
				@if ($errors->has('CERT_equipo'))
					<span class="help-block">
						<strong>{{ $errors->first('CERT_equipo') }}</strong>
					</span>
				@endif
			</div>
		</div>


		<div class="form-group{{ $errors->has('REGI_id') ? ' has-error' : '' }}">
			{{ Form::label('REGI_id', 'Regional', ['class'=>'col-md-4 control-label', 'for'=>'REGI_id']) }}
			<div class="col-md-6">
				{{ Form::select('REGI_id', $arrRegionales , old('REGI_id'), ['class'=>'form-control', 'placeholder'=>'Seleccione una regional...', 'required'=>true]) }}
				@if ($errors->has('REGI_id'))
					<span class="help-block">
						<strong>{{ $errors->first('REGI_id') }}</strong>
					</span>
				@endif
			</div>
		</div>

		<div class="form-group{{ $errors->has('AGEN_id') ? ' has-error' : '' }}">
			{{ Form::label('AGEN_id', 'Agencia', ['class'=>'col-md-4 control-label', 'for'=>'AGEN_id']) }}
			<div class="col-md-6">
				{{ Form::select('AGEN_id', $arrAgencias , old('AGEN_id'), ['class'=>'form-control', 'placeholder'=>'Seleccione una agencia...', 'required'=>true]) }}
				@if ($errors->has('AGEN_id'))
					<span class="help-block">
						<strong>{{ $errors->first('AGEN_id') }}</strong>
					</span>
				@endif
			</div>
		</div>

		<!-- Botones -->
		<div class="text-right">
			<a class="btn btn-primary" role="button" href="{{ URL::to('certificados') }}">
				<i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar
			</a>
			{{ Form::button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', [ 'class'=>'btn btn-primary', 'type'=>'submit' ]) }}
		</div>

	{{ Form::close() }}

@endsection