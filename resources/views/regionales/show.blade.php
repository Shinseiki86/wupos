@extends('layout')
@section('title', '/ Regional '.$regional->REGI_id)

@section('content')

	<h1 class="page-header">Regional {{ $regional->REGI_id }}:</h1>

	<div class="jumbotron text-center">
		<p>
			<strong>Tipo :</strong> {{ $regional->REGI_descripcion }} <br>
		</p>
	</div>
	<div class="text-right">
		<a class="btn btn-primary" role="button" href="{{ URL::to('regionales/') }}">
			<i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar
		</a>
	</div>

@endsection