<?php $preguntas = $encuesta->preguntasJoinTipoPreg; ?>

@push('head')
	<style>
		.tbPregsText {
			cursor: auto
		}

		.tbPregsDrag:drag {
			cursor: auto;
			cursor: -webkit-grabbing;
			cursor: -moz-grabbing
		}

		.tbPregsDrag:hover {
			cursor: n-resize;
			cursor: -webkit-grab;
			cursor: -moz-grab
		}
	</style>
@endpush

@push('scripts')
	{!! Html::script('js/angular/angular.min.js') !!}
	{!! Html::script('js/Sortable/Sortable.js') !!}
	{!! Html::script('js/Sortable/ng-sortable.js') !!}
	@rinclude('index-scriptAngular')
@endpush

<div class="container_tb_preguntas" ng-app="appEva360" ng-controller="PreguntasController">

	<table class="table table-striped">
		<thead>
			<tr>
				<th class="hidden-xs col-sm-1 col-md-1 col-lg-1">ID</th>
				<th class="col-xs-1 col-sm-1 col-md-1 col-lg-1">Pos</th>
				<th class="col-xs-4 col-sm-5 col-md-5 col-lg-3">Título</th>
				<th class="col-xs-3 col-sm-3 col-md-2 col-lg-2">Tipo</th>
				<th class="hidden-xs col-sm-1 col-md-1 col-lg-2">Creado</th>
				<th class="hidden-xs col-sm-1 col-md-1 col-lg-2">Modificado</th>
				<th class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></th>
			</tr>
		</thead>
		
		<tbody id="tbPregs" class="tbPregsText hide">
			<tr id="trPregs" ng-repeat="preg in preguntas" >
				<td class="hidden-xs" ng-bind="preg.PREG_ID"></td>
				<td ng-bind="($index + 1)"></td>
				<td ng-bind="preg.PREG_TITULO"></td>
				<td ng-bind="preg.PRTI_DESCRIPCION"></td>
				<td class="hidden-xs" ng-bind="formatDate(preg.PREG_FECHACREADO)"></td>
				<td class="hidden-xs" ng-bind="formatDate(preg.PREG_FECHAMODIFICADO)"></td>
				<td>
					<!-- Cargar botón editar -->
					<a name="btn-editPreg" class="btn btn-sm btn-info btn-xs {% (ENCU_ESTADO != ENCU_ABIERTA) ? 'disabled' : '' %}" href="{% ENCU_ID + '/pregs/' + preg.PREG_ID + '/edit' %}" uib-tooltip="Editar">
						<i class="fas fa-edit" aria-hidden="true"></i>
					</a>

					<!-- carga botón de borrar -->
					{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i>',[
						'name'       => 'btn-deletePreg',
						'class'      => 'btn btn-xs btn-danger btn-delete',
						'data-toggle'=> 'modal',
						'data-id'    => '{% preg.PREG_ID %}',
						'data-modelo'=> 'Pregunta',
						'data-descripcion'=>'{% preg.PREG_TITULO %}',
						'data-action'=> '{% ENCU_ID + "/pregs/" + preg.PREG_ID %}',
						'data-target'=> '#pregModalDelete',
						'ng-disabled'=> 'ENCU_ESTADO != ENCU_ABIERTA',
						'uib-tooltip'=> 'Borrar',
					])}}
				</td>
			</tr>
		</tbody>

		<tfoot>
			<tr>
				<td colspan="7" class="text-center" ng-show="show">
					<i class="fa fa-cog fa-spin fa-2x fa-fw" style="vertical-align: middle;"></i> Cargando registros...
				</td>
			</tr>
		</tfoot>
	</table>
@rinclude('index-btns')
@rinclude('index-modalOrdenarPregs')
@include('widgets.modals.modal-delete')
</div> <!-- Fin ng-controller="PreguntasCtrl" -->

