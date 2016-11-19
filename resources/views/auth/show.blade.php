@extends('layout')
@section('title', '/ '.$usuario->username )

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading"><strong>{{ $usuario->username }}</strong></div>
				<div class="panel-body">
					<form  class="form-vertical">
						<div class="form-group">
							{{ Form::label('name', 'Nombre', [ 'class' => 'col-md-4 control-label' ]) }}
							<div class="col-md-6">
								<p class="form-control-static">{{ $usuario->name }}</p>
							</div>
						</div>

						<div class="form-group">
							{{ Form::label('username', 'Usuario', [ 'class' => 'col-md-4 control-label' ]) }}
							<div class="col-md-6">
								<p class="form-control-static">{{ $usuario->username }}</p>
							</div>
						</div>


						<div class="form-group">
							{{ Form::label('email', 'E-mail', [ 'class' => 'col-md-4 control-label' ]) }}
							<div class="col-md-6">
								<p class="form-control-static">{{ $usuario->email }}</p>
							</div>
						</div>

						<div class="form-group">
							{{ Form::label('role', 'Rol', [ 'class' => 'col-md-4 control-label' ]) }}
							<div class="col-md-6">
								<p class="form-control-static">{{ $usuario->rol->ROLE_descripcion }}</p>
							</div>
						</div>

						<div class="form-group">
							{{ Form::label('USER_creadopor', 'Creado por', [ 'class' => 'col-md-4 control-label' ]) }}
							<div class="col-md-6">
								<p class="form-control-static">{{ $usuario->USER_creadopor }}</p>
							</div>
						</div>

						<div class="form-group">
							{{ Form::label('USER_fechacreado', 'Creado el', [ 'class' => 'col-md-4 control-label' ]) }}
							<div class="col-md-6">
								<p class="form-control-static">{{ $usuario->USER_fechacreado }}</p>
							</div>
						</div>

						<!-- Botones -->
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4 text-right">
							
								<br>
								<a class="btn btn-warning" role="button" href="{{ URL::to('usuarios/') }}">
									<i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar
								</a>

							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
