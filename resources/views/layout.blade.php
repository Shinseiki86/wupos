<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Wupos @yield('title')</title>
		{!! Html::favicon('favicon.ico') !!}

		<!-- Estilos -->
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