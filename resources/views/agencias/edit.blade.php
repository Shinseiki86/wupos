@extends('layout')
@section('title', '/ Editar Agencia '.$agencia->AGEN_id)
@section('scripts')
    <script>
    </script>
@endsection

@section('content')

	<h1 class="page-header">Actualizar Agencia</h1>

	@include('partials/errors')

	{{ Form::model($agencia, array('action' => array('AgenciaController@update', $agencia->AGEN_id), 'method' => 'PUT', 'class' => 'form-horizontal')) }}

		<div class="form-group">
			{{ Form::label('AGEN_nombre', 'Nombre') }} 
			{{ Form::text('AGEN_nombre', old('AGEN_nombre'), [ 'class' => 'form-control', 'max' => '100', 'required' ]) }}
		</div>

		<div class="form-group">
			{{ Form::label('AGEN_codigo', 'Código') }} 
			{{ Form::text('AGEN_codigo', old('AGEN_codigo'), [ 'class' => 'form-control', 'max' => '40', 'required' ]) }}
		</div>

		<div class="form-group">
			{{ Form::label('AGEN_TELEFONO', 'Teléfono') }} 
			{{ Form::text('AGEN_TELEFONO', old('AGEN_TELEFONO'), [ 'class' => 'form-control', 'max' => '30', 'required' ]) }}
		</div>

		<div class="form-group">
			{{ Form::label('AGEN_EXTTELEFONO', 'Extensión') }} 
			{{ Form::text('AGEN_EXTTELEFONO', old('AGEN_EXTTELEFONO'), [ 'class' => 'form-control', 'max' => '30', 'required' ]) }}
		</div>
		
		<div class="form-group">
			{{ Form::label('AGEN_EMAIL', 'Email') }} 
			{{ Form::email('AGEN_EMAIL', old('AGEN_EMAIL'), [ 'class' => 'form-control', 'max' => '100', 'required' ]) }}
		</div>

		<div class="form-group">
			{{ Form::label('AGEN_UBICACION', 'Ubicación') }} 
			{{ Form::text('AGEN_UBICACION', old('AGEN_UBICACION'), [ 'class' => 'form-control', 'max' => '50', 'required' ]) }}
		</div>

		<div class="form-group">
			{{ Form::label('AGEN_NIVEL', 'Nivel') }} 
			{{ Form::text('AGEN_NIVEL', old('AGEN_NIVEL'), [ 'class' => 'form-control', 'max' => '10', 'required' ]) }}
		</div>

		<div class="input-group col-lg-4">
			<span class="input-group-addon">Agencia tiene asociado otros programas: </span>
			<span class="input-group-addon">
				{{ Form::checkbox('AGEN_ASOCIAPROGRAMADIRECTA', true,old('AGEN_ASOCIAPROGRAMADIRECTA'), array('class' => 'form-control')) }}
			</span>
		</div><br>

		<div class="input-group col-lg-4">
			<span class="input-group-addon">Agencia tiene asociado materias: </span>
			<span class="input-group-addon">
				{{ Form::checkbox('AGEN_ASOCIAMATERIADIRECTA', true,old('AGEN_ASOCIAMATERIADIRECTA'), array('class' => 'form-control')) }}
			</span>
		</div><br>

		<div class="input-group col-lg-4">
			<span class="input-group-addon">Agencia es una Regional: </span>
			<span class="input-group-addon">
				{{ Form::checkbox('AGEN_REGIONAL', true,old('AGEN_REGIONAL'), array('class' => 'form-control')) }}
			</span>
		</div><br>

		<div class="form-group">
			{{ Form::label('TIUN_id', 'Tipo Agencia') }} 
			{{ Form::select('TIUN_id', [null => 'Seleccione un tipo...'] + $arrTiposAgencias , old('TIUN_id'), ['class' => 'form-control', 'required']) }}
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