@extends('layouts.menu')
@section('title', '/ Estados')

@section('page_heading')
	<div class="row">
		<div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
			Operadores
		</div>
		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
			<a class='btn btn-primary' role='button' href="{{ route('wu.operadores.create') }}" data-tooltip="tooltip" title="Crear Nuevo" name="create">
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
				<th class="col-xs-1 all">Cédula</th>
				<th class="col-xs-3">Nombre</th>
				<th class="col-xs-3">Apellido</th>
				<th class="col-xs-1 all">Regional</th>
				<th class="col-xs-1 all">Estado</th>
				<th class="col-xs-1 all notFilter"></th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>

	@include('widgets.modals.modal-delete')
	@include('widgets.datatable.datatable-ajax', ['urlAjax'=>route('wu.operadores.getData'), 'columns'=>[
		'OPER_CODIGO',
		'OPER_CEDULA',
		'OPER_NOMBRE',
		'OPER_APELLIDO',
		'regional.REGI_CODIGO',
		'ESOP_DESCRIPCION',
	]])	
@endsection