@extends('layout')
@section('title', '/ Operadores')


@section('content')

	<h1 class="page-header">Operadores</h1>

	<div class="well well-sm text-right">
		<!-- Botones -->

			<!-- botón de crear nuevo reg -->
			@if(in_array(auth()->user()->rol->ROLE_rol , ['admin']))
			<a class='btn btn-primary' role='button' href="{{ URL::to('operadores/create') }}">
				<i class="fa fa-plus" aria-hidden="true"></i> Nuevo Operador
				<span class="sr-only">Nuevo</span>
			</a>
			@endif

			<!-- botón de exportar -->
			{{ Form::open( [ 'url'=>'operadores/export/xlsx', 'method'=>'GET', 'class' => 'pull-right' ]) }}
				{{ Form::button('<i class="fa fa-download" aria-hidden="true"></i> Exportar',[
						'class'=>'btn btn-success',
						'type'=>'submit',
						//'data-toggle'=>'modal',
						//'data-target'=>'#pregModalExport',
				]) }}
			{{ Form::close() }}
	</div>

	<table id="tbIndex" class="table table-striped table-condensed responsive-utilities">
		<thead>
			<tr class="active">
				<th>Código</th>
				<th>Cédula</th>
				<th>Nombre</th>
				<th>Apellido</th>
				<th>Estado</th>
				<th>Regional</th>
				<th>Creador</th>
				<th>Modif</th>
				<th class="col-xs-1 col-sm-1 col-md-3 col-lg-3">
					Acciones
				</th>
			</tr>
		</thead>
		
		<tbody>
			@foreach($operadores as $operador)
			<tr>
				<td>{{ str_pad($operador -> OPER_codigo, 3, '0', STR_PAD_LEFT) }}</td>
				<td>{{ $operador -> OPER_cedula }}</td>
				<td>{{ $operador -> OPER_nombre }}</td>
				<td>{{ $operador -> OPER_apellido }}</td>
				<td>{{ $operador -> estado -> ESOP_descripcion }}</td>
				<td>{{ $operador -> regional -> REGI_nombre }}</td>
				<td>{{ $operador -> OPER_creadopor }}</td>
				<td>{{ $operador -> OPER_modificadopor }}</td>
				<td>
					<!-- carga botón de Ver -->
					<a class="btn btn-xs btn-success" href="{{ 'operadores/'. $operador->OPER_id }}" role="button">
						<span class="glyphicon glyphicon-eye-open"></span> <span class="hidden-xs">Ver</span>
					</a>

					<!-- Cargar botón editar -->
					<a class="btn btn-xs btn-info" href="{{ 'operadores/'. $operador->OPER_id . '/edit' }}">
						<i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span class="hidden-xs">Editar</span>
					</a>

					<!-- carga botón de borrar -->
					{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i> <span class="hidden-xs">Borrar</span>',[
							'class'=>'btn btn-xs btn-danger',
							'data-toggle'=> 'modal',
							'data-id'=> $operador->OPER_id,
							'data-descripcion'=> 'cédula '.$operador->OPER_cedula,
							'data-action'=> 'operadores/'.$operador->OPER_id,
							'data-target'=> '#pregModalDelete',
						])
					}}
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	@include('operadores/index-modalExport')
	@include('partials/modalDelete') <!-- incluye el modal del Delete -->
	@include('partials/datatable') <!-- Script para tablas -->
@endsection

	