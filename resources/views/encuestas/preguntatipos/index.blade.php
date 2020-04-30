@extends('layouts.menu')
@section('title', '/ Estados')

@section('page_heading')
	<div class="row">
		<div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
			Tipos de Pregunta
		</div>
		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
			<a class='btn btn-primary' role='button' href="{{ route('encuestas.preguntatipos.create') }}" data-tooltip="tooltip" title="Crear Nuevo" name="create">
				<i class="fas fa-plus" aria-hidden="true"></i>
			</a>
		</div>
	</div>
@endsection

@section('section')

	<table class="table table-striped" id="tabla">
		<thead>
			<tr>
				<th class="col-xs-1">ID</th>
				<th class="col-xs-6">Nombre</th>
				<th class="col-xs-2">Creador</th>
				<th class="col-xs-1 all notFilter"></th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>

	@include('widgets.modals.modal-delete')
	@include('widgets.datatable.datatable-ajax', ['urlAjax'=>'getPregTipos', 'columns'=>[
		'PRTI_ID',
		'PRTI_DESCRIPCION',
		'PRTI_CREADOPOR',
	]])	
@endsection