@extends('layout')
@section('title', '/ Agencia '.$agencia->AGEN_id)

@section('content')

	<h1 class="page-header">Agencia {{ $agencia->AGEN_id }}:</h1>

	<div class="jumbotron text-center">
		<p>

			<li class="list-group-item">
				<div class="row">
					<div class="col-lg-4"><strong>Nombre:</strong></div>
					<div class="col-lg-8">{{ $agencia -> AGEN_nombre }}</div>
				</div>
			</li>

			<ul class="list-group">

				<li class="list-group-item">
					<div class="row">
						<div class="col-lg-4"><strong>Descripción:</strong></div>
						<div class="col-lg-8">{{ $agencia -> AGEN_cuentawu }}</div>
					</div>
				</li>

				<li class="list-group-item">
					<div class="row">
						<div class="col-lg-4"><strong>Regional:</strong></div>
						<div class="col-lg-8">{{ $agencia -> regional ? $agencia -> regional -> REGI_nombre : '' }}</div>
					</div>
				</li>

			</ul>
		</p>
		<div class="text-right">
			<a class="btn btn-primary" role="button" href="{{ URL::to('agencias/') }}">
				<i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar
			</a>
		</div>
	</div>

@endsection