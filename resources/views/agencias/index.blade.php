@extends('layout')
@section('title', '/ Agencias')

@section('content')

	<h1 class="row page-header">
		<div class="col-xs-12 col-sm-3">
			Agencias
		</div>

		<div class="col-xs-12 col-sm-9 text-right">
			<a class='btn btn-primary' role='button' href="{{ URL::to('agencias/create') }}">
				<i class="fa fa-plus" aria-hidden="true"></i> Nuevo
			</a>
		</div>
	</h1>
		
	<table id="tbIndex" class="table table-striped table-condensed">
		<thead>
			<tr>
				<th>Código</th>
				<th>Nombre</th>
				<th>Regional</th>
				<th>Cuenta WU</th>
				<th class="notFilter">Acciones</th>
			</tr>
		</thead>
		<tbody>
			@foreach($agencias as $agencia)
			<tr class="{{ $agencia->AGEN_activa ? '' : 'danger' }}">
				<td style="width:100px;">{{ $agencia -> AGEN_codigo }}</td>
				<td>{{ $agencia -> AGEN_nombre }}</td>
				<td>{{ $agencia -> regional -> REGI_nombre }}</td>
				<td style="width:100px;">{{ $agencia -> AGEN_cuentawu }}</td>
				<td>
					<!-- Botón Ver (show) -->
					<a class="btn btn-small btn-success btn-xs" href="{{ URL::to('agencias/'.$agencia->AGEN_id) }}">
						<span class="glyphicon glyphicon-eye-open"></span>
					</a><!-- Fin Botón Ver (show) -->

					<!-- Botón Editar (edit) -->
					<a class="btn btn-small btn-info btn-xs" href="{{ URL::to('agencias/'.$agencia->AGEN_id.'/edit') }}">
						<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
					</a><!-- Fin Botón Editar (edit) -->

					<!-- Botón Borrar (destroy) -->
					{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i>',[
						'class'=>'btn btn-xs btn-danger',
						'data-toggle'=>'modal',
						'data-id'=>$agencia -> AGEN_id,
						'data-descripcion'=> $agencia -> AGEN_nombre,
						'data-action'=>'agencias/'.$agencia -> AGEN_id,
						'data-target'=>'#pregModalDelete',
					])}}
				</td>
			</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<th>Código</th>
				<th>Nombre</th>
				<th>Regional</th>
				<th>Cuenta WU</th>
				<th>Acciones</th>
			</tr>
		</tfoot>
	</table>

@include('partials/modalDelete') <!-- incluye el modal del Delete -->	
@include('partials/datatable') <!-- Script para tablas -->	
@endsection