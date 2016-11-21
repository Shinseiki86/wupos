@extends('layout')
@section('title', '/ Editar Agencia '.$agencia->AGEN_codigo)
@section('scripts')
    <script>
    </script>
@endsection

@section('content')

	<h1 class="page-header">Actualizar Agencia</h1>

	@include('partials/errors')

	{{ Form::model($agencia, array('action' => array('AgenciaController@update', $agencia->AGEN_id), 'method' => 'PUT', 'class' => 'form-horizontal')) }}

		<div class="form-group{{ $errors->has('AGEN_codigo') ? ' has-error' : '' }}">
			{{ Form::label('AGEN_codigo', 'Código', ['class'=>'col-md-4 control-label', 'for'=>'AGEN_codigo']) }}
			<div class="col-md-6">
				<a href="#" title="No editable" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Código no puede ser editado.">
				{{ Form::number('AGEN_codigo', old('AGEN_codigo'), [ 'class' => 'form-control', 'min' => '0', 'disabled' ]) }}
				</a>
				@if ($errors->has('AGEN_codigo'))
					<span class="help-block">
						<strong>{{ $errors->first('AGEN_codigo') }}</strong>
					</span>
				@endif
			</div>
		</div>

		<div class="form-group{{ $errors->has('AGEN_nombre') ? ' has-error' : '' }}">
			{{ Form::label('AGEN_nombre', 'Nombre', ['class'=>'col-md-4 control-label', 'for'=>'AGEN_nombre']) }}
			<div class="col-md-6">
				{{ Form::text('AGEN_nombre', old('AGEN_nombre'), [ 'class' => 'form-control', 'max' => '100', 'required' ]) }}
				@if ($errors->has('AGEN_nombre'))
					<span class="help-block">
						<strong>{{ $errors->first('AGEN_nombre') }}</strong>
					</span>
				@endif
			</div>
		</div>

		<div class="form-group{{ $errors->has('AGEN_descripcion') ? ' has-error' : '' }}">
			{{ Form::label('AGEN_descripcion', 'Descripción', ['class'=>'col-md-4 control-label', 'for'=>'AGEN_descripcion']) }}
			<div class="col-md-6">
				{{ Form::text('AGEN_descripcion', old('AGEN_descripcion'), [ 'class' => 'form-control', 'max' => '255' ]) }}
				@if ($errors->has('AGEN_descripcion'))
					<span class="help-block">
						<strong>{{ $errors->first('AGEN_descripcion') }}</strong>
					</span>
				@endif
			</div>
		</div>

		<div class="form-group{{ $errors->has('AGEN_activa') ? ' has-error' : '' }}">
			{{ Form::label('AGEN_activa', 'Activa?', ['class'=>'col-md-4 control-label', 'for'=>'AGEN_activa']) }}
			<div class="col-md-6">
				{{ Form::checkbox('AGEN_activa', old('AGEN_activa'),true, ['class'=>'form-control']) }}
				@if ($errors->has('AGEN_activa'))
					<span class="help-block">
						<strong>{{ $errors->first('AGEN_activa') }}</strong>
					</span>
				@endif
			</div>
		</div>
			

		<div class="form-group{{ $errors->has('REGI_id') ? ' has-error' : '' }}">
			{{ Form::label('REGI_id', 'Regional', ['class'=>'col-md-4 control-label', 'for'=>'REGI_id']) }}
			<div class="col-md-6">
				{{ Form::select('REGI_id', [null => 'Seleccione una regional...'] + $arrRegionales , old('REGI_id'), ['class' => 'form-control', 'required']) }}
				@if ($errors->has('REGI_id'))
					<span class="help-block">
						<strong>{{ $errors->first('REGI_id') }}</strong>
					</span>
				@endif
			</div>
		</div>

		<!-- Botones -->
	    <div id="btn-form" class="text-right">
	    	{{ Form::button('<i class="fa fa-exclamation" aria-hidden="true"></i> Reset', array('class'=>'btn btn-warning', 'type'=>'reset')) }}
	        <a class="btn btn-warning" role="button" href="{{ URL::to('agencias/') }}">
	            <i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar
	        </a>
			{{ Form::button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Actualizar', array('class'=>'btn btn-primary', 'type'=>'submit')) }}
	    </div>

	{{ Form::close() }}
    </div>

@endsection