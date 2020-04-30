<?php
	if(!isset($preview)) $preview = false;
	$encuesta = $preguntas->first()->encuesta;
?>
@extends('layouts.menu')
@section('title', '/ Encuesta '.$ENCU_ID.' / Respuestas')

@push('head')
	<style type="text/css">
		.escala {
			width: 10px;
			padding-left: 4px !important;
			padding-right: 4px !important;
			vertical-align: middle !important;
		}
	</style>
@endpush

@push('scripts')
	{!! Html::script('js/jquery/jquery.validate.min.js') !!}
	{!! Html::script('js/jquery/jquery.countdown.min.js') !!}
	@rinclude('index-scriptNav')
@endpush


@section('page_heading')
	<div class="row">
		<div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
			{{ $encuesta->ENCU_TITULO }} {!! ($preview == true ? '<small>VISTA PREVIA</small>' : '') !!}
		</div>
		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
			
		</div>
	</div>
@endsection

@section('section')
	<div class="panel panel-primary">
		<div class="panel-heading">Infomación</div>
		<div class="panel-body">
			<div class="text-justify">
				<p>{!! str_replace('script', '', $encuesta->ENCU_DESCRIPCION) !!}</p>
				Abierta hasta el: <strong>{{ datetime($encuesta->ENCU_FECHAVIGENCIA, true) }}</strong><br>
				Finaliza en: <strong><span id="countdownVigencia"></span></strong>
			</div>
		</div>
	</div>

	{{ Form::open([ 'url'=>'encuestas/'.$ENCU_ID.'/resps', 'id'=>'formResps', 'class'=>'form-vertical', $preview == true ? 'readonly' : '', ]) }}

		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 itemValidate form-group">
			@if($encuesta->ENCU_PARADOCENTE)
				<label for="DOAC_ID">Docente: <span class="showError"></span></label>
				{{ Form::select('DOAC_ID', $docentes , old('DOAC_ID'), [
					'id'=>'DOAC_ID',
					'class' => 'form-control'.(!$preview ? ' required' : ''),
					'title' => 'Requerido!',
					'place-holder' => 'Seleccione un docente...',
					!$preview ? ' required' : '',
				]) }}
			@endif
		</div>

		<div class="col-xs-12">
			<ul id="tabsPregs" class="nav nav-tabs" role="tablist">
				@foreach($preguntas as $preg)
				<li role="presentation" data-tooltip="tooltip" title="{{ $preg->PREG_TITULO }}">
					<a data-toggle="tab" href="#preg{{ $preg->PREG_POSICION }}">
						{{ $preg->PREG_POSICION }}
					</a>
				</li>
				@endforeach
			</ul>
		</div>

		<div class="col-xs-12" style="padding: 0;">
			<div id="preguntas" class="tab-content">
				@foreach($preguntas as $preg)
				<div id="preg{{ $preg->PREG_POSICION }}" class="tab-pane fade in">
					@if($preg->PRTI_ID == 1)
						@rinclude('preg_abierta')
					@elseif($preg->PRTI_ID == 2)
						@rinclude('preg_booleana')
					@elseif($preg->PRTI_ID == 3)
						@rinclude('preg_escala')
					@elseif($preg->PRTI_ID == 4)
						@rinclude('preg_eleccion_unica')
					@elseif($preg->PRTI_ID == 5)
						@rinclude('preg_eleccion_multiple')
					@endif
				</div>
				@endforeach
			</div>
		</div>

		@rinclude('index-btnsNav')
	{{ Form::close() }}

	<!--  Mensaje Modal. Bloquea la pantalla mientras se procesa la solicitud  -->
	<div class="modal fade" id="msgModalSaving" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<h4 class="">
						<i id="iconFont" class="fa fa-spinner fa-pulse fa-3x fa-fw" style="vertical-align: middle;"></i>
						<span id="modal-text"></span>
					</h4>
				</div>
				<div class="modal-footer hide">
					<button type="button" class="btn btn-default" data-dismiss="modal">
						<i class="fa fa-times" aria-hidden="true"></i> Cerrar
					</button>
				</div>
			</div>
		</div>
	</div>

@endsection