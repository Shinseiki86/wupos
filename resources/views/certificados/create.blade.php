@extends('layout')
@section('title', '/ Certificado / Crear')

@section('head')
    {!! Html::script('assets/js/angular/angular.min.js') !!}
@endsection

@section('scripts')
<script>
	var appWupos = angular.module('appWupos', [], function($interpolateProvider) {
		$interpolateProvider.startSymbol('{%');
		$interpolateProvider.endSymbol('%}');
	});

	appWupos.controller('CertificadosCtrl', ['$scope', function($scope){
    	$scope.arrRegionales = {!! $arrRegionales !!};
    	$scope.selectedRegional = '';
    	$scope.arrAgencias = {!! $arrAgencias !!};
    	$scope.selectedAgencia = '';

	}]);

</script>
@parent
@endsection

@section('content')

	<h1 class="page-header">Nuevo Certificado</h1>

	@include('partials/errors')

<div class="" ng-app="appWupos" ng-controller="CertificadosCtrl">

	{{ Form::open( [ 'url' => 'certificados' ] ) }}

		<div class="form-group{{ $errors->has('CERT_codigo') ? ' has-error' : '' }}">
			{{ Form::label('CERT_codigo', 'Terminal WUPOS', ['class'=>'col-md-4 control-label', 'for'=>'CERT_codigo']) }}
			<div class="col-md-6">
			{{ Form::text('CERT_codigo', old('CERT_codigo'), [ 'class'=>'form-control', 'maxlength'=>'4', 'required' ]) }}
				@if ($errors->has('CERT_codigo'))
					<span class="help-block">
						<strong>{{ $errors->first('CERT_codigo') }}</strong>
					</span>
				@endif
			</div>
		</div>


		<div class="form-group{{ $errors->has('CERT_equipo') ? ' has-error' : '' }}">
			{{ Form::label('CERT_equipo', 'Hostname', ['class'=>'col-md-4 control-label', 'for'=>'CERT_equipo']) }}
			<div class="col-md-6">
				{{ Form::text('CERT_equipo', old('CERT_equipo'), [ 'class'=>'form-control', 'maxlength'=>'15', 'required' ]) }}
				@if ($errors->has('CERT_equipo'))
					<span class="help-block">
						<strong>{{ $errors->first('CERT_equipo') }}</strong>
					</span>
				@endif
			</div>
		</div>


		<div class="form-group{{ $errors->has('REGI_id') ? ' has-error' : '' }}">
			{{ Form::label('REGI_id', 'Regional', ['class'=>'col-md-4 control-label', 'for'=>'REGI_id']) }}
			<div class="col-md-6">
				<select class="form-control" ng-model="filterRegi.REGI_id" id="REGI_id" name="REGI_id" ng-required="required" required>
					<option value="" seleted>TODAS</option>
					<option value="{% regional.REGI_id %}" ng-repeat="regional in arrRegionales">{% regional.REGI_nombre %}</option>
				</select>
				@if ($errors->has('REGI_id'))
					<span class="help-block">
						<strong>{{ $errors->first('REGI_id') }}</strong>
					</span>
				@endif
			</div>
		</div>

		<div class="form-group{{ $errors->has('AGEN_id') ? ' has-error' : '' }}">
			{{ Form::label('AGEN_id', 'Agencia', ['class'=>'col-md-4 control-label', 'for'=>'AGEN_id']) }}
			<div class="col-md-6">
				<select class="form-control" ng-model="selectedAgencia" id="AGEN_id" name="AGEN_id" ng-required="required" required>
					<option value="" disabled>Seleccione una agencia</option>
					<option value="{% agencia.AGEN_id %}"
						ng-repeat="agencia in arrAgencias | filter:filterRegi | orderBy:'AGEN_nombre'">
						{% agencia.AGEN_codigo + ' - ' + agencia.AGEN_nombre %}
					</option>
				</select>
				@if ($errors->has('AGEN_id'))
					<span class="help-block">
						<strong>{{ $errors->first('AGEN_id') }}</strong>
					</span>
				@endif
			</div>
		</div>

		<!-- Botones -->
		<div class="text-right">
			<a class="btn btn-primary" role="button" href="{{ URL::to('certificados') }}">
				<i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar
			</a>
			{{ Form::button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', [ 'class'=>'btn btn-primary', 'type'=>'submit' ]) }}
		</div>

	{{ Form::close() }}
</div>
@endsection