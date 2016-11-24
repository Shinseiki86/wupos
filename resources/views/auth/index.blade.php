@extends('layout')
@section('title', '/ Usuarios Locales')

@section('content')

	<h1 class="page-header">Usuarios Locales</h1>
	<div class="row well well-sm">

		<div id="btn-create" class="pull-right">
			<a class='btn btn-primary' role='button' href="{{ URL::to('roles') }}">
				<i class="fa fa-male" aria-hidden="true"></i> <i class="fa fa-female" aria-hidden="true"></i> Roles
			</a>
			<a class='btn btn-primary' role='button' href="{{ URL::to('register') }}">
				<i class="fa fa-user-plus" aria-hidden="true"></i> Nuevo Usuario
			</a>
		</div>
	</div>
	
<table class="table table-striped">
	<thead>
		<tr>
			<th class="">ID</th>
			<th class="">Nombre</th>
			<th class="">Login</th>
			<th class="">Rol</th>
			<th class="hidden-xs">Creado por</th>
			<th style="width:230px;">Acciones</th>
		</tr>
	</thead>
	<tbody>


		@foreach($usuarios as $usuario)
		<tr>
			<td>{{ $usuario -> USER_id }}</td>
			<td>{{ $usuario -> name }}</td>
			<td>{{ $usuario -> username }}</td>
			<td>{{ $usuario -> rol -> ROLE_descripcion }}</td>
			<td class="hidden-xs">{{ $usuario -> USER_creadopor }}</td>
			<td>

				<!-- Botón Ver (show) -->
				<a class="btn btn-small btn-success btn-xs" href="{{ URL::to('usuarios/'.$usuario->USER_id) }}">
					<span class="glyphicon glyphicon-eye-open"></span> Ver
				</a><!-- Fin Botón Ver (show) -->

				<!-- Botón Ver (show) -->
				<a class="btn btn-small btn-success btn-xs" href="{{ URL::to('usuarios/'.$usuario->USER_id) }}">
					<i class="fa fa-btn fa-envelope" aria-hidden="true"></i> Cambiar Contraseña
				</a><!-- Fin Botón Ver (show) -->

				<!-- Botón Editar (edit) -->
				<a class="btn btn-small btn-info btn-xs" href="{{ URL::to('usuarios/'.$usuario->USER_id.'/edit') }}">
					<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar
				</a><!-- Fin Botón Editar (edit) -->

				<!-- Botón Borrar (destroy) -->
				{{ Form::button('<i class="fa fa-user-times" aria-hidden="true"></i> Borrar',[
						'class'=>'btn btn-xs btn-danger',
						'data-toggle'=>'modal',
						'data-target'=>'#pregModal'.$usuario -> USER_id ])
						}}

				<!-- Mensaje Modal. Bloquea la pantalla mientras se procesa la solicitud -->
				<div class="modal fade" id="pregModal{{ $usuario -> USER_id }}" role="dialog" tabindex="-1" >
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">¿Borrar?</h4>
							</div>
							<div class="modal-body">
								<p>
									<i class="fa fa-exclamation-triangle"></i> ¿Desea borrar el usuario {{ $usuario -> username }}?
								</p>
							</div>
							<div class="modal-footer">
									{{ Form::open( ['url' => 'usuarios/'.$usuario->USER_id, 'class' => 'pull-right'] ) }}
										{{ Form::hidden('_method', 'DELETE') }}
										{{ Form::button(' NO ', ['class'=>'btn btn-xs btn-success', 'type'=>'button','data-dismiss'=>'modal']) }}
										{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i> SI',[
											'class'=>'btn btn-xs btn-danger',
											'type'=>'submit',
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