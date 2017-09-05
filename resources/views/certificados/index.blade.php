@extends('layout')
@section('title', '/ Certificados')

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

		appWupos.controller('CertificadosCtrl', ['$scope', '$timeout', function($scope, $timeout){
			//Mostrar mensaje de carga
			$scope.show = true;

			//paginación
			if(!localStorage.currentPageCert || !localStorage.pageSizeCert){
				localStorage.currentPageCert = 1
				localStorage.pageSizeCert = 25;
			}
			$scope.currentPage = localStorage.currentPageCert;
			$scope.$watch('currentPage', function(currentPage) {
				localStorage.currentPageCert = currentPage;
			});
			$scope.pageSize = localStorage.pageSizeCert;
			$scope.$watch('pageSize', function(pageSize) {
				localStorage.pageSizeCert = pageSize;
			});

			//Ordenamiento
			if(!localStorage.sortTypeCert || !localStorage.sortReverseCert){
				localStorage.sortTypeCert = 'CERT_fechamodificado'
				localStorage.sortReverseCert = true;
			}
			$scope.sortType = localStorage.sortTypeCert;
			$scope.$watch('sortType', function(sortType) {
				localStorage.sortTypeCert = sortType;
			});
			$scope.sortReverse = JSON.parse(localStorage.sortReverseCert);
			$scope.$watch('sortReverse', function(sortReverse) {
				localStorage.sortReverseCert = sortReverse;
			});

			//Filtros
			if(!localStorage.searchCertificado)
				localStorage.searchCertificado = null;

			$scope.isFiltered = false;
			if(localStorage.searchCertificado != 'null' && localStorage.searchCertificado != 'undefined'){
				if (localStorage.searchCertificado[0] === '{'){
					$scope.isFiltered = true;
					$scope.searchCertificado = JSON.parse(localStorage.searchCertificado);
				} else {
					$scope.searchCertificado = localStorage.searchCertificado;
				}
			}
			$scope.toggleFormFilter = function() {
				$scope.isFiltered = !$scope.isFiltered;
				//if(!$scope.isFiltered && typeof $scope.searchCertificado == 'object')
					$scope.searchCertificado = null;
			}

			$scope.$watchCollection('searchCertificado', function(filter) {
				if(typeof filter == 'object')
					localStorage.searchCertificado = JSON.stringify(filter);
				else
					localStorage.searchCertificado = filter;
			});

			//Formato de fecha
			$scope.formatDate = function(strDate){
				var strDateFormatted = moment(strDate).format('DD/MM/YYYY hh:mm A');
				return strDateFormatted;
			}

			//$timeout( function(){
				$scope.certificados = {!! $certificados !!};
				$scope.regionales = {!! json_encode($arrRegionales ,JSON_NUMERIC_CHECK) !!};
				$scope.show = false;
			//}, 500);  // artificial wait of 1/2 second

		}]);
	</script>
@parent
@endsection

@section('content')

<div ng-app="appWupos" ng-controller="CertificadosCtrl">
	<h1 class="row page-header">
		<div class="col-xs-12 col-sm-3">
			Certificados {{$papelera ? 'Eliminados' : ''}}
		</div>

		<div class="col-xs-12 col-sm-9 text-right">
			<div role="form" class="form form-inline">
				<div class="input-group has-feedback">
					<input type="text"
						ng-hide="isFiltered"
						class="form-control"
						placeholder="Filtrar..."
						ng-model="searchCertificado"
					>
					<!--span ng-if="searchCertificado"
						name="btnClear"
						ng-click="searchCertificado = null"
						class="glyphicon glyphicon-remove-circle form-control-feedback"
						uib-tooltip="Borrar"
					></span-->
				</div>
				@include('certificados/index-Btns')
			</div>
		</div>
	</h1>

	@include('certificados/index-modalExport')
	@include('certificados/index-collapseFormFilters')

	<table id="tbIndex" class="table table-striped table-condensed responsive-utilities">
		<thead>
			<tr>
				<td colspan="10" class="text-right" ng-show="!show">
					@include('partials/paginate')
				</td>
			</tr>
			<tr class="active">
				@include('partials.widgets.th', ['id'=>'CERT_codigo', 'title'=>'Cod Cert', 'class'=>'col-xs-1 col-sm-1 col-md-1 col-lg-1', 'width'=>'40px'])
				@include('partials.widgets.th', ['id'=>'CERT_equipo', 'title'=>'Equipo', 'class'=>'col-xs-1 col-sm-1 col-md-1 col-lg-1'])
				@include('partials.widgets.th', ['id'=>'AGEN_codigo', 'title'=>'Cod Agen', 'class'=>'col-xs-1 col-sm-1 col-md-1 col-lg-1', 'width'=>'40px'])
				@include('partials.widgets.th', ['id'=>'AGEN_nombre', 'title'=>'Agencia', 'class'=>'hidden-xs col-sm-2 col-md-2 col-lg-2'])
				@include('partials.widgets.th', ['id'=>'AGEN_cuentawu', 'title'=>'Cuenta WU', 'class'=>'col-xs-1 col-sm-1 col-md-1 col-lg-1'])
				@include('partials.widgets.th', ['id'=>'REGI_nombre', 'title'=>'Regional', 'class'=>'hidden-xs col-sm-2 col-md-2 col-lg-2'])
				@include('partials.widgets.th', ['id'=>'CERT_creadopor', 'title'=>'Creado por', 'class'=>'hidden-xs col-sm-1 col-md-1 col-lg-1'])
				@include('partials.widgets.th', ['id'=>'CERT_modificadopor', 'title'=>'Modif por', 'class'=>'hidden-xs col-sm-1 col-md-1 col-lg-1'])
				@include('partials.widgets.th', ['id'=>'CERT_fechamodificado', 'title'=>'Fch Modif', 'class'=>'hidden-xs col-sm-1 col-md-1 col-lg-1'])
				<th class="col-xs-1 col-sm-1 col-md-3 col-lg-3">Acciones</th>
			</tr>
		</thead>
		
		<tbody ng-show="!show">
		  <tr dir-paginate="certificado in certificados | orderBy:sortType:sortReverse | filter:searchCertificado | itemsPerPage: pageSize" current-page="currentPage" class="{% certificado.AGEN_activa ? '' : 'danger' %}">
				{{-- <td>{% certificado.CERT_id %}</td> --}}
				<td ng-bind="certificado.CERT_codigo"></td>
				<td ng-bind="certificado.CERT_equipo"></td>
				<td ng-bind="certificado.AGEN_codigo"></td>
				<td class="hidden-xs" ng-bind="certificado.AGEN_nombre"></td>
				<td ng-bind="certificado.AGEN_cuentawu"></td>
				<td class="hidden-xs" ng-bind="certificado.REGI_nombre"></td>
				<td class="hidden-xs" ng-bind="certificado.CERT_creadopor"></td>
				<td class="hidden-xs" ng-bind="certificado.CERT_modificadopor"></td>
				<td class="hidden-xs" ng-bind="formatDate(certificado.CERT_fechamodificado)"></td>
				<td>

					@if(!$papelera)
					<!-- Cargar botón Editar -->
					<a class="btn btn-xs btn-info" href="{% 'certificados/' + certificado.CERT_id + '/edit' %}">
						<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
					</a>
					@else
					<!-- Cargar botón Restaurar -->
					<a class="btn btn-xs btn-warning" href="{% 'certificados/' + certificado.CERT_id + '/restore' %}">
						<i class="fa fa-undo" aria-hidden="true"></i>
					</a>
					@endif

					<!-- carga botón de Borrar -->
					{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i>',[
							'class'=>'btn btn-xs btn-danger',
							'data-toggle'=>'modal',
							'data-id'=>'{% certificado.CERT_id %}',
							'data-descripcion'=>'{% certificado.CERT_codigo %}',
							'data-action'=>'{% "certificados/" + certificado.CERT_id %}',
							'data-target'=>'#pregModalDelete',
						])
					}}

				</td>
			</tr>
		</tbody>
		
		<tfoot>
			<td colspan="10">
				<div class="text-center" ng-show="show">
					<i class="fa fa-cog fa-spin fa-2x fa-fw" style="vertical-align: middle;"></i> Cargando registros...
				</div>
				<div class="text-right" ng-show="!show">
					@include('partials/paginate')
				</div>
			</td>
		</tfoot>
	</table>
</div><!-- End ng-controller -->

@include('partials/modalDelete') <!-- incluye el modal del Delete -->	
@endsection

	