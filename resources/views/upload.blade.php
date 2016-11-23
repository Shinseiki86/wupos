@extends('layout')
@section('title', '/ Upload File')

@section('content')

	<h1 class="page-header">Subir Archivo</h1>

	@include('partials/errors')

	{{ Form::open( [ 'url'=>'upload', 'class'=>'form-vertical', 'files'=>true ]) }}

		<div class="form-group">
			{{ Form::label('archivo', 'Archivo') }}
			{{ Form::file('archivo', [ 'class' => 'form-control', 'required' ]) }}
		</div>

		<div class="form-group">
			{{ Form::label('clase', 'Clase') }}
			{{ Form::text('clase', old('clase'), [ 'class' => 'form-control', 'max' => '20', 'required' ]) }}
		</div>



		<!-- Botones -->
		<div class="text-right">
			<a class="btn btn-primary" role="button" href="{{ URL::to('encuestas') }}">
				<i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar
			</a>
			{{ Form::button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', [ 'class'=>'btn btn-primary', 'type'=>'submit' ]) }}
		</div>

	{{ Form::close() }}

@endsection