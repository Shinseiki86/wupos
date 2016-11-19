@extends('layout')
@section('title', '/ Menú' )

@section('content')

	<!-- Menú -->
	<nav role="navigation" class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-header">
			<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="{{ URL::to('home') }}" class="pull-left">
				<img src="{{ '/Wupos/public/assets/img/logo.png' }}" height="44">
			</a>
		</div>
		<div class="container-fluid">

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div id="navbarCollapse" class="collapse navbar-collapse">
			{!! $items = Menu::$items !!}	
			@foreach ($items as $item)
				<li class="nav navbar-nav" id="menu_{{ $item['id'] }}">
					@if (empty($item['submenu']))
						<a href="{{ $item['url'] }}">
							{{ $item['title'] }}
						</a>
					@else
						<a href="{{ $item['url'] }}" class="dropdown-toggle" data-toggle="dropdown">
							{{ $item['title'] }}
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							@foreach ($item['submenu'] as $subitem)
								<li>
									<a href="{{ $subitem['url'] }}">{{ $subitem['title'] }}</a>
								</li>
							@endforeach
						</ul>
					@endif
				</li>
			@endforeach




				<!-- Right Side Of Navbar -->
				<ul class="nav navbar-nav navbar-right">
					<!-- Authentication Links -->
					@if (Auth::guest())
						<li><a href="{{ url('/login') }}"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a></li>
						<!-- <li><a href="{ url('/register') }}">Register</a></li> -->
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
								<i class="fa fa-user" aria-hidden="true"></i> {{ Auth::user()->name }} ({{ Auth::user()->rol->ROLE_descripcion }})
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/profile') }}"><i class="fa fa-btn fa-key"></i> Editar</a></li>
								<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i> Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>


			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
	<!-- Fin Menú -->

@endsection