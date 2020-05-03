@extends('layouts.menu')
@section('title', '/ Agencias')

@section('page_heading')
	<div class="row">
		<div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
			Agencias
		</div>
		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
			<a class='btn btn-primary' role='button' href="{{ route('gyf.agencias.create') }}" data-tooltip="tooltip" title="Crear Nuevo" name="create">
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
				<th class="col-xs-6 all">Nombre</th>
				<th class="col-xs-2 all">Cuenta WU</th>
				<th class="col-xs-3">Regional</th>
				<th class="col-xs-1 all">Activa</th>
				<th class="col-xs-1 all notFilter">Certificados</th>
				<th class="col-xs-2">Creado por</th>
				<th class="col-xs-1 all notFilter"></th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>

	@include('widgets.modals.modal-withAction')
	@include('widgets.datatable.datatable-ajax', ['urlAjax'=>route('gyf.agencias.getData'), 'columns'=>[
		'AGEN_CODIGO',
		'AGEN_NOMBRE',
		'AGEN_CUENTAWU',
		'REGI_NOMBRE',
		'AGEN_ACTIVA',
		'count_certificados',
		'AGEN_CREADOPOR',
	]])	
@endsection