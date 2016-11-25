<!DOCTYPE html>
<html>
	<head>
		<title>Wupos @yield('title')</title>
		{!! Html::meta( null, 'IE=edge', [ 'http-equiv'=>'X-UA-Compatible' ] ) !!}
		{!! Html::meta( null, 'text/html; charset=utf-8', [ 'http-equiv'=>'Content-Type' ] ) !!}
		{!! Html::meta( 'viewport', 'width=device-width, initial-scale=1') !!}

		{!! Html::favicon('favicon.ico') !!}

		{!! Html::style('assets/js/jquery-ui/jquery-ui.min.css') !!}
		{!! Html::style('assets/css/bootstrap.min.css') !!}
		{!! Html::style('assets/css/font-awesome.min.css') !!}
		{!! Html::style('assets/css/bootstrap-theme.min.css') !!}
		{!! Html::style('assets/css/style.css') !!}
		
		@yield('head')
		

		<!-- Fonts -->
		{{-- <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'> --}}
	</head>
	<body>

		@include('partials/menu')

		<div class="container" style="padding-left:10px;padding-right:10px;">

			@include('partials/messages')

			<!-- Contenido cargado desde el blade -->
			@yield('content')
		</div>

		<!-- Scripts -->
		{!! Html::script('assets/js/jquery-1.11.2.min.js') !!}
		{!! Html::script('assets/js/jquery-ui/jquery-ui.min.js') !!}
		{!! Html::script('assets/js/bootstrap.min.js') !!}
		@yield('scripts')
	</body>
</html>