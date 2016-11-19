@extends('layout')
@section('title', '/ Nuevo usuario' )

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Crear nuevo usuario</div>
				<div class="panel-body">
				
					@include('partials/errors')

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
						{{ csrf_field() }}

						<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
							<label for="name" class="col-md-4 control-label">Nombre</label>

							<div class="col-md-6">
								<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

								@if ($errors->has('name'))
									<span class="help-block">
										<strong>{{ $errors->first('name') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
							<label for="username" class="col-md-4 control-label">Usuario</label>

							<div class="col-md-6">
								<input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}">

								@if ($errors->has('username'))
									<span class="help-block">
										<strong>{{ $errors->first('username') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							<label for="email" class="col-md-4 control-label">E-Mail</label>

							<div class="col-md-6">
								<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

								@if ($errors->has('email'))
									<span class="help-block">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('ROLE_id') ? ' has-error' : '' }}">
							<label for="ROLE_id" class="col-md-4 control-label">Rol</label>

							<div class="col-md-6">
								<select class="form-control" id="ROLE_id" name="ROLE_id" class="form-control" required>
									<option value="">Seleccione un rol...</option>
									@foreach($roles as $rol)
									<option value="{{ $rol->ROLE_id }}">
										{{ $rol->ROLE_descripcion }}
									</option>
									@endforeach
								</select>

								@if ($errors->has('ROLE_id'))
									<span class="help-block">
										<strong>{{ $errors->first('ROLE_id') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
							<label for="password" class="col-md-4 control-label">Password</label>

							<div class="col-md-6">
								<input id="password" type="password" class="form-control" name="password">

								@if ($errors->has('password'))
									<span class="help-block">
										<strong>{{ $errors->first('password') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
							<label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

							<div class="col-md-6">
								<input id="password-confirm" type="password" class="form-control" name="password_confirmation">

								@if ($errors->has('password_confirmation'))
									<span class="help-block">
										<strong>{{ $errors->first('password_confirmation') }}</strong>
									</span>
								@endif
							</div>
						</div>


						<!-- Botones -->
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4 text-right">

						    	{{ Form::button('<i class="fa fa-exclamation" aria-hidden="true"></i> Reset', array('class'=>'btn btn-warning', 'type'=>'reset')) }}

						        <a class="btn btn-warning" role="button" href="{{ URL::to('usuarios/') }}">
						            <i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar
						        </a>

								{{ Form::button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', array('class'=>'btn btn-primary', 'type'=>'submit')) }}

							</div>
						</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
