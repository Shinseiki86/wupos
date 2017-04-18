@extends('layout')
@section('title', '/ Regionales')

@section('content')

	<h1 class="page-header">Regionales</h1>
	<div class="row well well-sm">

		<div id="btn-create" class="pull-right">
			<a class='btn btn-primary' role='button' href="{{ URL::to('regionales/create') }}">
				<i class="fa fa-plus" aria-hidden="true"></i> Nueva Regional
			</a>
		</div>
	</div>
	
<table class="table table-striped">
	<thead>
		<tr>
			<th class="col-md-2">ID</th>
			<th class="col-md-2">Código</th>
			<th class="col-md-2">Nombre</th>
			<th class="col-md-2">Agencias</th>
			<th class="col-md-2">Acciones</th>
		</tr>
	</thead>
	<tbody>


		@foreach($regionales as $regional)
		<tr>
			<td>{{ $regional -> REGI_id }}</td>
			<td>{{ $regional -> REGI_codigo }}</td>
			<td>{{ $regional -> REGI_nombre }}</td>
			<td>{{ $regional->agencias()->where('AGEN_activa', true)->where('AGENCIAS.AGEN_cuentawu', '!=', null)->groupBy('REGI_id')->count() }}</td>
			<td>
				<!-- Botón Ver (show) -->
				<a class="btn btn-small btn-success btn-xs" href="{{ URL::to('regionales/'.$regional->REGI_id) }}">
					<span class="glyphicon glyphicon-eye-open"></span> Ver
				</a><!-- Fin Botón Ver (show) -->

				<!-- Botón Editar (edit) -->
				<a class="btn btn-small btn-info btn-xs" href="{{ URL::to('regionales/'.$regional->REGI_id.'/edit') }}">
					<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar
				</a><!-- Fin Botón Editar (edit) -->

				<!-- Botón Borrar (destroy) -->
				{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i> Borrar',[
						'class'=>'btn btn-xs btn-danger',
						'data-toggle'=>'modal',
						'data-target'=>'#pregModal'.$regional -> REGI_id ])
						}}

				<!-- Mensaje Modal. Bloquea la pantalla mientras se procesa la solicitud -->
				<div class="modal fade" id="pregModal{{ $regional -> REGI_id }}" role="dialog" tabindex="-1" >
					<div class="modal-dialog">
						<div class="modal-content panel-danger">
							<div class="modal-header panel-heading" style="border-top-left-radius: inherit; border-top-right-radius: inherit;">
								<h4 class="modal-title">¿Borrar?</h4>
							</div>
							<div class="modal-body">
								<p>
									<i class="fa fa-exclamation-triangle"></i> ¿Desea borrar el registro {{ $regional -> REGI_id }}?
								</p>
							</div>
							<div class="modal-footer">
									{{ Form::open(array('url' => 'regionales/'.$regional->REGI_id, 'class' => 'pull-right')) }}
										{{ Form::hidden('_method', 'DELETE') }}
										{{ Form::button(' NO ', ['class'=>'btn btn-xs btn-success', 'type'=>'button','data-dismiss'=>'modal']) }}
										{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i> SI',[
											'class'=>'btn btn-xs btn-danger',
											'type'=>'submit',
											'data-toggle'=>'modal',
											'data-backdrop'=>'static',
											'data-target'=>'#msgModal',
										]) }}
									{{ Form::close() }}
							</div>
				  		</div>
					</div>
				</div><!-- Fin Botón Borrar (destroy) -->

			</td>
		</tr>
		@endforeach
	</tbody>
</table>


@endsection