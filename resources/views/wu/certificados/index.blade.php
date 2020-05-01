@extends('layouts.menu')
@section('title', '/ Certificados')

@section('page_heading')
	<div class="row">
		<div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
			Certificados
		</div>
		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
			<a class='btn btn-primary' role='button' href="{{ route('wu.certificados.create') }}" data-tooltip="tooltip" title="Crear Nuevo" name="create">
				<i class="fas fa-plus" aria-hidden="true"></i>
			</a>
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
				<th class="col-xs-1">Modificado</th>
				<th class="col-xs-1">Fecha</th>
				<th class="col-xs-1 all notFilter"></th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>

	@include('widgets.modals.modal-delete')
	@include('widgets.datatable.datatable-ajax', ['urlAjax'=>route('wu.certificados.getData'), 'columns'=>[
		'CERT_CODIGO',
		'CERT_EQUIPO',
		'AGENCIAS.AGEN_NOMBRE',
		'AGENCIAS.AGEN_CUENTAWU',
		'REGIONALES.REGI_NOMBRE',
		'CERT_CREADOPOR',
		'CERT_FECHACREADO',
		'CERT_MODIFICADOPOR',
		'CERT_FECHAMODIFICADO',
	]])	
@endsection