@extends('layout')
@section('title', '/ Crear Tipo Unidad')

@section('content')

	<h1 class="page-header">Nuevo Regional</h1>

	@include('partials/errors')
	
		{{ Form::open(array('url' => 'regionales', 'class' => 'form-horizontal')) }}

	  	<div class="form-group">
			{{ Form::label('REGI_nombre', 'Nombre') }} 
			{{ Form::text('REGI_nombre', old('REGI_nombre'), array('class' => 'form-control', 'max' => '300', 'required')) }}
		</div>

		<div class="text-right">
			{{ Form::button('<i class="fa fa-undo" aria-hidden="true"></i> Reset', array('class'=>'btn btn-warning', 'type'=>'reset')) }}
			<a class="btn btn-warning" role="button" href="{{ URL::to('regionales') }}">
				<i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar
			</a>
			{{ Form::button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', array('class'=>'btn btn-primary', 'type'=>'submit')) }}
		</div>

		
		{{ Form::close() }}
@endsection
