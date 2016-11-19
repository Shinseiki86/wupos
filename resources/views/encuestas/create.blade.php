@extends('layout')
@section('title', '/ Encuesta / Crear')

@section('head')
	{!! Html::style('assets/css/bootstrap-multiselect.css') !!}
	{!! Html::style('assets/css/bootstrap-datetimepicker.css') !!}
	<style type="text/css">
		.multiselect-container>li>a>label {
		  padding: 4px 20px 3px 20px;
		}
	</style>
@endsection

@section('scripts')
	{!! Html::script('assets/js/bootstrap-multiselect.js') !!}
	{!! Html::script('assets/js/momentjs/moment-with-locales.js') !!}
	{!! Html::script('assets/js/bootstrap-datetimepicker.js') !!}
	<script type="text/javascript">

		$(function () {

			$('#ROLE_ids').multiselect({
				includeSelectAllOption: true
			});


			$('#dttmpicker').datetimepicker({
				locale: 'es',
				//inline: true,
				format: 'YYYY/MM/DD HH:mm',
				extraFormats: [ 'YY/MM/DD HH:mm' ],
				minDate: new Date(),
				sideBySide: true,
				icons: {
						time: "fa fa-clock-o",
						date: "fa fa-calendar",
						up: "fa fa-arrow-up",
						down: "fa fa-arrow-down"
				}
			});
		});
	</script>
@endsection

@section('content')

	<h1 class="page-header">Nueva Encuesta</h1>

	@include('partials/errors')

	{{ Form::open( [ 'url' => 'encuestas' ] ) }}

		<div class="form-group">
			{{ Form::label('ENCU_titulo', 'Título') }}
			{{ Form::text('ENCU_titulo', old('ENCU_titulo'), [ 'class' => 'form-control', 'required' ]) }}
		</div>

		<div class="form-group">
			{{ Form::label('ENCU_descripcion', 'Descripción') }}
			{{ Form::textarea('ENCU_descripcion', old('ENCU_descripcion'), ['class' => 'form-control', 'size' => '20x3', 'placeholder' => 'Escriba aquí...', 'style' => 'resize: vertical', 'required']) }}
		</div>



		<div class="form-group ">
			{{ Form::label('ENCU_fechavigencia', 'Vigencia') }}
			<div class='input-group date' id='dttmpicker'>
				{{ Form::text('ENCU_fechavigencia', old('ENCU_fechavigencia'), [ 'class' => 'form-control', 'required' ]) }}
				<span class="input-group-addon">
						<span class="fa fa-calendar"></span>
				</span>
			</div>
		</div>



		<div class="input-group col-lg-4">
			<span class="input-group-addon">¿Es plantilla?: </span>
			<span class="input-group-addon">
				{{ Form::checkbox('ENCU_plantilla', true,old('ENCU_plantilla'), array('class' => 'form-control')) }}
			</span>
		</div><br>


		<div class="input-group col-lg-4">
			<span class="input-group-addon">¿Pública?: </span>
			<span class="input-group-addon">
				{{ Form::checkbox('ENCU_plantillapublica', true,old('ENCU_plantillapublica'), array('class' => 'form-control')) }}
			</span>
		</div><br>




	<div class="form-group">
		<select id="ROLE_ids" multiple="multiple">
			@foreach($roles as $rol)
				<option value="{{ $rol->ROLE_id }}">{{ $rol->ROLE_descripcion }}</option>
			@endforeach
		</select>
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