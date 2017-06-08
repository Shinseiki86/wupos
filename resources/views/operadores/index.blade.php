@extends('layout')
@section('title', '/ Operadores')

@section('content')
	<style type="text/css">
		.pagination{margin:0;}
	</style>
@parent
@endsection

@section('scripts')
	{!! Html::script('assets/js/momentjs/moment-with-locales.min.js') !!}
	<script type="text/javascript">
		$(document).ready(function () {
			//Formato de fecha
			var formatDate = function(strDate){
				var strDateFormatted = moment(strDate).format('DD/MM/YYYY hh:mm A');
				return strDateFormatted;
			}

			//.css('background-color', 'orange');
			$('.estado_{{\Wupos\EstadoOperador::PEND_CREAR}}').addClass('warning');
			$('.estado_{{\Wupos\EstadoOperador::CREADO}}').addClass('success');
			$('.estado_{{\Wupos\EstadoOperador::PEND_ELIMINAR}}').addClass('danger');

		});
	</script>
@parent
@endsection

@section('content')

	<h1 class="page-header">
		<div class="row">
			<div id="titulo" class="col-xs-12 col-md-5 col-lg-4">
				Operadores {{$papelera ? 'Eliminados' : ''}}
			</div>
			<div id="btns-top" class="col-xs-12 col-md-7 col-lg-8 text-right">
				@include('operadores/index-Btns')
			</div>
		</div>
	</h1>

	@include('operadores/index-collapseFormFilters')

	<table id="tbIndex" class="table">
		<thead>
			<tr class="active">
				<th class="col-xs-1 col-sm-1 col-md-1 col-lg-1 codigo">Código</th>
				<th class="hidden-xs col-sm-1 col-md-1 col-lg-1 cedula">Cédula</th>
				<th class="col-xs-2 col-sm-2 col-md-2 col-lg-2 nombres">Nombres</th>
				<th class="col-xs-2 col-sm-2 col-md-2 col-lg-2 apellidos">Apellidos</th>
				<th class="col-xs-1 col-sm-1 col-md-1 col-lg-1 estado">Estado</th>
				<th class="hidden-xs col-sm-1 col-md-1 col-lg-1 regional">Regional</th>
				<th class="hidden-xs col-sm-1 col-md-1 col-lg-1">Creador</th>
				@if($papelera)
				<th class="hidden-xs col-sm-1 col-md-1 col-lg-1">Eliminado</th>
				@else
				<th class="hidden-xs col-sm-1 col-md-1 col-lg-1">Modif.</th>
				@endif
				<th class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></th>
			</tr>
		</thead>
		
		<tbody class="hide">
			@foreach($operadores as $operador)
			<tr class="estado_{{ $operador -> ESOP_id}}">
				<td>{{ str_pad($operador -> OPER_codigo, 3, '0', STR_PAD_LEFT) }}</td>
				<td class="hidden-xs">{{ $operador -> OPER_cedula }}</td>
				<td>{{ $operador -> OPER_nombre }}</td>
				<td>{{ $operador -> OPER_apellido }}</td>
				<td>{{ $operador -> estado -> ESOP_descripcion }}</td>
				<td class="hidden-xs">{{ $operador -> regional -> REGI_nombre }}</td>
				<td class="hidden-xs">{{ $operador -> OPER_creadopor }}</td>
				<td class="hidden-xs">{{ $papelera ? $operador-> OPER_eliminadopor : $operador-> OPER_modificadopor }}</td>
				<td>
					@if(!$papelera)
					<!-- Cargar botón Editar -->
					<a class="btn btn-xs btn-info" href="{{ 'operadores/'. $operador->OPER_id . '/edit' }}">
						<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
					</a>
					@else
					<!-- Cargar botón Restaurar 
					<a class="btn btn-xs btn-warning" href="{{ 'operadores/'. $operador->OPER_id . '/restore' }}">
						<i class="fa fa-undo" aria-hidden="true"></i>
					</a>-->
					@endif

					<!-- carga botón de Borrar -->
					@if($operador->ESOP_id == \wupos\EstadoOperador::CREADO)
					{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i>',[
						'class'=>'btn btn-xs btn-warning btn-delete',
						'data-toggle'=> 'modal',
						'data-id'=> str_pad($operador->OPER_codigo, 3, '0', STR_PAD_LEFT),
						'data-descripcion'=> $operador->OPER_nombre.' '.$operador->OPER_apellido,
						'data-action'=> 'operadores/'.$operador->OPER_id.'/pendBorrar',
						'data-target'=> '#pregModalDelete',
					])}}
					@elseif($operador->ESOP_id == \wupos\EstadoOperador::PEND_ELIMINAR)
					{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i>',[
						'class'=>'btn btn-xs btn-danger btn-delete',
						'data-toggle'=> 'modal',
						'data-id'=> str_pad($operador->OPER_codigo, 3, '0', STR_PAD_LEFT),
						'data-descripcion'=> $operador->OPER_nombre.' '.$operador->OPER_apellido,
						'data-action'=> 'operadores/'.$operador->OPER_id,
						'data-target'=> '#pregModalDelete',
					])}}
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>

		<!--tfoot>
			<td colspan="10">
				<div class="text-center">
					<i class="fa fa-cog fa-spin fa-2x fa-fw" style="vertical-align: middle;"></i> Cargando registros...
				</div>
			</td>
		</tfoot-->
	</table>

	@include('operadores/index-modalExport')
	@include('partials/datatable')
	@include('partials/modalDelete') <!-- incluye el modal del Delete -->
@endsection

	