@extends('layout')
@section('title', '/ Crear Agencia')

@section('content')

	<h1 class="page-header">Nueva Agencia</h1>

	@include('partials/errors')
	
	{{ Form::open([ 'url' => 'agencias', 'class' => 'form-horizontal' ]) }}

		<div class="form-group">
			{{ Form::label('AGEN_nombre', 'Nombre') }} 
			{{ Form::text('AGEN_nombre', old('AGEN_nombre'), [ 'class' => 'form-control', 'max' => '100', 'required' ]) }}
		</div>

		<div class="form-group">
			{{ Form::label('AGEN_codigo', 'Código') }} 
			{{ Form::text('AGEN_codigo', old('AGEN_codigo'), [ 'class' => 'form-control', 'max' => '40', 'required' ]) }}
		</div>

		<div class="input-group col-lg-4">
			<span class="input-group-addon">Activa: </span>
			<span class="input-group-addon">
				{{ Form::checkbox('AGEN_activa', true,old('AGEN_activa'), array('class' => 'form-control')) }}
			</span>
		</div><br>


		<div class="form-group">
			{{ Form::label('TIUN_id', 'Regional') }} 
			{{ Form::select('TIUN_id', [null => 'Seleccione una regional...'] + $regionales , old('TIUN_id'), ['class' => 'form-control', 'required']) }}
		</div>

		<!-- Botones -->
		<div class="text-right">
			{{ Form::button('<i class="fa fa-exclamation" aria-hidden="true"></i> Reset', [ 'class'=>'btn btn-warning', 'type'=>'reset' ]) }}
			<a class="btn btn-warning" role="button" href="{{ URL::to('agencias') }}">
				<i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar
			</a>
			{{ Form::button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', [ 'class'=>'btn btn-primary', 'type'=>'submit' ]) }}
		</div>

		
	{{ Form::close() }}
@endsection
