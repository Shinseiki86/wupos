@extends('layout')
@section('scripts')
    <script>
    </script>
@parent
@endsection

@section('content')
<h1 class="page-header">Inicio</h1>
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Wupos</div>

				<div class="panel-body">
					¡Bienvenido!<br>
					<canvas id="cbar" width="350" height="220"></canvas>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
