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
				<div class="panel panel-default">
					<div class="panel-body">
						@if (session('status'))
							<div class="alert alert-success">
								{{ session('status') }}
							</div>
						@endif

						{{ Form::open(['url'=>'password/reset', 'class' => 'form-horizontal']) }}

							<input type="hidden" name="token" value="{{ $token }}">

							@include('widgets.forms.input', ['type'=>'email', 'name'=>'email', 'value'=>$email, 'label'=>'E-Mail', 'options'=>['readonly'] ])

							@include('widgets.forms.input', ['type'=>'password', 'name'=>'password', 'label'=>'Nueva Contraseña' ])
							@include('widgets.forms.input', ['type'=>'password', 'name'=>'password_confirmation', 'label'=>'Confirmar Contraseña' ])

							<div class="form-group">
								<div class="col-xs-8 col-xs-offset-4 text-right">
									<a class="btn btn-warning" role="button" href="{{ URL::previous() }}" data-tooltip="tooltip" title="Regresar">
										<i class="fas fa-arrow-left" aria-hidden="true"></i>
									</a>
									<button type="submit" class="btn btn-primary">
										<i class="fas fa-refresh"></i> Cambiar Contraseña
									</button>
								</div>
							</div>
						{{ Form::close() }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
