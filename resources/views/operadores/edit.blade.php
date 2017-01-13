@extends('layout')
@section('title', '/ Operador / Editar '. $operador->CERT_codigo )

@section('head')
    {!! Html::script('assets/js/angular/angular.min.js') !!}
@endsection

@section('scripts')
<script>
	var appWupos = angular.module('appWupos', [], function($interpolateProvider) {
		$interpolateProvider.startSymbol('{%');
		$interpolateProvider.endSymbol('%}');
	});

	appWupos.controller('OperadoresCtrl', ['$scope', function($scope){
    	$scope.arrRegionales = {!! $arrRegionales !!};
    	$scope.selectedRegional = '{{ $operador->agencia->REGI_id }}';

	}]);

</script>
@endsection

@section('content')
	<h1 class="page-header">Editar Operador {{ $operador->CERT_codigo }}</h1>

	@include('partials/errors')

<div class="" ng-app="appWupos" ng-controller="OperadoresCtrl">
	{{ Form::model($operador, [ 'action' => ['OperadorController@update', $operador->CERT_id], 'method' => 'PUT' ]) }}

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
					<option value=""></option>
					<option ng-seleted="regional.REGI_id==selectedRegional" value="{% regional.REGI_id %}" ng-repeat="regional in arrRegionales"> {% regional.REGI_nombre %}</option>
				</select>
				@if ($errors->has('REGI_id'))
					<span class="help-block">
						<strong>{{ $errors->first('REGI_id') }}</strong>
					</span>
				@endif
			</div>
		</div>


		<!-- Botones -->
		<div class="text-right">
			<a class="btn btn-primary" role="button" href="{{ URL::to('operadores') }}">
				<i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar
			</a>
			{{ Form::button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Actualizar', [ 'class'=>'btn btn-primary', 'type'=>'submit' ]) }}
		</div>

	{{ Form::close() }}
</div>
@endsection