@extends('layouts.menu')
@section('page_heading', 'Editar Item del Menú')

@section('section')
{{ Form::model($menu, ['action' => ['App\MenuController@update', $menu->MENU_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'app/menu'])

{{ Form::close() }}
@endsection