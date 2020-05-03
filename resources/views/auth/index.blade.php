@extends('layouts.menu')
@section('title', '/ Usuarios Locales')
@include('widgets.datatable.datatable-export')

@section('page_heading')
	<div class="row">
		<div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
			Usuarios Locales
		</div>
		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
			
			<a class='btn btn-primary' role='button' href="{{ URL::to('/register') }}" data-tooltip="tooltip" title="Crear Nuevo" name="create">
				<i class="fas fa-user-plus" aria-hidden="true"></i>
			</a>

		</div>
	</div>
@endsection

@section('section')
	
	<table class="table table-striped" id="tabla">
		<thead>
			<tr class="active">
				<th class="col-md-4 all">Nombre</th>
				<th class="col-md-1 all">Usuario</th>
				<th class="col-md-1">Cedula</th>
				<th class="col-md-2">Email</th>
				<th class="col-md-1 all">Roles</th>
				<th class="col-md-1">Creado</th>
				<th class="col-md-1">Modificado</th>
				<th class="col-md-1 all notFilter"></th>
			</tr>
		</thead>
		<tbody>

			@foreach($usuarios as $usuario)
			<tr>
				<td>{{ $usuario->name }}</td>
				<td>{{ $usuario->username }}</td>
				<td>{{ $usuario->cedula }}</td>
				<td>{{ $usuario->email }}</td>
				<td>
					<i class="fas fa-address-card" aria-hidden="true" data-tooltip="tooltip" data-placement="bottom" data-container="body" title="{{ $usuario->roles->implode('display_name', ', ') }}"></i>
					{{ $usuario->roles->count() }} 
				</td>
				<td>{{ $usuario->USER_CREADOPOR }}</td>
				<td>{{ $usuario->USER_MODIFICADOPOR }}</td>
				<td>
					{{-- <!-- Botón Ver (show) -->
					<a class="btn btn-success btn-xs" href="{{ URL::to('usuarios/'.$usuario->id) }}">
						<span class="glyphicon glyphicon-eye-open"></span> <span class="hidden-xs">Ver</span>
					</a><!-- Fin Botón Ver (show) --> --}}

					{{-- <!-- Botón Contraseña (sendResetLinkEmail) -->
					<a class="btn btn-warning btn-xs" href="{{ URL::to('password/email/'.$usuario->id) }}">
						<i class="fas fa-envelope" aria-hidden="true"></i> <span class="hidden-xs">Contraseña</span>
					</a><!-- Fin Botón Contraseña (sendResetLinkEmail) --> --}}

					<!-- Botón Contraseña (showResetForm) -->
					<a class="btn btn-warning btn-xs" href="{{ URL::to('password/reset?id='.$usuario->id) }}" data-tooltip="tooltip" title="Cambiar Contraseña">
						<i class="fas fa-key" aria-hidden="true"></i>
					</a>

					<!-- Botón Editar (edit) -->
					<a class="btn btn-info btn-xs" href="{{ URL::to('auth/usuarios/'.$usuario->id.'/edit') }}" data-tooltip="tooltip" title="Editar">
						<i class="fas fa-edit" aria-hidden="true"></i>
					</a>

	                <!-- carga botón de borrar -->
	                {{ Form::button('<i class="fas fa-user-times" aria-hidden="true"></i>',[
	                    'class'=>'btn btn-xs btn-danger btn-delete',
	                    'data-toggle'=>'modal',
						'data-class' =>'danger',
						'name'=>'delete',
						'data-id'=>$usuario->id,
	                    'data-model'=> 'Usuario',
	                    'data-descripcion'=> $usuario->username,
						'data-method' => 'DELETE',
	                    'data-action'=>'usuarios/'.$usuario->id,
	                    'data-target'=>'#pregModalAction',
	                    'data-tooltip'=>'tooltip',
	                    'data-title'  =>'Borrar',
	                ])}}
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	@include('widgets.modals.modal-withAction')
@endsection