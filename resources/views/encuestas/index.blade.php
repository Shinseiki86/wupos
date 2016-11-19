@extends('layout')
@section('title', '/ Encuestas')


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
		appWupos.controller('EncuestasCtrl', ['$scope', function($scope){
			$scope.encuestas = {!! $encuestas !!};
			$scope.ENCU_estados = {!! json_encode($estadosEncuestas ,JSON_NUMERIC_CHECK) !!};
		}]);
	</script>
@endsection

@section('content')

<div class="container_tb_encuestas" ng-app="appWupos" ng-controller="EncuestasCtrl">
	<h1 class="page-header">Encuestas</h1>
	<div class="row well well-sm">
		<div id="frm-find" class="col-xs-6 col-md-8">
			<a class='btn btn-primary' role='button' data-toggle="collapse" data-target="#filters" href="#">
				<i class="fa fa-filter" aria-hidden="true"></i> Filtrar resultados
			</a>
			<div id="filters" class="collapse">
			  <form>
				<div class="form-group">
				  <div class="input-group">
					<div class="input-group-addon"><i class="fa fa-search"></i></div>
					<input type="text" class="form-control" placeholder="Por título..." ng-model="searchEncuesta.ENCU_titulo">
					<select type="text" class="form-control" ng-model="searchEncuesta.ENCU_estado" >
						<option value="*">Todas</option>
						<option ng-repeat="estado in ENCU_estados">{% estado.ESEN_descripcion %}</option>
					</select>
				  </div>      
				</div>
			  </form>
			</div>
		</div>

		<div id="btn-create" class="col-xs-4 col-md-4 text-right">
			@if(in_array(auth()->user()->rol->ROLE_descripcion , ['admin', 'editor']))
			<a class='btn btn-primary' role='button' href="{{ URL::to('encuestas/create') }}">
				<i class="fa fa-plus" aria-hidden="true"></i> Nueva Encuesta
			</a>
			@endif
		</div>
	</div>
  
  <table class="table table-bordered table-striped">
	<thead>
		<th>
			<a href="#" ng-click="sortType = 'ENCU_id'; sortReverse = !sortReverse">
				ID
				<span ng-show="sortType == 'ENCU_id' && !sortReverse" class="fa fa-caret-down"></span>
				<span ng-show="sortType == 'ENCU_id' && sortReverse" class="fa fa-caret-up"></span>
			</a>
		</th>
		<th>
			<a href="#" ng-click="sortType = 'ENCU_titulo'; sortReverse = !sortReverse">
				Título
				<span ng-show="sortType == 'ENCU_titulo' && !sortReverse" class="fa fa-caret-down"></span>
				<span ng-show="sortType == 'ENCU_titulo' && sortReverse" class="fa fa-caret-up"></span>
			</a>
		</th>
		<th>
			<a href="#" ng-click="sortType = 'ENCU_estado'; sortReverse = !sortReverse">
				Estado
				<span ng-show="sortType == 'ENCU_estado' && !sortReverse" class="fa fa-caret-down"></span>
				<span ng-show="sortType == 'ENCU_estado' && sortReverse" class="fa fa-caret-up"></span>
			</a>
		</th>
		<th>
			<a href="#" ng-click="sortType = 'ENCU_creadopor'; sortReverse = !sortReverse">
				Autor
				<span ng-show="sortType == 'ENCU_creadopor' && !sortReverse" class="fa fa-caret-down"></span>
				<span ng-show="sortType == 'ENCU_creadopor' && sortReverse" class="fa fa-caret-up"></span>
			</a>
		</th>
		<th class="hidden-xs">
			<a href="#" ng-click="sortType = 'ENCU_fechavigencia'; sortReverse = !sortReverse">
				Vigencia
				<span ng-show="sortType == 'ENCU_fechavigencia' && !sortReverse" class="fa fa-caret-down"></span>
				<span ng-show="sortType == 'ENCU_fechavigencia' && sortReverse" class="fa fa-caret-up"></span>
			</a>
		</th>
		<th class="hidden-xs">
			<a href="#" ng-click="sortType = 'ENCU_fechacreado'; sortReverse = !sortReverse">
				Creado
				<span ng-show="sortType == 'ENCU_fechacreado' && !sortReverse" class="fa fa-caret-down"></span>
				<span ng-show="sortType == 'ENCU_fechacreado' && sortReverse" class="fa fa-caret-up"></span>
			</a>
		</th>
		<th class="hidden-xs">
			<a href="#" ng-click="sortType = 'ENCU_fechamodificado'; sortReverse = !sortReverse">
				Modificado
				<span ng-show="sortType == 'ENCU_fechamodificado' && !sortReverse" class="fa fa-caret-down"></span>
				<span ng-show="sortType == 'ENCU_fechamodificado' && sortReverse" class="fa fa-caret-up"></span>
			</a>
		</th>
		<th style="width:280px;">
			Acciones
		</th>
	</thead>
	
	<tbody>
	  <tr ng-repeat="encuesta in encuestas | orderBy:sortType:sortReverse | filter:searchEncuesta">
			<td>{% encuesta.ENCU_id %}</td>
			<td>{% encuesta.ENCU_titulo %}</td>
			<td>{% encuesta.ESEN_descripcion %}</td>
			<td>{% encuesta.ENCU_creadopor %}</td>
			<td class="hidden-xs">{% encuesta.ENCU_fechavigencia %}</td>
			<td class="hidden-xs">{% encuesta.ENCU_fechacreado %}</td>
			<td class="hidden-xs">{% encuesta.ENCU_fechamodificado %}</td>
			<td>
				@if ( in_array(auth()->user()->rol->ROLE_descripcion , ['admin', 'editor']) )
					<!-- carga botón de Ver -->
					<a class="btn btn-xs btn-success" href="{% 'encuestas/' + encuesta.ENCU_id %}" role="button">
						<span class="glyphicon glyphicon-eye-open"></span> Ver
					</a>

					<!-- carga botón de duplicar  fa-clone -->
					<a class="btn btn-xs btn-warning" href="{% 'encuestas/' + encuesta.ENCU_id + '/duplicar' %}">
						<i class="fa fa-files-o" aria-hidden="true"></i> Clonar
					</a>

					<!-- carga botón de reporte -->
					<a class="btn btn-xs btn-info" href="{% 'encuestas/' + encuesta.ENCU_id + '/reportes' %}">
						<i class="fa fa-line-chart" aria-hidden="true"></i> Reportes
					</a>

					<!-- carga botón de borrar -->
					{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i> Borrar',[
							'class'=>'btn btn-xs btn-danger',
							'data-toggle'=>'modal',
							'data-target'=>'#pregModal{% encuesta.ENCU_id %}',
						]) }}

						<!-- Mensaje Modal. Bloquea la pantalla mientras se procesa la solicitud -->
						<div class="modal fade" id="pregModal{% encuesta.ENCU_id %}" role="dialog" tabindex="-1" >
							<div class="modal-dialog">
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">¿Borrar?</h4>
									</div>
									<div class="modal-body">
										<p>
											<i class="fa fa-exclamation-triangle"></i> ¿Desea borrar la encuesta {% encuesta.ENCU_id %}?
										</p>
									</div>
									<div class="modal-footer">
										<form method="POST" action="{% 'encuestas/' + encuesta.ENCU_id %}" accept-charset="UTF-8" class="pull-right ng-pristine ng-valid">

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
					<a class="btn btn-xs btn-info" href="{% 'encuestas/' + encuesta.ENCU_id + '/resps' %}">
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
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i> Borrando encuesta...
			</p>
		</div>
		<div class="modal-footer">
		</div>
	  </div>
	  
	</div>
  </div>
  

</div>
@endsection

