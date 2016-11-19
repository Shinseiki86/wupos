@extends('layout')
@section('title', '/ Editar Unidad '.$unidad->UNID_ID)
@section('scripts')
    <script>
    </script>
@endsection

@section('content')

	<h1 class="page-header">Actualizar Unidad</h1>

	@include('partials/errors')

	{{ Form::model($unidad, array('action' => array('UnidadController@update', $unidad->UNID_ID), 'method' => 'PUT', 'class' => 'form-horizontal')) }}

		<div class="form-group">
			{{ Form::label('UNID_NOMBRE', 'Nombre') }} 
			{{ Form::text('UNID_NOMBRE', old('UNID_NOMBRE'), [ 'class' => 'form-control', 'max' => '100', 'required' ]) }}
		</div>

		<div class="form-group">
			{{ Form::label('UNID_CODIGO', 'Código') }} 
			{{ Form::text('UNID_CODIGO', old('UNID_CODIGO'), [ 'class' => 'form-control', 'max' => '40', 'required' ]) }}
		</div>

		<div class="form-group">
			{{ Form::label('UNID_TELEFONO', 'Teléfono') }} 
			{{ Form::text('UNID_TELEFONO', old('UNID_TELEFONO'), [ 'class' => 'form-control', 'max' => '30', 'required' ]) }}
		</div>

		<div class="form-group">
			{{ Form::label('UNID_EXTTELEFONO', 'Extensión') }} 
			{{ Form::text('UNID_EXTTELEFONO', old('UNID_EXTTELEFONO'), [ 'class' => 'form-control', 'max' => '30', 'required' ]) }}
		</div>
		
		<div class="form-group">
			{{ Form::label('UNID_EMAIL', 'Email') }} 
			{{ Form::email('UNID_EMAIL', old('UNID_EMAIL'), [ 'class' => 'form-control', 'max' => '100', 'required' ]) }}
		</div>

		<div class="form-group">
			{{ Form::label('UNID_UBICACION', 'Ubicación') }} 
			{{ Form::text('UNID_UBICACION', old('UNID_UBICACION'), [ 'class' => 'form-control', 'max' => '50', 'required' ]) }}
		</div>

		<div class="form-group">
			{{ Form::label('UNID_NIVEL', 'Nivel') }} 
			{{ Form::text('UNID_NIVEL', old('UNID_NIVEL'), [ 'class' => 'form-control', 'max' => '10', 'required' ]) }}
		</div>

		<div class="input-group col-lg-4">
			<span class="input-group-addon">Unidad tiene asociado otros programas: </span>
			<span class="input-group-addon">
				{{ Form::checkbox('UNID_ASOCIAPROGRAMADIRECTA', true,old('UNID_ASOCIAPROGRAMADIRECTA'), array('class' => 'form-control')) }}
			</span>
		</div><br>

		<div class="input-group col-lg-4">
			<span class="input-group-addon">Unidad tiene asociado materias: </span>
			<span class="input-group-addon">
				{{ Form::checkbox('UNID_ASOCIAMATERIADIRECTA', true,old('UNID_ASOCIAMATERIADIRECTA'), array('class' => 'form-control')) }}
			</span>
		</div><br>

		<div class="input-group col-lg-4">
			<span class="input-group-addon">Unidad es una Regional: </span>
			<span class="input-group-addon">
				{{ Form::checkbox('UNID_REGIONAL', true,old('UNID_REGIONAL'), array('class' => 'form-control')) }}
			</span>
		</div><br>

		<div class="form-group">
			{{ Form::label('TIUN_ID', 'Tipo Unidad') }} 
			{{ Form::select('TIUN_ID', [null => 'Seleccione un tipo...'] + $arrTiposUnidades , old('TIUN_ID'), ['class' => 'form-control', 'required']) }}
		</div>

		<!-- Botones -->
	    <div id="btn-form" class="text-right">
	    	{{ Form::button('<i class="fa fa-exclamation" aria-hidden="true"></i> Reset', array('class'=>'btn btn-warning', 'type'=>'reset')) }}
	        <a class="btn btn-warning" role="button" href="{{ URL::to('unidad/') }}">
	            <i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar
	        </a>
			{{ Form::button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Actualizar', array('class'=>'btn btn-primary', 'type'=>'submit')) }}
	    </div>

	{{ Form::close() }}
    </div>

@endsection