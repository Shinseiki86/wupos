@extends('layout')
@section('title', '/ Roles')

@section('content')

	<h1 class="page-header">Roles</h1>
	<div class="row well well-sm">

		<div id="btn-create" class="pull-right">
			<a class='btn btn-primary' role='button' href="{{ URL::to('roles/create') }}">
				<i class="fa fa-plus" aria-hidden="true"></i> Nuevo Rol
			</a>
		</div>
	</div>
	
<table class="table table-striped">
	<thead>
		<tr>
			<th class="col-md-2">ID</th>
			<th class="col-md-2">Descripción</th>
			<th class="col-md-2">Creado por</th>
			<th class="col-md-2">Acciones</th>

		</tr>
	</thead>
	<tbody>


		@foreach($roles as $rol)
		<tr>
			<td>{{ $rol -> ROLE_id }}</td>
			<td>{{ $rol -> ROLE_descripcion }}</td>
			<td>{{ $rol -> ROLE_creadopor }}</td>
			<td>

				<!-- Botón Editar (edit) -->
				<a class="btn btn-small btn-info btn-xs" href="{{ URL::to('roles/'.$rol->ROLE_id.'/edit') }}">
					<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar
				</a><!-- Fin Botón Editar (edit) -->

				<!-- Botón Borrar (destroy) -->
				{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i> Borrar',[
						'class'=>'btn btn-xs btn-danger',
						'data-toggle'=>'modal',
						'data-target'=>'#pregModal'.$rol -> ROLE_id ])
						}}

				<!-- Mensaje Modal. Bloquea la pantalla mientras se procesa la solicitud -->
				<div class="modal fade" id="pregModal{{ $rol -> ROLE_id }}" role="dialog" tabindex="-1" >
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">¿Borrar?</h4>
							</div>
							<div class="modal-body">
								<p>
									<i class="fa fa-exclamation-triangle"></i> ¿Desea borrar el rol {{ $rol -> ROLE_descripcion }}?
								</p>
							</div>
							<div class="modal-footer">
									{{ Form::open(array('url' => 'roles/'.$rol->ROLE_id, 'class' => 'pull-right')) }}
										{{ Form::hidden('_method', 'DELETE') }}
										{{ Form::button(' NO ', ['class'=>'btn btn-xs btn-success', 'type'=>'button','data-dismiss'=>'modal']) }}
										{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i> SI',[
											'class'=>'btn btn-xs btn-danger',
											'type'=>'submit',
											'data-toggle'=>'modal',
											'data-backdrop'=>'static',
											'data-target'=>'#msgModal',
										]) }}
									{{ Form::close() }}
							</div>
				  		</div>
					</div>
				</div><!-- Fin Botón Borrar (destroy) -->

			</td>
		</tr>
		@endforeach
	</tbody>
</table>

@endsection