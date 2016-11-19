@extends('layout')
@section('title', '/ Encuesta / Editar '. $encuesta->ENCU_id )

@section('head')
	{!! Html::style('assets/css/bootstrap-datetimepicker.css') !!}
@endsection

@section('scripts')
	{!! Html::script('assets/js/momentjs/moment-with-locales.js') !!}
	{!! Html::script('assets/js/bootstrap-datetimepicker.js') !!}

		<script type="text/javascript">
		$(function () {
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
	<h1 class="page-header">Editar {{ $encuesta->ENCU_id }}</h1>

	@include('partials/errors')

	{{ Form::model($encuesta, [ 'action' => ['EncuestaController@update', $encuesta->ENCU_id], 'method' => 'PUT' ]) }}

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
				{{ Form::text('ENCU_fechavigencia', old('ENCU_fechavigencia'), [ 'class' => 'form-control', 'required']) }}
				<span class="input-group-addon">
					<span class="fa fa-calendar"></span>
				</span>
			</div>
		</div>


		<!-- Botones -->
		<div class="text-right">
			<a class="btn btn-primary" role="button" href="{{ URL::to('encuestas/'. $encuesta->ENCU_id ) }}">
				<i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar
			</a>
			{{ Form::button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Actualizar', [ 'class'=>'btn btn-primary', 'type'=>'submit' ]) }}
		</div>

	{{ Form::close() }}

@endsection