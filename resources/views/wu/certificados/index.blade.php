@extends('layouts.menu')
@section('title', '/ Certificados '.($trash ? 'Eliminados' : '') )

@section('page_heading')
	<div class="row">
		<div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
			Certificados {{$trash ? 'Eliminados' : ''}}
		</div>
		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
			@if(!$trash)
				@permission('operador-restore')
				<a class='btn btn-warning' role='button' href="{{ route('wu.certificados.trash') }}" data-tooltip="tooltip" title="Papelera" name="trash">
					<i class="fas fa-trash-alt" aria-hidden="true"></i>
				</a>
				@endpermission
				<a class='btn btn-primary' role='button' href="{{ route('wu.certificados.create') }}" data-tooltip="tooltip" title="Crear Nuevo" name="create">
					<i class="fas fa-plus" aria-hidden="true"></i>
				</a>
			@else
				<a class='btn btn-primary' role='button' href="{{ route('wu.certificados.index') }}" data-tooltip="tooltip" title="Regresar" name="create">
					<i class="fas fa-arrow-left" aria-hidden="true"></i>
				</a>
				{{ Form::button('<i class="fas fa-trash" aria-hidden="true"></i>',[
					'class'=>'btn btn-danger btn-delete',
					'data-toggle' =>'modal',
					'data-class'  =>'danger',
					'data-model'  => 'Certificados',
					'data-descripcion'=> 'TODOS LOS REGISTROS EN PAPELERA',
					'data-method' => 'POST',
					'data-action' => route('wu.certificados.emptyTrash'),
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
				<th class="col-xs-1 all">Hostname</th>
				<th class="col-xs-3">Agencia</th>
				<th class="col-xs-1 all">Cuenta WU</th>
				<th class="col-xs-2">Regional</th>
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
	@include('widgets.datatable.datatable-ajax', ['urlAjax'=>route('wu.certificados.getData', compact('trash')), 'columns'=>array_merge([
		'CERT_CODIGO',
		'CERT_EQUIPO',
		'AGENCIAS.AGEN_NOMBRE',
		'AGENCIAS.AGEN_CUENTAWU',
		'REGIONALES.REGI_NOMBRE',
		'CERT_CREADOPOR',
		'CERT_FECHACREADO',
	] , $trash ? ['CERT_ELIMINADOPOR','CERT_FECHAELIMINADO'] : ['CERT_MODIFICADOPOR','CERT_FECHAMODIFICADO'] )])
@endsection