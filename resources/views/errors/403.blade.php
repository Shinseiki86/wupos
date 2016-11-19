

@extends('layout')
@section('title', '/ Error')

@section('head')
	<!-- <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css"> -->
	<style>
		.title {
			margin: 0;
			padding: 0;
			width: 100%;
			color: #000000;
			display: table;
			height: 100%;
			text-align: center;
			display: table-cell;
			vertical-align: middle;
			text-align: center;
			display: inline-block;
			font-size: 72px;
			margin-bottom: 40px;
			font-weight: 100;
			font-family: 'Lato';
		}
	</style>
@endsection

@section('content')
	<div class="title">
		<strong>Error 403: Forbidden.</strong><br>
		El usuario no tiene permisos para acceder al recurso.
	</div>
@endsection