@extends('errors/error')
@section('content')
	<div class="title">
		<strong>Error 500: Internal Server Error.</strong><br>
		Se ha presentado un error en la página. Por favor contacte con el administrador.
		{{ isset($errorMsg) ? dd($errorMsg) : '' }}
	</div>
@endsection