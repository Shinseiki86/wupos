@extends('layout')
@section('title', '/ Operador / Editar '. $operador->OPER_codigo )

@section('content')
	<h1 class="page-header">Editar Operador {{ $operador->OPER_cedula }}</h1>

	{{ Form::model($operador, [ 'action' => ['OperadorController@update', $operador->OPER_id], 'method' => 'PUT' ]) }}

		<div class="form-group{{ $errors->has('OPER_codigo') ? ' has-error' : '' }}">
			{{ Form::label('OPER_codigo', 'Código Operador', ['class'=>'col-md-4 control-label', 'for'=>'OPER_codigo']) }}
			<div class="col-md-6">
			{{ Form::number('OPER_codigo', old('OPER_codigo'), [ 'class'=>'form-control', 'maxlength'=>'3', 'readonly' ]) }}
				@if ($errors->has('OPER_codigo'))
					<span class="help-block">
						<strong>{{ $errors->first('OPER_codigo') }}</strong>
					</span>
				@endif
			</div>
		</div>

		<div class="form-group{{ $errors->has('OPER_cedula') ? ' has-error' : '' }}">
			{{ Form::label('OPER_cedula', 'Cédula', ['class'=>'col-md-4 control-label', 'for'=>'OPER_cedula']) }}
			<div class="col-md-6">
				{{ Form::number('OPER_cedula', old('OPER_cedula'), [ 'class'=>'form-control', 'maxlength'=>'15', 'required' ]) }}
				@if ($errors->has('OPER_cedula'))
					<span class="help-block">
						<strong>{{ $errors->first('OPER_cedula') }}</strong>
					</span>
				@endif
			</div>
		</div>

		<div class="form-group{{ $errors->has('OPER_nombre') ? ' has-error' : '' }}">
			{{ Form::label('OPER_nombre', 'Nombre', ['class'=>'col-md-4 control-label', 'for'=>'OPER_nombre']) }}
			<div class="col-md-6">
			{{ Form::text('OPER_nombre', old('OPER_nombre'), [ 'class'=>'form-control', 'maxlength'=>'100', 'required' ]) }}
				@if ($errors->has('OPER_nombre'))
					<span class="help-block">
						<strong>{{ $errors->first('OPER_nombre') }}</strong>
					</span>
				@endif
			</div>
		</div>

		<div class="form-group{{ $errors->has('OPER_apellido') ? ' has-error' : '' }}">
			{{ Form::label('OPER_apellido', 'Apellido', ['class'=>'col-md-4 control-label', 'for'=>'OPER_apellido']) }}
			<div class="col-md-6">
			{{ Form::text('OPER_apellido', old('OPER_apellido'), [ 'class'=>'form-control', 'maxlength'=>'100', 'required' ]) }}
				@if ($errors->has('OPER_apellido'))
					<span class="help-block">
						<strong>{{ $errors->first('OPER_apellido') }}</strong>
					</span>
				@endif
			</div>
		</div>

		<div class="form-group{{ $errors->has('REGI_id') ? ' has-error' : '' }}">
			{{ Form::label('REGI_id', 'Regional', ['class'=>'col-md-4 control-label', 'for'=>'REGI_id']) }}
			<div class="col-md-6">

				{{ Form::select('REGI_id', [null => 'Seleccione una Regional...'] + $arrRegionales , old('REGI_id'), ['class' => 'form-control', 'required']) }}

				@if ($errors->has('REGI_id'))
					<span class="help-block">
						<strong>{{ $errors->first('REGI_id') }}</strong>
					</span>
				@endif
			</div>
		</div>

		<div class="form-group{{ $errors->has('ESOP_id') ? ' has-error' : '' }}">
			{{ Form::label('ESOP_id', 'Estado', ['class'=>'col-md-4 control-label', 'for'=>'ESOP_id']) }}
			<div class="col-md-6">

				{{ Form::select('ESOP_id', $arrEstados , old('ESOP_id'), ['class' => 'form-control', 'required']) }}

				@if ($errors->has('ESOP_id'))
					<span class="help-block">
						<strong>{{ $errors->first('ESOP_id') }}</strong>
					</span>
				@endif
			</div>
		</div>



		<!-- Botones -->
		<div class="text-right">
			<a class="btn btn-primary" role="button" href="{{ URL::to('operadores') }}">
				<i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar
			</a>
			{{ Form::button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Actualizar', [ 'class'=>'btn btn-primary', 'type'=>'submit' ]) }}
		</div>

	{{ Form::close() }}
@endsection