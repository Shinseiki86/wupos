@extends('layouts.error')

@section('page_heading','Error 500: Internal Server Error.')
@section('section')
	<div class="title">
		Se ha presentado un error en la página. Por favor contacte con el administrador.
	</div>
	{{ isset($errorMsg) ? dump($errorMsg) : '' }}
@endsection