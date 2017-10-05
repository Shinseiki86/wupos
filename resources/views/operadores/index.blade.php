@extends('layout')
@section('title', '/ Operadores')

@section('head')
	<style>
		/* Define el tamaño de los input-group-addon para que sean todos iguales */
		.input-group-addon {
			min-width:100px;
			text-align:left;
		}
		span[name=btnClear]{
			z-index: 999;
			cursor: pointer;
			pointer-events: all;
			font-size: 18px;
		}
	</style>
@parent
@endsection

@section('scripts')
	{!! Html::script('assets/js/angular/angular.min.js') !!}
	{!! Html::script('assets/js/angular/angular-animate.min.js') !!}
	{!! Html::script('assets/js/angular/angular-sanitize.min.js') !!}
	{!! Html::script('assets/js/angular/ui-bootstrap-tpls-2.5.0.min.js') !!}
	{!! Html::script('assets/js/angular/dirPagination.js') !!}
	{!! Html::script('assets/js/momentjs/moment-with-locales.min.js') !!}
	<script type="text/javascript">
		var appWupos = angular.module('appWupos', ['ngAnimate', 'ngSanitize', 'dirPagination', 'ui.bootstrap'], function($interpolateProvider) {
			$interpolateProvider.startSymbol('{%');
			$interpolateProvider.endSymbol('%}');
		});

		appWupos.controller('OperadoresCtrl', ['$scope', '$timeout', function($scope, $timeout){
			//Mostrar mensaje de carga
			$scope.load = false;

			//paginación
			if(!localStorage.currentPageOperador || !localStorage.pageSizeOperador){
				localStorage.currentPageOperador = 1
				localStorage.pageSizeOperador = 25;
			}
			$scope.currentPage = localStorage.currentPageOperador;
			$scope.$watch('currentPage', function(currentPage) {
				localStorage.currentPageOperador = currentPage;
			});
			$scope.pageSize = localStorage.pageSizeOperador;
			$scope.$watch('pageSize', function(pageSize) {
				localStorage.pageSizeOperador = pageSize;
			});

			//Ordenamiento
			if(!localStorage.sortTypeOperador || !localStorage.sortReverseOperador){
				localStorage.sortTypeOperador = 'OPER_codigo';
				localStorage.sortReverseOperador = false;
			}
			$scope.sortType = localStorage.sortTypeOperador;
			$scope.$watch('sortType', function(sortType) {
				localStorage.sortTypeOperador = sortType;
			});

			$scope.sortReverse = JSON.parse(localStorage.sortReverseOperador);
			$scope.$watch('sortReverse', function(sortReverse) {
				localStorage.sortReverseOperador = sortReverse;
			});

			//Filtros
			if(!localStorage.searchOperador)
				localStorage.searchOperador = null;
			$scope.isFiltered = false;
			if(localStorage.searchOperador != 'null' && localStorage.searchOperador != 'undefined'){
				if (localStorage.searchOperador[0] === '{'){
					$scope.isFiltered = true;
					$scope.searchOperador = JSON.parse(localStorage.searchOperador);
				} else {
					$scope.searchOperador = localStorage.searchOperador;
				}
			}
			$scope.toggleFormFilter = function() {
				$scope.isFiltered = !$scope.isFiltered;
				//if(!$scope.isFiltered && typeof $scope.searchOperador == 'object')
					$scope.searchOperador = null;
			}

			$scope.$watchCollection('searchOperador', function(filter) {
				if(typeof filter == 'object')
					localStorage.searchOperador = JSON.stringify(filter);
				else
					localStorage.searchOperador = filter;
			});

			//Formato de fecha
			$scope.formatDate = function(strDate){
				var strDateFormatted = '';
				if( jQuery.inArray( strDate, ['', null, 'undefined']) == -1 )
					strDateFormatted = moment(strDate).format('DD/MM/YYYY hh:mm A');
				return strDateFormatted;
			}

			//Rellenar número con ceros o un string a la izquierda
			$scope.padLeft = function(num, cant, str){
    			return Array(cant-String(num).length+1).join(str||'0')+num;
			}

			//Cambiar color de cada fila según el estado del operador
			$scope.estadoOperador = {
				'PEND_CREAR' : {{\Wupos\EstadoOperador::PEND_CREAR}},
				'CREADO' : {{\Wupos\EstadoOperador::CREADO}},
				'PEND_ELIMINAR' : {{\Wupos\EstadoOperador::PEND_ELIMINAR}},
			};
			$scope.classEstado = function(estado){
				switch(estado){
					case $scope.estadoOperador['PEND_CREAR']:
						return 'warning';
					case $scope.estadoOperador['CREADO']:
						return 'success';
					case $scope.estadoOperador['PEND_ELIMINAR']:
						return 'danger';
				}
			}

			//$timeout( function(){
				$scope.operadores = {!! $operadores !!};
				$scope.regionales = {!! json_encode($arrRegionales ,JSON_NUMERIC_CHECK) !!};
				$scope.papelera = '{{ $papelera }}';
				$scope.load = true;
			//}, 500);  // artificial wait of 1/2 second

		}]);
	</script>
@parent
@endsection

@section('content')
<div ng-app="appWupos" ng-controller="OperadoresCtrl">

	<h1 class="row page-header">
		<div class="col-xs-12 col-sm-3">
			Operadores {{$papelera ? 'Eliminados' : ''}}
		</div>

		<div class="col-xs-12 col-sm-9 text-right">
			<div role="form" class="form form-inline">
				<div class="input-group has-feedback">
					<input type="text"
						ng-hide="isFiltered"
						class="form-control"
						placeholder="Filtrar..."
						ng-model="searchOperador"
					>
				</div>
				@include('operadores/index-Btns')
			</div>
		</div>
	</h1>

	@include('operadores/index-collapseFormFilters')

	<table id="tbIndex" class="table table-condensed">
		<thead>
			<tr>
				<td colspan="10" class="text-right" ng-show="load">
					@include('partials/paginate')
				</td>
			</tr>
			<tr class="active">
				@include('partials.widgets.th', ['id'=>'OPER_codigo', 'title'=>'Código', 'class'=>'col-xs-1 col-sm-1 col-md-1 col-lg-1', 'width'=>'20px'])
				@include('partials.widgets.th', ['id'=>'OPER_cedula', 'title'=>'Cédula', 'class'=>'hidden-xs col-sm-1 col-md-1 col-lg-1'])
				@include('partials.widgets.th', ['id'=>'OPER_nombre', 'title'=>'Nombres', 'class'=>'col-xs-2 col-sm-2 col-md-2 col-lg-2'])
				@include('partials.widgets.th', ['id'=>'OPER_apellido', 'title'=>'Apellidos', 'class'=>'col-xs-2 col-sm-2 col-md-2 col-lg-2'])
				@include('partials.widgets.th', ['id'=>'ESOP_descripcion', 'title'=>'Estado', 'class'=>'col-xs-1 col-sm-1 col-md-1 col-lg-1'])
				@include('partials.widgets.th', ['id'=>'REGI_nombre', 'title'=>'Regional', 'class'=>'hidden-xs col-sm-2 col-md-2 col-lg-2'])
				@include('partials.widgets.th', ['id'=>'OPER_creadopor', 'title'=>'Creado por', 'class'=>'hidden-xs col-sm-1 col-md-1 col-lg-1'])
				@include('partials.widgets.th', ['id'=>'OPER_modificadopor', 'title'=>'Modif por', 'class'=>'hidden-xs col-sm-1 col-md-1 col-lg-1'])
				@include('partials.widgets.th', ['id'=>'OPER_fechamodificado', 'title'=>'Fch Modif', 'class'=>'hidden-xs col-sm-1 col-md-1 col-lg-1'])
				<th class="col-xs-1 col-sm-1 col-md-1 col-lg-1">Acciones</th>
			</tr>
		</thead>
	
		<tbody ng-show="load">
			<tr dir-paginate="operador in operadores | orderBy:sortType:sortReverse | filter:searchOperador | itemsPerPage: pageSize" current-page="currentPage" ng-class="classEstado(operador.ESOP_id)">
				<td ng-bind="padLeft(operador.OPER_codigo, 3)"></td>
				<td class="hidden-xs" ng-bind="operador.OPER_cedula"></td>
				<td ng-bind="operador.OPER_nombre"></td>
				<td ng-bind="operador.OPER_apellido"></td>
				<td ng-bind="operador.ESOP_descripcion"></td>
				<td class="hidden-xs" ng-bind="operador.REGI_nombre"></td>
				<td class="hidden-xs" ng-bind="operador.OPER_creadopor"></td>
				<td class="hidden-xs" ng-bind="operador.OPER_modificadopor"></td>
				<td class="hidden-xs" ng-bind="formatDate(operador.OPER_fechamodificado)"></td>

				<td>

					@if(!$papelera)
					<!-- Cargar botón Editar -->
					<a class="btn btn-xs btn-info" href="{% 'operadores/' + operador.OPER_id + '/edit' %}">
						<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
					</a>
					@else
					<!-- Cargar botón Restaurar -->
					<a class="btn btn-xs btn-warning" href="{% 'operadores/' + operador.OPER_id + '/restore' %}">
						<i class="fa fa-undo" aria-hidden="true"></i> <span class="hidden-xs">Restaurar</span>
					</a>
					@endif

					<!-- carga botón de Borrar	-->

					<div ng-if="operador.ESOP_id == estadoOperador['CREADO']">
						{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i>',[
							'class'=>'btn btn-xs btn-warning',
							'data-toggle'=>'modal',
							'data-id'=>'{% padLeft(operador.OPER_codigo, 3) %}',
							'data-descripcion'=>'{% operador.OPER_nombre+" "+operador.OPER_apellido %}',
							'data-action'=>'{% "operadores/" + operador.OPER_id + "/pendBorrar" %}',
							'data-target'=>'#pregModalDelete',
						])}}
					</div>
					<div ng-if="operador.ESOP_id == estadoOperador['PEND_ELIMINAR']">
						{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i>',[
							'class'=>'btn btn-xs btn-danger btn-delete',
							'data-toggle'=> 'modal',
							'data-id'=>'{% padLeft(operador.OPER_codigo, 3) %}',
							'data-descripcion'=>'{% operador.OPER_nombre+" "+operador.OPER_apellido %}',
							'data-action'=>'{% "operadores/" + operador.OPER_id %}',
							'data-target'=> '#pregModalDelete',
						])}}
					</div>

				</td>
			</tr>
		</tbody>

		<tfoot ng-show="!load">
			<td colspan="10">
				<div class="text-center">
					<i class="fa fa-cog fa-spin fa-2x fa-fw" style="vertical-align: middle;"></i> Cargando registros...
				</div>
			</td>
		</tfoot>
	</table>
</div><!-- End ng-controller -->

	@include('operadores/index-modalExport')
	@include('partials/modalDelete') <!-- incluye el modal del Delete -->
@endsection

	