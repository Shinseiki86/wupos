@extends('layout')
@section('title', '/ Upload File')

@section('content')

<div class="container">
	<h2 class="page-header">Subir Archivo</h2>

	
<div class="row">
<div class="col-xs-12 col-lg-4">
	{{ Form::open( [ 'url'=>'upload', 'class'=>'form-vertical', 'files'=>true ]) }}

		<div class="form-group">
			{{ Form::label('archivo', 'Archivo') }}
			{{ Form::file('archivo', [ 'class' => 'form-control', 'required' ]) }}
		</div>
		<!-- Botones -->
		<div class="text-right">
			<a class='btn btn-info' role='button' href="{{ asset('templates/TemplateCargaDatosAcademusoft.xlsx') }}" download>
				<i class="fa fa-download" aria-hidden="true"></i> Descargar plantilla
			</a>
			<a class="btn btn-primary" role="button" href="{{ URL::to('encuestas') }}">
				<i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar
			</a>
			{{ Form::button('<i class="fa fa-save" aria-hidden="true"></i> Cargar', [ 'class'=>'btn btn-primary', 'type'=>'submit' ]) }}
		</div>

	{{ Form::close() }}

	<br><br>
	@include('partials/errors')
</div>
<div class="col-xs-12 col-lg-8">
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
	@foreach($collections as $collect)
		@if(!$collect->isEmpty())
		<?php $nameModel = class_basename($collect->first()); ?>
		<li role="presentation"><a href="#{{$nameModel}}" aria-controls="{{$nameModel}}" role="tab" data-toggle="tab">{{ucwords($nameModel)}}</a></li>
		@endif
	@endforeach
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
	@foreach($collections as $collect)
		@if(!$collect->isEmpty())
		<?php $nameModel = class_basename($collect->first()); ?>
		<div role="tabpanel" class="tab-pane" id="{{$nameModel}}">
			<!-- botón de eliminar registros -->
			{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i> Vaciar <span class="hidden-xs">Tabla</span>',[
					'class'=>'btn btn-danger',
					'data-toggle'=>'modal',
					'data-modelo'=> $nameModel,
					'data-descripcion'=>'todos los registros',
					'data-action'=>'eliminarRegistros',
					'data-target'=>'#pregModalDelete',
				])
			}}
			<table id={{$nameModel}} class="table table-striped">
				<thead>
					<tr>
					@foreach(array_keys($collect->first()->toArray()) as $column)
						<th>{{$column}}</th>
					@endforeach
					</tr>
				</thead>
				<tfoot>
				</tfoot>
				<tbody>
				@foreach($collect as $model)
					<tr>
						@foreach($model->getAttributes() as $attr)
						<td>{{$attr}}</td>
						@endforeach
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
		@endif
	@endforeach
	</div>
</div>

</div>

<br>
@include('partials/datatable') <!-- Script para tablas -->	
@include('upload/modalDelete') <!-- incluye el modal del Delete -->	
@endsection