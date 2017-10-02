@extends('layout')

@section('head')
<style type="text/css">
	html, body {height: 100%;}
	.panel { 
		background: rgba(255, 255, 255, 0.91);
	}
	.container {
		margin-top: 0px !important;
		height: 100%;
		width: 100%;
		display: table;
	}
	.row {
		display: table-cell;
		height: 100%;
		vertical-align: middle;
	}
	.banner-info {
		position: fixed;
		top: 60px;
	}
</style>
@parent
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-body">
					{{ Form::open( [ 'url'=>'login' , 'role'=>'form', 'class'=>'form-vertical' ] ) }}
					<fieldset>
						<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
							<label for="username" class="control-label">Usuario</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
								<input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" autofocus>
							</div>
							@if ($errors->has('username'))
								<span class="help-block">
									<strong>{{ $errors->first('username') }}</strong>
								</span>
							@endif
						</div>

						<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
							<label for="password" class="control-label">Contraseña</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
								<input id="password" name="password" type="password" class="form-control" autocomplete="off" maxlength="30">
							</div>
							@if ($errors->has('password'))
								<span class="help-block">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
							@endif
						</div>

						<div class="form-group">
							<div class="col-md-offset-1">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember"> Recordarme
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-offset-1">
								<button type="submit" class="btn btn-primary">
									<i class="fa fa-sign-in"></i> Iniciar sesión
								</button>

								<a class="btn btn-link" href="{{ url('/password/reset') }}">¿Olvidó su contraseña?</a>
							</div>
						</div>
					</fieldset>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
