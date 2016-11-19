@extends('layout')
@section('title', '/ Encuesta / '.$encuesta->ENCU_id)




@section('content')
	<div class="jumbotron">

		<div class="row">
			<div class="col-sm-8">
				<h3 class="page-header"><strong>Encuesta # {{ $encuesta->ENCU_id }}:</strong> {{ $encuesta->ENCU_titulo }}</h2>
				Fecha vigencia: {{ date_format(new DateTime($encuesta->ENCU_fechavigencia), 'Y-m-d H:i') }}
			</div>
			<div id="btn-encuesta" class="col-sm-4 text-right">
					<!-- botón de vista previa para responder la encuesta  fa-list-alt -->
					<a class="btn btn-sm btn-success" href="{{ URL::to('encuestas/'. $encuesta->ENCU_id .'/preview') }}">
						<i class="fa fa-list-ol" aria-hidden="true"></i> Vista previa
					</a>

				@if($encuesta->estadoEncuesta->ESEN_id == Wupos\EstadoEncuesta::ABIERTA)
					<!-- Botón de editar la encuesta -->
					<a class="btn btn-sm btn-info" role='button' href="{{ URL::to('encuestas/'. $encuesta->ENCU_id .'/edit') }}">
						<i class="fa fa-pencil" aria-hidden="true"></i> Editar Encuesta
					</a>
				<!-- botón de aprobar la encuesta -->
					<a class="btn btn-sm btn-success" href="{{ URL::to('encuestas/'. $encuesta->ENCU_id .'/publicar') }}">
						<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Publicar
					</a>
				@else
					<!-- carga botón de reporte -->
					<a class="btn btn-sm btn-info" href="{{ URL::to('encuestas/'. $encuesta->ENCU_id .'/reportes') }}">
						<i class="fa fa-line-chart" aria-hidden="true"></i> Reportes
					</a>
				@endif
				@if($encuesta->estadoEncuesta->ESEN_id == Wupos\EstadoEncuesta::PUBLICADA)
					<!-- botón de cerrar la encuesta -->
					{{ Form::button('<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Cerrar',[
							'class'=>'btn btn-warning',
							'data-toggle'=>'modal',
							'data-target'=>'#pregModalCerrarENCU',
						]) }}
				@endif
			</div>
		</div>

		<p>
			@include('preguntas/index')
		</p>
	</div>


<!-- Mensaje Modal para cierre de encuesta -->
<div class="modal fade" id="pregModalCerrarENCU" role="dialog" tabindex="-1" >
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Cerrar?</h4>
			</div>
			<div class="modal-body">
				<p>
					<i class="fa fa-exclamation-triangle"></i> ¿Desea cerrar la encuesta {{ $encuesta->ENCU_id }}?


					<!-- FORM para cambiar cerrar la encuesta -->
					{{ Form::open( ['url' => 'encuestas/'. $encuesta->ENCU_id .'/cerrar', 'class' => 'form-horizontal'] ) }}
						{{ Form::label('ENCU_motivoCierre', 'Motivo del cierre de la encuesta:') }}
						{{ Form::textarea('ENCU_motivoCierre', old('ENCU_motivoCierre'), ['class' => 'form-control', 'size' => '20x3', 'placeholder' => 'Escriba aquí...', 'style' => 'resize: vertical', 'required']) }}

				</p>
			</div>
				<div class="modal-footer">
						{{ Form::button('<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Cerrar', [ 'class'=>'btn btn-success', 'type'=>'submit' ]) }}
					{{ Form::close() }}
				</div>
		</div>
	</div>
</div>


@endsection