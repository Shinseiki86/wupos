<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="es" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" >
<html lang="{{ app()->getLocale() }}" class="no-js">
<!--<![endif]-->
	<head>
		<title>{{config('app.name','MyApp')}} @yield('title')</title>
		{!! Html::meta( null, 'IE=edge', [ 'http-equiv'=>'X-UA-Compatible' ] ) !!}
		{!! Html::meta( null, 'text/html; charset=utf-8', [ 'http-equiv'=>'Content-Type' ] ) !!}

		{!! Html::meta( 'viewport', 'width=device-width, initial-scale=1') !!}
		<meta content="" name="description"/>
		<meta content="" name="author"/>

		{!! Html::style('css/bootstrap/bootstrap.min.css') !!}
		{!! Html::style('css/bootstrap/bootstrap-theme.min.css') !!}
		{!! Html::style('css/bootstrap/bootstrap-navbar-custom.css') !!}
		{!! Html::style('css/font-awesome/fontawesome.min.css') !!}
		{!! Html::style('css/font-awesome/solid.min.css') !!}
		{!! Html::style('css/font-awesome/brands.min.css') !!}
		{!! Html::style('css/metisMenu.min.css') !!}
		{!! Html::style('css/pace-theme-flash.css') !!}
		{!! Html::script('js/pace.min.js') !!}
		{!! Html::style('css/sb-admin-2.css') !!}
		{!! Html::style('css/dropdown-menu.css') !!}
		{!! Html::style('css/toastr.min.css') !!}

		@stack('head')
	</head>

	<body class="sidebar-closed">

		@include('widgets.flash-alert')
		
		@yield('body')

		{!! Html::script('js/jquery/jquery.min.js') !!}
		{!! Html::script('js/bootstrap/bootstrap.min.js') !!}
		{!! Html::script('js/metisMenu.min.js') !!}
		{!! Html::script('js/sb-admin-2.js') !!}
		{!! Html::script('js/toastr.min.js') !!}
		<script type="text/javascript">
			$(function () {
				//Si el formulario presenta error, realizará focus al primer elemento con error.
				@if(isset($errors))
					$('#{{current($errors->keys())}}').focus();
				@endif

				//Configuración Toast
				toastr.options.closeMethod = 'fadeOut';
				toastr.options.closeDuration = 2000;
				toastr.options.closeEasing = 'swing';
				toastr.options.progressBar = true;
				toastr.options.positionClass = 'toast-top-left';

				//Activa los tooltip de Boostrap
				tooltips = $('[data-tooltip="tooltip"]');
				if(tooltips.length > 0)
					tooltips.tooltip();
			});
		</script>
		@stack('scripts')

		@stack('modals')
		@include('widgets.modals.modal-loading')

		<footer class="footer {{ config('app.debug') ? 'navbar-custom2' : 'navbar-custom1'}} navbar-fixed-bottom">
			<div class="text-right" style="color: #b9b9b9;padding-right:20px;">
				<small>{{ config('app.name', 'MyApp') }}&copy; powered by <i>Shinseiki86</i>></small>
			</div>
		</footer>
	</body>
</html>