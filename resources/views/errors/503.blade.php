@extends('layouts.error')

@section('page_heading','Error 503: Service Unavailable.')
@section('section')
	<div class="title">
		El servidor no puede responder a la petición del navegador porque está congestionado o está realizando tareas de mantenimiento.
	</div>
	{{ isset($errorMsg) ? dump($errorMsg) : '' }}
@endsection