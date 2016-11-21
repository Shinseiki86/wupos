<!-- Menú -->
<nav role="navigation" class="navbar navbar-default">
	<div class="container-fluid">

		<!-- Brand y toggle se agrupan para una mejor visualización en dispositivos móviles -->
		<div class="navbar-header">
			<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
				<span class="sr-only">Menú</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="{{ URL::to('home') }}" class="pull-left">
				<img src="{{ asset('assets/img/LOGO.png') }}" height="50" style="padding-top: 5px;padding-bottom: 5px;">
			</a>
		</div>

		<!-- Recopila los vínculos de navegación, formularios y otros contenidos para cambiar -->
		<div id="navbarCollapse" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">

				@unless (Auth::guest())
					<li ><a href="{{ URL::to('home') }}">
						<i class="fa fa-home" aria-hidden="true"></i> Inicio
					</a></li>

					@if (in_array(Auth::user()->rol->ROLE_rol , ['admin']))<!-- admins -->
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
								<i class="fa fa-cogs" aria-hidden="true"></i> Parametrización
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu">

								<li><a href="{{ url('/regionales') }}"><i class="fa fa-btn fa-university"></i> Regionales</a></li>

								<li><a href="{{ url('/agencias') }}"><i class="fa fa-btn fa-money"></i> Agencias</a></li>
								
								<li role="separator" class="divider"></li>

								<li><a href="{{ url('/usuarios') }}"><i class="fa fa-btn fa-users"></i> Usuarios Locales</a></li>
							</ul>
						</li>
					@endif

					@if (in_array(Auth::user()->rol->ROLE_rol , ['editor','admin']))<!-- editores y admins -->
						<li><a href="{{ url('certificados') }}">
							<i class="fa fa-check-square" aria-hidden="true"></i> Certificados
						</a></li>
					@elseif (in_array(Auth::user()->rol->ROLE_rol , ['user']))<!-- usuarios  -->
						<li><a href="{{ url('certificados') }}">
							<i class="fa fa-list" aria-hidden="true"></i> Certificados
						</a></li>
					@endif
				@endunless
			</ul>

			<!-- Lado derecho del Navbar. -->
			<ul class="nav navbar-nav navbar-right">
				<!-- Ayuda -->
					<li><a href="{{ url('/help') }}">
						<i class="fa fa-life-ring" aria-hidden="true"></i> Ayuda
					</a></li>
				<!-- Autenticación. -->
				@if (Auth::guest())
					<li><a href="{{ url('/login') }}">
						<i class="fa fa-sign-in" aria-hidden="true"></i> Login
					</a></li>
				@else
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							<i class="fa fa-user" aria-hidden="true"></i> {{ Auth::user()->username }} ({{ Auth::user()->rol->ROLE_rol }})
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							<li>
								<a href="{{ url('/logout') }}">
									<i class="fa fa-btn fa-sign-out"></i> Logout
								</a>
							</li>
						</ul>
					</li>
				@endif
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
<!-- Fin Menú -->

