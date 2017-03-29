@extends('layout')
@section('title', '/ Certificados')


@section('scripts')
    {!! Html::script('assets/js/angular/angular.min.js') !!}
	{!! Html::script('assets/js/angular/ui-bootstrap-tpls-2.3.1.min.js') !!}
	{!! Html::script('assets/js/angular/dirPagination.js') !!}
	{!! Html::script('assets/js/momentjs/moment-with-locales.min.js') !!}
	<script type="text/javascript">
		var appWupos = angular.module('appWupos', ['angularUtils.directives.dirPagination','ui.bootstrap'], function($interpolateProvider) {
			$interpolateProvider.startSymbol('{%');
			$interpolateProvider.endSymbol('%}');
		});

		//appWupos.config(['$compileProvider', function ($compileProvider) {
		//	$compileProvider.debugInfoEnabled(false);
		//}]);

		appWupos.controller('CertificadosCtrl', ['$scope', '$timeout', function($scope, $timeout){
			//Mostrar mensaje de carga
        	$scope.show = true;

			//paginación
			$scope.currentPage = 1;
			$scope.pageSize = 25;

			//Ordenamiento
			$scope.sortType = 'CERT_fechamodificado';
			$scope.sortReverse = true;

			//Formato de fecha
			$scope.formatDate = function(strDate){
				var strDateFormatted = moment(strDate).format('DD/MM/YYYY hh:mm A');
				return strDateFormatted;
			}

        	$timeout( function(){
				$scope.certificados = {!! $certificados !!};
				$scope.regionales = {!! json_encode($arrRegionales ,JSON_NUMERIC_CHECK) !!};
	        	$scope.show = false;
        	}, 500);  // artificial wait of 1/2 second

		}]);
	</script>
@parent
@endsection

@section('content')

<div class="container_tb_certificados" ng-app="appWupos" ng-controller="CertificadosCtrl">
	<h1 class="page-header">Certificados {{$papelera ? 'Eliminados' : ''}}</h1>

	<div class="row well well-sm">

		<!-- Filtrar datos en vista -->
		<div id="frm-find" class="col-xs-12 col-sm-2 col-md-2">
			<a class='btn btn-primary' role='button' data-toggle="collapse" data-target="#filters" href="#" ng-click="searchCertificado = null">
				<i class="fa fa-filter" aria-hidden="true"></i> 
				Filtrar <span class="hidden-xs hidden-sm">resultados</span>
			</a>
		</div>
		<div class="col-xs-12 col-sm-8 col-md-6">
			<form>
				<div class="input-group has-feedback">
					<div class="input-group-addon control-label">Filtrar</div>
					<input type="text"
						class="form-control"
						placeholder="En todos los campos..."
						ng-model="searchCertificado"
					>
					<span ng-if="searchCertificado"
						ng-click="searchCertificado = null"
						class="glyphicon glyphicon-remove-circle form-control-feedback"
						style="cursor: pointer; pointer-events: all;"
						uib-tooltip="Borrar"
					></span>
				</div>
			</form>
		</div>

		<!-- Botones -->
		<div id="btns-top" class="col-xs-12 col-sm-2 col-md-4 text-right">
			<!-- botón de crear nuevo reg -->
			@if(in_array(auth()->user()->rol->ROLE_rol , ['admin']) && !$papelera)
			<a class='btn btn-primary' role='button' href="{{ URL::to('certificados/create') }}">
				<i class="fa fa-plus" aria-hidden="true"></i>
				Nuevo <span class="hidden-xs hidden-sm">Certificado</span>
			</a>
			<a class='btn btn-warning' role='button' href="{{ URL::to('certificados-borrados') }}">
				<i class="fa fa-trash-o" aria-hidden="true"></i> 
				Papelera
			</a>
			@elseif($papelera)
				<!-- botón de vaciar papelera -->
				{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i> Vaciar <span class="hidden-xs">Papelera</span>',[
						'class'=>'btn btn-danger',
						'data-toggle'=>'modal',
						'data-id'=>'{% papelera %}',
						'data-descripcion'=>'registros en la papelera',
						'data-action'=>'certificados-borrados/vaciarPapelera',
						'data-target'=>'#pregModalDelete',
					])
				}}
			@endif

			<!-- botón de exportar -->
			{{ Form::open( [ 'url'=>'certificados/export/xlsx', 'method'=>'GET', 'class' => 'pull-right' ]) }}
				{{ Form::hidden('_papelera', ''.$papelera) }}
				{{ Form::button('<i class="fa fa-download" aria-hidden="true"></i> Exportar',[
						'class'=>'btn btn-success',
						'type'=>'submit',
				]) }}
			{{ Form::close() }}
		</div>
	</div>

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
				<th class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="width:40px;">
					<a href="#" ng-click="sortType = 'CERT_codigo'; sortReverse = !sortReverse">
						Cod Cert
						<span ng-show="sortType == 'CERT_codigo' && !sortReverse" class="fa fa-caret-down"></span>
						<span ng-show="sortType == 'CERT_codigo' && sortReverse" class="fa fa-caret-up"></span>
					</a>
				</th>

				<th class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
					<a href="#" ng-click="sortType = 'CERT_equipo'; sortReverse = !sortReverse">
						Equipo
						<span ng-show="sortType == 'CERT_equipo' && !sortReverse" class="fa fa-caret-down"></span>
						<span ng-show="sortType == 'CERT_equipo' && sortReverse" class="fa fa-caret-up"></span>
					</a>
				</th>

				<th class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="width:40px;">
					<a href="#" ng-click="sortType = 'AGEN_codigo'; sortReverse = !sortReverse">
						Cod Agen
						<span ng-show="sortType == 'AGEN_codigo' && !sortReverse" class="fa fa-caret-down"></span>
						<span ng-show="sortType == 'AGEN_codigo' && sortReverse" class="fa fa-caret-up"></span>
					</a>
				</th>

				<th class="hidden-xs col-sm-2 col-md-2 col-lg-2">
					<a href="#" ng-click="sortType = 'AGEN_nombre'; sortReverse = !sortReverse">
						Agencia
						<span ng-show="sortType == 'AGEN_nombre' && !sortReverse" class="fa fa-caret-down"></span>
						<span ng-show="sortType == 'AGEN_nombre' && sortReverse" class="fa fa-caret-up"></span>
					</a>
				</th>

				<th class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
					<a href="#" ng-click="sortType = 'AGEN_cuentawu'; sortReverse = !sortReverse">
						Cuenta WU
						<span ng-show="sortType == 'AGEN_cuentawu' && !sortReverse" class="fa fa-caret-down"></span>
						<span ng-show="sortType == 'AGEN_cuentawu' && sortReverse" class="fa fa-caret-up"></span>
					</a>
				</th>

				<th class="hidden-xs col-sm-2 col-md-2 col-lg-2">
					<a href="#" ng-click="sortType = 'REGI_nombre'; sortReverse = !sortReverse">
						Regional
						<span ng-show="sortType == 'REGI_nombre' && !sortReverse" class="fa fa-caret-down"></span>
						<span ng-show="sortType == 'REGI_nombre' && sortReverse" class="fa fa-caret-up"></span>
					</a>
				</th>

				<th class="hidden-xs col-sm-1 col-md-1 col-lg-1">
					<a href="#" ng-click="sortType = 'CERT_creadopor'; sortReverse = !sortReverse">
						Creado por
						<span ng-show="sortType == 'CERT_creadopor' && !sortReverse" class="fa fa-caret-down"></span>
						<span ng-show="sortType == 'CERT_creadopor' && sortReverse" class="fa fa-caret-up"></span>
					</a>
				</th>

				<th class="hidden-xs col-sm-1 col-md-1 col-lg-1">
					<a href="#" ng-click="sortType = 'CERT_modificadopor'; sortReverse = !sortReverse">
						Modif por
						<span ng-show="sortType == 'CERT_modificadopor' && !sortReverse" class="fa fa-caret-down"></span>
						<span ng-show="sortType == 'CERT_modificadopor' && sortReverse" class="fa fa-caret-up"></span>
					</a>
				</th>

				<th class="hidden-xs col-sm-1 col-md-1 col-lg-1">
					<a href="#" ng-click="sortType = 'CERT_fechamodificado'; sortReverse = !sortReverse">
						Fch Modif
						<span ng-show="sortType == 'CERT_fechamodificado' && !sortReverse" class="fa fa-caret-down"></span>
						<span ng-show="sortType == 'CERT_fechamodificado' && sortReverse" class="fa fa-caret-up"></span>
					</a>
				</th>

				<th class="col-xs-1 col-sm-1 col-md-3 col-lg-3">
					Acciones
				</th>
			</tr>
		</thead>
		
		<tbody <div ng-show="!show">
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
					<!-- carga botón de Ver 
					<a class="btn btn-xs btn-success" href="{% 'certificados/' + certificado.CERT_id %}" role="button">
						<span class="glyphicon glyphicon-eye-open"></span> <span class="hidden-xs">Ver</span>
					</a>-->

					@if(!$papelera)
					<!-- Cargar botón Editar -->
					<a class="btn btn-xs btn-info" href="{% 'certificados/' + certificado.CERT_id + '/edit' %}">
						<i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span class="hidden-xs">Editar</span>
					</a>
					@else
					<!-- Cargar botón Restaurar -->
					<a class="btn btn-xs btn-warning" href="{% 'certificados/' + certificado.CERT_id + '/restore' %}">
						<i class="fa fa-undo" aria-hidden="true"></i> <span class="hidden-xs">Restaurar</span>
					</a>
					@endif

					<!-- carga botón de Borrar -->
					{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i> <span class="hidden-xs">Borrar</span>',[
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

	