@extends('layouts.menu')
@section('title', '/ Upload File')

@section('page_heading')
	<div class="row">
		<div id="title" class="col-xs-8 col-md-6 col-lg-6">
			Carga masiva de datos
		</div>
	</div>
@endsection

@section('section')

	{{ Form::open( [ 'route'=>'app.upload', 'class'=>'form-vertical', 'files'=>true ]) }}

		<div class="text-right">
			<a class='btn btn-info' role='button' href="{{ asset('templates/TemplateCargaDatos.xlsx') }}" download>
				<i class="fas fa-download" aria-hidden="true"></i> Descargar plantilla
			</a>
		</div>
		<div class="form-group">
			{{ Form::label('archivo', 'Archivo') }}
			{{ Form::file('archivo', [ 'class' => 'form-control', 'required' ]) }}
		</div>

		<!-- Botones -->
		<div class="text-right">
			{{ Form::button('<i class="fas fa-cloud-upload" aria-hidden="true"></i> Cargar', [ 'class'=>'btn btn-primary', 'type'=>'submit' ]) }}
		</div>

	{{ Form::close() }}

<hr/>
@if(Session::has('error'))
	<div class="row">
	    <div class="alert alert-danger" style="max-height: 150px; overflow-y: auto;">
	        <ul>
	        	@foreach (Session::get('error') as $error)
	        		<li> {{ $error }} </li>
	        	@endforeach
	        </ul>
	    </div>
	</div>
@endif
@if(Session::has('success'))
	<div class="row">
	    <div class="alert alert-success" style="max-height: 150px; overflow-y: auto;">
	        <ul>
	        	@foreach (Session::get('success') as $success)
	        		<li> {{ $success }} </li>
	        	@endforeach
	        </ul>
	    </div>
	</div>
@endif


@endsection