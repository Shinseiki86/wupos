@extends ('layouts.plane')

@push('head')
<style type="text/css">
	html, body {height: 100%;}
	.container { 
		background: url('{{ get_logo() }}') no-repeat fixed right bottom;
		height: 100%;
		width: 100%;
		display: table;
	}
	.panel { 
		background: rgba(255, 255, 255, 0.8);
	}
	.panelRow {
		display: table-cell;
		height: 100%;
		vertical-align: middle;
	}
</style>
@endpush

@section('body')
	@include('layouts.menu.menu-top')

	<div class="container">
		<div class="row panelRow">
			<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
				@section ('login_panel_body')<br>
					{{ Form::open( [ 'url'=>'login' , 'role'=>'form', 'class'=>'form-vertical' ] ) }}
						<fieldset>
							<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-user"></i></span>
									<input id="username" placeholder="Usuario" type="text" class="form-control" name="username" value="{{ old('username') }}" autofocus>
								</div>
								@if ($errors->has('username'))
									<span class="help-block">
										<strong>{{ $errors->first('username') }}</strong>
									</span>
								@endif
							</div>

							<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-key"></i></span>
									<input id="password" placeholder="Contraseña" name="password" type="password" class="form-control" autocomplete="off" maxlength="30">
								</div>
								@if ($errors->has('password'))
									<span class="help-block">
										<strong>{{ $errors->first('password') }}</strong>
									</span>
								@endif
							</div>

							<div class="">
								<div class="col-md-offset-1">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="remember"> Recordarme
										</label>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-xs-4 col-xs-offset-1">
										<button type="submit" class="btn btn-primary" name="login">
											<i class="fas fa-sign-in"></i> Iniciar sesión
										</button>
									</div>
									<div class="col-xs-3">
										<a class="btn btn-link" href="{{ url('/password/reset') }}">
											¿Olvidó su contraseña?
										</a>
									</div>
								</div>
							</div>
						</fieldset>
					{{ Form::close() }}
				@endsection
				@include('widgets.panel', array('as'=>'login'))
			</div>
		</div>
	</div>
@endsection