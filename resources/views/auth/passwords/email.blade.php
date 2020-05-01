@extends ('layouts.menu')

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
			<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
				@section ('login_panel_title','¿Olvidó su contraseña?')
				@section ('login_panel_body')
						@if (session('status'))
							<div class="alert alert-success">
								{{ session('status') }}
							</div>
						@endif

						{{ Form::open(['url'=>'password/email', 'class' => 'form-horizontal']) }}
							@include('widgets.forms.input', ['type'=>'email', 'name'=>'email', 'label'=>'Correo Electrónico (E-Mail)'])
							@include('widgets.forms.buttons', ['icon'=>'envelope', 'text'=>'Enviar enlace al correo'])
						{{ Form::close() }}
				@endsection
				@include('widgets.panel', array('as'=>'login', 'header'=>true))
			</div>
		</div>
	</div>
@endsection
