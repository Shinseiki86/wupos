@extends('layouts.plane')

@section('body')
	<!--div id="pageLoading">Cargando...</div-->

	@include('layouts.menu.menu-top')

	<div id="wrapper">

		@include('layouts.menu.menu-left')

		<div id="page-wrapper">

			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">@yield('page_heading', 'Bienvenido!')</h1>
				</div>
			</div>

			<div class="row">
				@yield('section', '')
			</div>
			
		</div><!-- /#page-wrapper -->

	</div><!-- /.wrapper -->

@endsection