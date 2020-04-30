@extends('layouts.menu')
@section('title', '/ '.$strTitulo.'s')

@section('page_heading')
	<div class="row">
		<div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
			{{$strTitulo.'s'}}
		</div>
		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
			<a class='btn btn-primary' role='button' href="{{ route('encuestas.create') }}" data-tooltip="tooltip" title="Crear {{ $strTitulo }}" name="create">
				<i class="fas fa-plus" aria-hidden="true"></i>
			</a>
		</div>
	</div>
@endsection

@section('section')

	<table class="table table-striped" id="tabla">
		<thead>
			<tr>
				<th class="col-md-1">ID</th>
				<th class="col-md-4">Título</th>
				@if( Entrust::ability( ['admin','editor'], null ) and $strTitulo=='Encuesta' )
				<th class="col-md-1">Estado</th>
				@endif
				@if( Entrust::hasRole('admin') or $strTitulo=='Plantilla' )
				<th class="col-md-1">Autor</th>
				@endif

				<th class="col-md-1">Dirigida a</th>

				<th class="col-md-1">Creado</th>
				@if( $strTitulo=='Encuesta' )
				<th class="col-md-1">Publicada</th>
				<th class="col-md-1">Vigencia</th>
				@endif
				<th class="col-md-1">Modificado</th>
				<th class="col-md-1 all notOrder notFilter"></th>
			</tr>
		</thead>

		<tbody>

			@foreach($encuestas as $enc)
			<tr>
				<td>{{ $enc->ENCU_ID }}</td>
				<td>{{ $enc->ENCU_TITULO }}</td>
				@if(Entrust::ability( ['admin','editor'], null ) and $strTitulo=='Encuesta' )
				<td>{{ $enc->estado->ENES_DESCRIPCION }}</td>
				@endif
				@if( Entrust::hasRole('admin') or $strTitulo=='Plantilla' )
				<td>{{ $enc->ENCU_CREADOPOR }}</td>
				@endif

				<td>
				@foreach($enc->dirigidaA as $rol)
					<span class="label label-info">{{ $rol->display_name }}</span>
				@endforeach
				</td>

				<td>{{ datetime($enc->ENCU_FECHACREADO, true) }}</td>
				@if( $strTitulo=='Encuesta' )
				<td>{{ datetime($enc->ENCU_FECHAPUBLICACION, true) }}</td>
				<td>{{ datetime($enc->ENCU_FECHAVIGENCIA, true) }}</td>
				@endif
				<td>{{ datetime($enc->ENCU_FECHAMODIFICADO, true) }}</td>
				<td>
				@if ( Entrust::ability( ['admin','editor'], null ))
					<!-- carga botón de Ver -->
					<a class="btn btn-small btn-success btn-xs" href="{{ route('encuestas.show', ['ENCU_ID' => $enc->ENCU_ID]) }}" data-tooltip="tooltip" title="Ver">
						<span class="glyphicon glyphicon-eye-open"></span>
					</a>
					
					<!-- carga botón de duplicar fa-clone -->
					{{ Form::button('<i class="fas fa-copy" aria-hidden="true"></i>',[
						'name'        => 'btn-cloneEncu',
						'class'       => 'btn btn-xs btn-warning btn-clone',
						'data-toggle' => 'modal',
						'data-id'     => $enc->ENCU_ID,
						'data-descripcion'=> $enc->ENCU_TITULO,
						'data-action' => route('encuestas.clone', ['ENCU_ID'=>$enc->ENCU_ID]),
						'data-target' => '#pregModalClone',
						'data-tooltip'=> 'tooltip',
						'title'       => 'Clonar',
					])}}

					<!-- carga botón de reporte -->
					@if( $strTitulo == 'Encuesta' )
					<a class="btn btn-small btn-info btn-xs" href="{{ route('encuestas.reportes.loading', ['ENCU_ID'=>$enc->ENCU_ID]) }}" data-tooltip="tooltip" title="Reportes">
						<i class="fas fa-chart-line" aria-hidden="true"></i>
					</a>
					@endif

					<!-- carga botón de borrar -->
					{{ Form::button('<i class="fas fa-trash" aria-hidden="true"></i>',[
						'class'       => 'btn btn-xs btn-danger btn-delete',
						'data-toggle' => 'modal',
						'data-id'     => $enc->ENCU_ID,
						'data-modelo' => 'Encuesta',
						'data-descripcion'=> $enc->ENCU_TITULO,
						'data-action' => 'encuestas/'.$enc->ENCU_ID,
						'data-target' => '#pregModalDelete',
						'data-tooltip'=> 'tooltip',
						'title'       => 'Borrar',
					])}}

				@else {{-- rol estudiante, docente y demás --}}
					<!-- carga botón de responder -->
					<a class="btn btn-xs btn-info" href="{{ route('resps.index', ['ENCU_ID' => $enc->ENCU_ID]) }}" data-tooltip="tooltip" title="Responder">
						<i class="fas fa-edit" aria-hidden="true"></i> Responder
					</a> 
				@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	@rinclude('index-modalClone')
	@include('widgets.modals.modal-delete')
	@include('widgets.datatable.datatable-export')
@endsection
