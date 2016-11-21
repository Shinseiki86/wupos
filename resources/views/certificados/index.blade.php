@extends('layout')
@section('title', '/ Certificados')


@section('head')
@endsection

@section('scripts')
    {!! Html::script('assets/js/angular/angular.min.js') !!}
    {!! Html::script('assets/js/angular/angular-animate.js') !!}
	<script>
		var appWupos = angular.module('appWupos', [], function($interpolateProvider) {
			$interpolateProvider.startSymbol('{%');
			$interpolateProvider.endSymbol('%}');
		});
		appWupos.controller('CertificadosCtrl', ['$scope', function($scope){
			$scope.certificados = {!! $certificados !!};
			$scope.agencias = {!! json_encode($arrAgencias ,JSON_NUMERIC_CHECK) !!};
		}]);
	</script>
@endsection

@section('content')

<div class="container_tb_certificados" ng-app="appWupos" ng-controller="CertificadosCtrl">
	<h1 class="page-header">Certificados</h1>
	<div class="row well well-sm">
		<div id="frm-find" class="col-xs-6 col-md-8">
			<a class='btn btn-primary' role='button' data-toggle="collapse" data-target="#filters" href="#">
				<i class="fa fa-filter" aria-hidden="true"></i> Filtrar resultados
			</a>
			<div id="filters" class="collapse">
			  <form>
				<div class="form-group">
				  <div class="input-group">
					<div class="input-group-addon"><i class="fa fa-search">Código</i></div>
					<input type="text" class="form-control" placeholder="Por código..." ng-model="searchCertificado.CERT_codigo">
				  </div>
				  <div class="input-group">
					<div class="input-group-addon"><i class="fa fa-search"></i></div>
					<select type="text" class="form-control" ng-model="searchCertificado.AGEN_nombre" >
						<option value="">Todas</option>
						<option ng-repeat="agencia in agencias" value="{% agencia.AGEN_id %}">{% agencia.AGEN_nombre %}</option>
					</select>
				  </div>
				</div>
			  </form>
			</div>
		</div>
		
		<div id="btn-create" class="col-xs-4 col-md-4 text-right">
			@if(in_array(auth()->user()->rol->ROLE_descripcion , ['admin', 'editor']))
			<a class='btn btn-primary' role='button' href="{{ URL::to('certificados/create') }}">
				<i class="fa fa-plus" aria-hidden="true"></i> Nuevo Certificado
			</a>
			@endif
		</div>
	</div>
  
  <table class="table table-bordered table-striped">
	<thead>
		<th>
			<a href="#" ng-click="sortType = 'CERT_id'; sortReverse = !sortReverse">
				ID
				<span ng-show="sortType == 'CERT_id' && !sortReverse" class="fa fa-caret-down"></span>
				<span ng-show="sortType == 'CERT_id' && sortReverse" class="fa fa-caret-up"></span>
			</a>
		</th>
		<th>
			<a href="#" ng-click="sortType = 'CERT_codigo'; sortReverse = !sortReverse">
				Título
				<span ng-show="sortType == 'CERT_codigo' && !sortReverse" class="fa fa-caret-down"></span>
				<span ng-show="sortType == 'CERT_codigo' && sortReverse" class="fa fa-caret-up"></span>
			</a>
		</th>
		<th>
			<a href="#" ng-click="sortType = 'CERT_equipo'; sortReverse = !sortReverse">
				Equipo
				<span ng-show="sortType == 'CERT_equipo' && !sortReverse" class="fa fa-caret-down"></span>
				<span ng-show="sortType == 'CERT_equipo' && sortReverse" class="fa fa-caret-up"></span>
			</a>
		</th>
		<th>
			<a href="#" ng-click="sortType = 'AGEN_nombre'; sortReverse = !sortReverse">
				Equipo
				<span ng-show="sortType == 'AGEN_nombre' && !sortReverse" class="fa fa-caret-down"></span>
				<span ng-show="sortType == 'AGEN_nombre' && sortReverse" class="fa fa-caret-up"></span>
			</a>
		</th>
		<th>
			<a href="#" ng-click="sortType = 'CERT_creadopor'; sortReverse = !sortReverse">
				Autor
				<span ng-show="sortType == 'CERT_creadopor' && !sortReverse" class="fa fa-caret-down"></span>
				<span ng-show="sortType == 'CERT_creadopor' && sortReverse" class="fa fa-caret-up"></span>
			</a>
		</th>
		<th class="hidden-xs">
			<a href="#" ng-click="sortType = 'CERT_fechacreado'; sortReverse = !sortReverse">
				Creado
				<span ng-show="sortType == 'CERT_fechacreado' && !sortReverse" class="fa fa-caret-down"></span>
				<span ng-show="sortType == 'CERT_fechacreado' && sortReverse" class="fa fa-caret-up"></span>
			</a>
		</th>
		<th class="hidden-xs">
			<a href="#" ng-click="sortType = 'CERT_fechamodificado'; sortReverse = !sortReverse">
				Modificado
				<span ng-show="sortType == 'CERT_fechamodificado' && !sortReverse" class="fa fa-caret-down"></span>
				<span ng-show="sortType == 'CERT_fechamodificado' && sortReverse" class="fa fa-caret-up"></span>
			</a>
		</th>
		<th style="width:280px;">
			Acciones
		</th>
	</thead>
	
	<tbody>
	  <tr ng-repeat="certificado in certificados | orderBy:sortType:sortReverse | filter:searchCertificado">
			<td>{% certificado.CERT_id %}</td>
			<td>{% certificado.CERT_codigo %}</td>
			<td>{% certificado.CERT_equipo %}</td>
			<td>{% certificado.AGEN_nombre %}</td>
			<td class="hidden-xs">{% certificado.CERT_creadopor %}</td>
			<td class="hidden-xs">{% certificado.CERT_fechacreado %}</td>
			<td class="hidden-xs">{% certificado.CERT_modificadopor %}</td>
			<td class="hidden-xs">{% certificado.CERT_fechamodificado %}</td>
			<td>
				@if ( in_array(auth()->user()->rol->ROLE_descripcion , ['admin', 'editor']) )
					<!-- carga botón de Ver -->
					<a class="btn btn-xs btn-success" href="{% 'certificados/' + certificado.CERT_id %}" role="button">
						<span class="glyphicon glyphicon-eye-open"></span> Ver
					</a>

					<!-- carga botón de duplicar  fa-clone -->
					<a class="btn btn-xs btn-warning" href="{% 'certificados/' + certificado.CERT_id + '/duplicar' %}">
						<i class="fa fa-files-o" aria-hidden="true"></i> Clonar
					</a>

					<!-- carga botón de reporte -->
					<a class="btn btn-xs btn-info" href="{% 'certificados/' + certificado.CERT_id + '/reportes' %}">
						<i class="fa fa-line-chart" aria-hidden="true"></i> Reportes
					</a>

					<!-- carga botón de borrar -->
					{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i> Borrar',[
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
											<i class="fa fa-exclamation-triangle"></i> ¿Desea borrar la certificado {% certificado.CERT_id %}?
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

				@elseif ( in_array(auth()->user()->rol->ROLE_descripcion , ['user','estudiante','docente']) )
					<!-- carga botón de responder -->
					<a class="btn btn-xs btn-info" href="{% 'certificados/' + certificado.CERT_id + '/resps' %}">
						<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Responder
					</a> 
				@endif
			</td>
		</tr>
	</tbody>
	
		<!--
	<tfoot>
		<td colspan="8">
			<ul class="pagination pull-right">
				<li ng-class="{% disabled: currentPage == 0 %}">
					<a href ng-click="prevPage()">« Ant</a>
				</li>
				<li ng-repeat="n in range(pagedItems.length)" ng-class="{% active: n == currentPage %}" ng-click="setPage()">
					<a href ng-bind="{% n + 1 %}">1</a>
				</li>
				<li ng-class="{% disabled: currentPage == pagedItems.length - 1 %}">
					<a href ng-click="nextPage()">Sig »</a>
				</li>
			</ul>
		</td>
	</tfoot>
		-->
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

