@extends('layouts.menu')
@section('title', '/ Menú')
@rinclude('nestable')

@section('page_heading')
	<div class="row">
		<div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
			Menú
		</div>
		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
			<a class='btn btn-primary' role='button' href="{{ URL::to('app/menu/create') }}" data-tooltip="tooltip" title="Crear Nuevo" name="create">
				<i class="fas fa-plus" aria-hidden="true"></i>
			</a>
		</div>
	</div>
@endsection

@section('section')

	<div class=" col-xs-12 col-md-6">
		<h4>Menú superior</h4>
		<div class="dd" data-position="TOP">
			<ol class="dd-list">
				@if(isset($menusEditTop))
				@foreach ($menusEditTop as $key => $item)
						@if ($item['MENU_PARENT'] != 0)
							@break
						@endif
						@include('app.menu.menu-list', ['item' => $item])
				@endforeach
				@endif
				<li class="dd-item dd3-item">{{-- Requerido para no perder el dom al quedar vacío --}}</li>
			</ol>
		</div>
	</div>

	<div class=" col-xs-12 col-md-6">
		<h4>Menú lateral</h4>
		<div class="dd" data-position="LEFT">
			<ol class="dd-list">
				@if(isset($menusEditLeft))
				@foreach ($menusEditLeft as $key => $item)
						@if ($item['MENU_PARENT'] != 0)
							@break
						@endif
						@include('app.menu.menu-list', ['item' => $item])
				@endforeach
				@endif
				<li class="dd-item dd3-item">{{-- Requerido para no perder el dom al quedar vacío --}}</li>
			</ol>
		</div>
	</div>

	@include('widgets.modals.modal-delete')
@endsection