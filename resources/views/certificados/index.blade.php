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
		
		appWupos.controller('CertificadosCtrl', ['$scope', '$timeout', function($scope, $timeout){
        	$scope.show = true;
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
		<div id="frm-find" class="col-xs-6 col-md-8">
			<a class='btn btn-primary' role='button' data-toggle="collapse" data-target="#filters" href="#">
				<i class="fa fa-filter" aria-hidden="true"></i> Filtrar resultados
			</a>
		</div>
		
		<div id="btn-create" class="col-xs-4 col-md-4 text-right">
			@if(in_array(auth()->user()->rol->ROLE_rol , ['admin', 'editor']))
			<a class='btn btn-primary' role='button' href="{{ URL::to('certificados/create') }}">
				<i class="fa fa-plus" aria-hidden="true"></i> Nuevo Certificado
			</a>
			@endif
		</div>
	</div>

	<div id="filters" class="collapse">
		{{ Form::open([ 'class' => 'form-horizontal' ]) }}
			<div class="form-group col-xs-11 col-md-10">

					<div class="input-group-addon"><i class="fa fa-search"></i></div>

			 		<div class="input-group">
						<div class="input-group-addon">Código</div>
						<input type="text" class="form-control" placeholder="Por código..." ng-model="searchCertificado.CERT_codigo">
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
		{{ Form::close() }}
	</div>

<table id="tbIndex" class="table table-striped table-condensed responsive-utilities">
	<thead class="info">
		<tr>
			{{--<th style="width:50px;">
				<a href="#" ng-click="sortType = 'CERT_id'; sortReverse = !sortReverse">
					ID
					<span ng-show="sortType == 'CERT_id' && !sortReverse" class="fa fa-caret-down"></span>
					<span ng-show="sortType == 'CERT_id' && sortReverse" class="fa fa-caret-up"></span>
				</a>
			</th>--}}

			<th style="width:100px;">
				<a href="#" ng-click="sortType = 'CERT_codigo'; sortReverse = !sortReverse">
					Código
					<span ng-show="sortType == 'CERT_codigo' && !sortReverse" class="fa fa-caret-down"></span>
					<span ng-show="sortType == 'CERT_codigo' && sortReverse" class="fa fa-caret-up"></span>
				</a>
			</th>

			<th style="width:150px;">
				<a href="#" ng-click="sortType = 'CERT_equipo'; sortReverse = !sortReverse">
					Equipo
					<span ng-show="sortType == 'CERT_equipo' && !sortReverse" class="fa fa-caret-down"></span>
					<span ng-show="sortType == 'CERT_equipo' && sortReverse" class="fa fa-caret-up"></span>
				</a>
			</th>

			<th class="hidden-xs" style="width:50px;">
				<a href="#" ng-click="sortType = 'AGEN_codigo'; sortReverse = !sortReverse">
					Agencia Cod
					<span ng-show="sortType == 'AGEN_codigo' && !sortReverse" class="fa fa-caret-down"></span>
					<span ng-show="sortType == 'AGEN_codigo' && sortReverse" class="fa fa-caret-up"></span>
				</a>
			</th>

			<th>
				<a href="#" ng-click="sortType = 'AGEN_nombre'; sortReverse = !sortReverse">
					Agencia Nombre
					<span ng-show="sortType == 'AGEN_nombre' && !sortReverse" class="fa fa-caret-down"></span>
					<span ng-show="sortType == 'AGEN_nombre' && sortReverse" class="fa fa-caret-up"></span>
				</a>
			</th>

			<th>
				<a href="#" ng-click="sortType = 'REGI_nombre'; sortReverse = !sortReverse">
					Regional
					<span ng-show="sortType == 'REGI_nombre' && !sortReverse" class="fa fa-caret-down"></span>
					<span ng-show="sortType == 'REGI_nombre' && sortReverse" class="fa fa-caret-up"></span>
				</a>
			</th>

			<th class="hidden-xs">
				<a href="#" ng-click="sortType = 'CERT_creadopor'; sortReverse = !sortReverse">
					Creado por
					<span ng-show="sortType == 'CERT_creadopor' && !sortReverse" class="fa fa-caret-down"></span>
					<span ng-show="sortType == 'CERT_creadopor' && sortReverse" class="fa fa-caret-up"></span>
				</a>
			</th>

			{{--<th class="hidden-xs">
				<a href="#" ng-click="sortType = 'CERT_fechacreado'; sortReverse = !sortReverse">
					Fecha Creado
					<span ng-show="sortType == 'CERT_fechacreado' && !sortReverse" class="fa fa-caret-down"></span>
					<span ng-show="sortType == 'CERT_fechacreado' && sortReverse" class="fa fa-caret-up"></span>
				</a>
			</th>--}}

			<th class="hidden-xs">
				<a href="#" ng-click="sortType = 'CERT_modificadopor'; sortReverse = !sortReverse">
					Modif por
					<span ng-show="sortType == 'CERT_modificadopor' && !sortReverse" class="fa fa-caret-down"></span>
					<span ng-show="sortType == 'CERT_modificadopor' && sortReverse" class="fa fa-caret-up"></span>
				</a>
			</th>

			{{--<th class="hidden-xs">
				<a href="#" ng-click="sortType = 'CERT_fechamodificado'; sortReverse = !sortReverse">
					Fecha Modificado
					<span ng-show="sortType == 'CERT_fechamodificado' && !sortReverse" class="fa fa-caret-down"></span>
					<span ng-show="sortType == 'CERT_fechamodificado' && sortReverse" class="fa fa-caret-up"></span>
				</a>
			</th>--}}

			<th>
				Acciones
			</th>
		</tr>
	</thead>
	
	<tbody>
	  <tr ng-repeat="certificado in certificados | orderBy:sortType:sortReverse | filter:searchCertificado">
			{{-- <td>{% certificado.CERT_id %}</td> --}}
			<td>{% certificado.CERT_codigo %}</td>
			<td>{% certificado.CERT_equipo %}</td>
			<td class="hidden-xs">{% certificado.AGEN_codigo %}</td>
			<td>{% certificado.AGEN_nombre %}</td>
			<td>{% certificado.REGI_nombre %}</td>
			<td class="hidden-xs">{% certificado.CERT_creadopor %}</td>
			{{-- <td class="hidden-xs">{% certificado.CERT_fechacreado %}</td> --}}
			<td class="hidden-xs">{% certificado.CERT_modificadopor %}</td>
			{{-- <td class="hidden-xs">{% certificado.CERT_fechamodificado %}</td> --}}
			<td>
				<!-- carga botón de Ver -->
				<a class="btn btn-xs btn-success" href="{% 'certificados/' + certificado.CERT_id %}" role="button">
					<span class="glyphicon glyphicon-eye-open"></span> Ver
				</a>


				<!-- Cargar botón editar -->
				<a class="btn btn-xs btn-info" href="{% 'certificados/' + certificado.CERT_id + '/edit' %}">
					<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar
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
		<td colspan="8" class="text-center">
			<div ng-show="show"><i class="fa fa-cog fa-spin fa-2x fa-fw"></i> Cargando registros...</div>
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

