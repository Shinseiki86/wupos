@extends('layouts.menu')
@section('title', '/ Regionales')

@section('page_heading')
	<div class="row">
		<div id="title" class="col-xs-8 col-md-6 col-lg-6">
			Regionales
		</div>
		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
			<a class='btn btn-primary' role='button' href="{{ route('gyf.regionales.create') }}" data-tooltip="tooltip" title="Crear Nuevo" name="create">
				<i class="fas fa-plus" aria-hidden="true"></i>
			</a>
		</div>
	</div>
@endsection

@section('section')

	<table class="table table-striped" id="tabla">
		<thead>
			<tr>
				<th class="col-xs-1">Código</th>
				<th class="col-xs-6">Nombre</th>
				<th class="col-xs-2 notFilter">Agencias</th>
				<th class="col-xs-2">Creado por</th>
				<th class="col-xs-1 all notFilter"></th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>

	@include('widgets.modals.modal-withAction')
	@include('widgets.datatable.datatable-ajax', ['urlAjax'=>route('gyf.regionales.getData'), 'columns'=>[
			'REGI_CODIGO',
			'REGI_NOMBRE',
			'count_agencias',
			'REGI_CREADOPOR',
	]])	
@endsection