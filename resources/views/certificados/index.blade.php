@extends('layout')
@section('title', '/ Certificados')

@section('head')
@endsection

@section('scripts')
    {!! Html::script('assets/js/angular/angular.min.js') !!}
	{!! Html::script('assets/js/angular/dirPagination.js') !!}
	<script type="text/javascript">
		var appWupos = angular.module('appWupos', ['angularUtils.directives.dirPagination'], function($interpolateProvider) {
			$interpolateProvider.startSymbol('{%');
			$interpolateProvider.endSymbol('%}');
		});
		
		appWupos.controller('CertificadosCtrl', ['$scope', '$timeout', function($scope, $timeout){
			//Mostrar mensaje de carga
        	$scope.show = true;
			//paginación
			$scope.currentPage = 1;
			$scope.pageSize = 5;
        	$timeout( function(){
				$scope.certificados = {!! $certificados !!};
				$scope.regionales = {!! json_encode($arrRegionales ,JSON_NUMERIC_CHECK) !!};
	        	$scope.show = false;
        	}, 500);  // artificial wait of 1/2 second

		}]);
	</script>
@endsection

@section('content')

<div class="container_tb_certificados" ng-app="appWupos" ng-controller="CertificadosCtrl">
	<h1 class="page-header">Certificados</h1>

	<div class="row well well-sm">

		<!-- Filtrar datos en vista -->
		<div id="frm-find" class="col-xs-3 col-md-9 col-lg-9">
			<a class='btn btn-primary' role='button' data-toggle="collapse" data-target="#filters" href="#">
				<i class="fa fa-filter" aria-hidden="true"></i> 
				<span class="hidden-xs">Filtrar resultados</span>
				<span class="sr-only">Filtrar</span>
			</a>
		</div>

		<!-- Botones -->
		<div id="btns-top" class="col-xs-9 col-md-3 col-lg-3 text-right">

			<!-- botón de crear nuevo reg -->
			@if(in_array(auth()->user()->rol->ROLE_rol , ['admin']))
			<a class='btn btn-primary' role='button' href="{{ URL::to('certificados/create') }}">
				<i class="fa fa-plus" aria-hidden="true"></i> Nuevo Certificado
				<span class="sr-only">Nuevo</span>
			</a>
			@endif

			<!-- botón de exportar -->
			{{ Form::open( [ 'url'=>'certificados/export/xls', 'method'=>'GET', 'class' => 'pull-right' ]) }}
				{{ Form::button('<i class="fa fa-download" aria-hidden="true"></i> Exportar',[
						'class'=>'btn btn-success',
						'type'=>'submit',
						//'data-toggle'=>'modal',
						//'data-target'=>'#pregModalExport',
				]) }}
			{{ Form::close() }}
		</div>
	</div>


<!-- Mensaje Modal. Bloquea la pantalla mientras se procesa la solicitud -->
<div class="modal fade" id="pregModalExport" role="dialog" tabindex="-1" >
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Exportar</h4>
			</div>
			<div class="modal-body text-center">
					<!-- carga botón de exportar a Excel -->
					{{-- redirect()->to('certificados/excel') --}}
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>

	<div id="filters" class="collapse col-md-8">
			<div class="form-group col-xs-12 col-md-12">

			 		<div class="input-group">
						<div class="input-group-addon">Certificado</div>
						<input type="text" class="form-control" placeholder="Por certificado..." ng-model="searchCertificado.CERT_codigo">
					</div>

			 		<div class="input-group">
						<div class="input-group-addon">Agencia</div>
						<input type="text" class="form-control" placeholder="Por código agencia..." ng-model="searchCertificado.AGEN_codigo">
						<input type="text" class="form-control" placeholder="Por nombre agencia..." ng-model="searchCertificado.AGEN_nombre">
					</div>

			 		<div class="input-group">
						<div class="input-group-addon">Regional</div>
						<select type="text" class="form-control" ng-model="searchCertificado.REGI_nombre" >
							<option value="">Todas</option>
							<option ng-repeat="reg in regionales" value="{% reg.REGI_nombre %}">
								{% reg.REGI_nombre %}
							</option>
						</select>
					</div>

			</div>
	</div>

<table id="tbIndex" class="table table-striped table-condensed responsive-utilities">
	<thead>
		<tr>
			<td colspan="9" class="text-right" ng-show="!show">
				@include('partials/paginate')
			</td>
		</tr>
		<tr class="active">
			<th class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
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

			<th class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
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

			<th class="col-xs-1 col-sm-1 col-md-3 col-lg-3">
				Acciones
			</th>
		</tr>
	</thead>
	
	<tbody <div ng-show="!show">
	  <tr dir-paginate="certificado in certificados | orderBy:sortType:sortReverse | filter:searchCertificado | itemsPerPage: pageSize" current-page="currentPage">
			{{-- <td>{% certificado.CERT_id %}</td> --}}
			<td>{% certificado.CERT_codigo %}</td>
			<td>{% certificado.CERT_equipo %}</td>
			<td>{% certificado.AGEN_codigo %}</td>
			<td class="hidden-xs">{% certificado.AGEN_nombre %}</td>
			<td>{% certificado.AGEN_cuentawu %}</td>
			<td class="hidden-xs">{% certificado.REGI_nombre %}</td>
			<td class="hidden-xs">{% certificado.CERT_creadopor %}</td>
			<td class="hidden-xs">{% certificado.CERT_modificadopor %}</td>
			<td>
				<!-- carga botón de Ver -->
				<a class="btn btn-xs btn-success" href="{% 'certificados/' + certificado.CERT_id %}" role="button">
					<span class="glyphicon glyphicon-eye-open"></span> <span class="hidden-xs">Ver</span>
				</a>


				<!-- Cargar botón editar -->
				<a class="btn btn-xs btn-info" href="{% 'certificados/' + certificado.CERT_id + '/edit' %}">
					<i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span class="hidden-xs">Editar</span>
				</a>


				<!-- carga botón de borrar -->
				{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i> <span class="hidden-xs">Borrar</span>',[
						'class'=>'btn btn-xs btn-danger',
						'data-toggle'=>'modal',
						'data-target'=>'#pregModal{% certificado.CERT_id %}',
					]) }}

					<!-- Mensaje Modal. Bloquea la pantalla mientras se procesa la solicitud -->
					<div class="modal fade" id="pregModal{% certificado.CERT_id %}" role="dialog" tabindex="-1" >
						<div class="modal-dialog">
							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title">¿Borrar?</h4>
								</div>
								<div class="modal-body">
									<p>
										<i class="fa fa-exclamation-triangle"></i> ¿Desea borrar la certificado {% certificado.CERT_codigo %} de {% certificado.AGEN_nombre %}?
									</p>
								</div>
								<div class="modal-footer">
									<form method="POST" action="{% 'certificados/' + certificado.CERT_id %}" accept-charset="UTF-8" class="pull-right ng-pristine ng-valid">

										<button type="button" class="btn btn-xs btn-success" data-dismiss="modal">NO</button>

										{{ Form::token() }}
										{{ Form::hidden('_method', 'DELETE') }}
										{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i> SI',[
											'class'=>'btn btn-xs btn-danger',
											'type'=>'submit',
											'data-toggle'=>'modal',
											'data-backdrop'=>'static',
											'data-target'=>'#msgModal',
										]) }}
									</form>
								</div>
					  		</div>
						</div>
					</div>
			</td>
		</tr>
	</tbody>
	
	<tfoot>
		<td colspan="9" class="text-center" ng-show="show"
			<i class="fa fa-cog fa-spin fa-2x fa-fw"></i> Cargando registros...
		</td>
		<td colspan="9" class="text-right" ng-show="!show">
			@include('partials/paginate')
		</td>
	</tfoot>
</table>


  <!-- Mensaje Modal. Bloquea la pantalla mientras se procesa la solicitud -->
  <div class="modal fade" id="msgModal" role="dialog">
	<div class="modal-dialog">
	
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title">Borrando...</h4>
		</div>
		<div class="modal-body">
			<p>
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i> Borrando certificado...
			</p>
		</div>
		<div class="modal-footer">
		</div>
	  </div>
	  
	</div>
  </div>
  

</div>
@endsection

	