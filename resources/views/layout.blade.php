<!DOCTYPE html>
<html>
	<head>
		<title>Wupos @yield('title')</title>
		{!! Html::meta( null, 'IE=edge', [ 'http-equiv'=>'X-UA-Compatible' ] ) !!}
		{!! Html::meta( null, 'text/html; charset=utf-8', [ 'http-equiv'=>'Content-Type' ] ) !!}
		{!! Html::meta( 'viewport', 'width=device-width, initial-scale=1') !!}

		{!! Html::favicon('favicon.ico') !!}
		
		{{-- Automatic page load progress bar --}}
		{!! Html::script('assets/js/pace/pace.min.js') !!}
		{!! Html::style('assets/js/pace/pace-theme-flash.css') !!}

		{!! Html::style('assets/js/jquery-ui/jquery-ui.min.css') !!}
		{!! Html::style('assets/css/bootstrap.min.css') !!}
		{!! Html::style('assets/css/bootstrap-theme.min.css') !!}
		{!! Html::style('assets/css/font-awesome.min.css') !!}
		{!! Html::style('assets/css/style.css') !!}

		@yield('head')
		
	</head>

	<body>

		@include('partials/menu')

		<div class="container" style="margin-top:60px;padding-left:10px;padding-right:10px;">

			@include('partials/messages')

			<!-- Contenido cargado desde el blade -->
			@yield('content')
		</div>

		<!-- Scripts -->
		{!! Html::script('assets/js/jquery/jquery-1.11.2.min.js') !!}
		{!! Html::script('assets/js/jquery-ui/jquery-ui.min.js') !!}
		{!! Html::script('assets/js/bootstrap/bootstrap.min.js') !!}

		<script type="text/javascript">
			$(function () {
				$('.table>tbody').removeClass('hide');
				$('.table>tfoot').addClass('hide');

				/*var tooltips = $('[data-tooltip="tooltip"]');
				if(tooltips.length > 0)
					tooltips.tooltip();*/
			})
		</script>
		@yield('scripts')

		<footer class="footer {{ !env('APP_DEBUG', false) ? 'navbar-default' : 'navbar-inverse'}} navbar-fixed-bottom">
			<div class="text-right" style="color: #606060;padding-right:20px;">
				<small>Powered by <i>Shinseiki86</i></small>
			</div>
		</footer>
	</body>
</html>