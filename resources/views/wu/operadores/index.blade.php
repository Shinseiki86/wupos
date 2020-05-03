@extends('layouts.menu')
@section('title', '/ Operadores '.($trash ? 'Eliminados' : '') )

@section('page_heading')
	<div class="row">
		<div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
			Operadores {{$trash ? 'Eliminados' : ''}}
		</div>
		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
			@if(!$trash)
				@permission('operador-restore')
				<a class='btn btn-warning' role='button' href="{{ route('wu.operadores.trash') }}" data-tooltip="tooltip" title="Papelera" name="trash">
					<i class="fas fa-trash-alt" aria-hidden="true"></i>
				</a>
				@endpermission
				<a class='btn btn-primary' role='button' href="{{ route('wu.operadores.create') }}" data-tooltip="tooltip" title="Crear Nuevo" name="create">
					<i class="fas fa-plus" aria-hidden="true"></i>
				</a>
			@else
				<a class='btn btn-primary' role='button' href="{{ route('wu.operadores.index') }}" data-tooltip="tooltip" title="Regresar" name="create">
					<i class="fas fa-arrow-left" aria-hidden="true"></i>
				</a>
				{{ Form::button('<i class="fas fa-trash" aria-hidden="true"></i>',[
					'class'=>'btn btn-danger btn-delete',
					'data-toggle' =>'modal',
					'data-class'  =>'danger',
					'data-model'  => 'Operadores',
					'data-descripcion'=> 'TODOS LOS REGISTROS EN PAPELERA',
					'data-method' => 'POST',
					'data-action' => route('wu.operadores.emptyTrash'),
					'data-target' =>'#pregModalAction',
					'data-tooltip'=>'tooltip',
					'data-title'  =>'Vaciar Papelera',
				])}}
			@endif
		</div>
	</div>
@endsection

@section('section')

	<table class="table table-striped" id="tabla">
		<thead>
			<tr>
				<th class="col-xs-1 all">Código</th>
				<th class="col-xs-1 all">Cédula</th>
				<th class="col-xs-3">Nombre</th>
				<th class="col-xs-1 all">Regional</th>
				<th class="col-xs-1 all">Estado</th>
				<th class="col-xs-1">Creado</th>
				<th class="col-xs-1">Fecha</th>
				<th class="col-xs-1">{{$trash ? 'Eliminado' : 'Modificado'}}</th>
				<th class="col-xs-1">Fecha</th>
				<th class="col-xs-1 all notFilter"></th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>

	@include('widgets.modals.modal-withAction')
	@include('widgets.datatable.datatable-ajax', ['urlAjax'=>route('wu.operadores.getData', compact('trash')), 'columns'=>array_merge([
		'OPER_CODIGO',
		'OPER_CEDULA',
		'OPER_NOMBRECOMPLETO',
		'REGIONALES.REGI_NOMBRE',
		'ESTADOSOPERADORES.ESOP_DESCRIPCION',
		'OPER_CREADOPOR',
		'OPER_FECHACREADO',
	] , $trash ? ['OPER_ELIMINADOPOR','OPER_FECHAELIMINADO'] : ['OPER_MODIFICADOPOR','OPER_FECHAMODIFICADO'] )])
@endsection