@extends('layout')
@section('title', '/ Regionales')

@section('content')

	<h1 class="row page-header">
		<div class="col-xs-12 col-sm-3">
			Regionales
		</div>

		<div class="col-xs-12 col-sm-9 text-right">
			<a class='btn btn-primary' role='button' href="{{ URL::to('regionales/create') }}">
				<i class="fa fa-plus" aria-hidden="true"></i> Nuevo
			</a>
		</div>
	</h1>

	
	<table class="table table-striped table-condensed">
		<thead>
			<tr>
				<th class="col-xs-1">ID</th>
				<th class="col-xs-1">Código</th>
				<th class="col-xs-6">Nombre</th>
				<th class="col-xs-2">Agencias</th>
				<th class="col-xs-1 notFilter all">Acciones</th>
			</tr>
		</thead>
		<tbody>


			@foreach($regionales as $regional)
			<tr>
				<td>{{ $regional -> REGI_id }}</td>
				<td>{{ $regional -> REGI_codigo }}</td>
				<td>{{ $regional -> REGI_nombre }}</td>
				<td>{{ $regional->agencias()->where('AGEN_activa', true)->where('AGENCIAS.AGEN_cuentawu', '!=', null)->groupBy('REGI_id')->count() }}</td>
				<td>
					<!-- Botón Ver (show) -->
					<a class="btn btn-small btn-success btn-xs" href="{{ URL::to('regionales/'.$regional->REGI_id) }}">
						<span class="glyphicon glyphicon-eye-open"></span>
					</a><!-- Fin Botón Ver (show) -->

					<!-- Botón Editar (edit) -->
					<a class="btn btn-small btn-info btn-xs" href="{{ URL::to('regionales/'.$regional->REGI_id.'/edit') }}">
						<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
					</a><!-- Fin Botón Editar (edit) -->

					<!-- Botón Borrar (destroy) -->
					{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i>',[
						'class'=>'btn btn-xs btn-danger',
						'data-toggle'=>'modal',
						'data-id'=>$regional -> REGI_id,
						'data-descripcion'=> $regional -> REGI_nombre,
						'data-action'=>'regionales/'.$regional -> REGI_id,
						'data-target'=>'#pregModalDelete',
					])}}

				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

@include('partials/modalDelete') <!-- incluye el modal del Delete -->	
@endsection