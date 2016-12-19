@extends('layout')
@section('title', '/ Agencias')

@section('content')

	<h1 class="page-header">Agencias</h1>
	<div class="row well well-sm">

		<div id="btn-create" class="pull-right">
			<a class='btn btn-primary' role='button' href="{{ URL::to('agencias/create') }}">
				<i class="fa fa-plus" aria-hidden="true"></i> Nueva Agencia
			</a>
		</div>
	</div>
	
<table class="table table-striped">
	<thead>
		<tr>
			{{--<th>ID</th>--}}
			<th>Código</th>
			<th>Nombre</th>
			<th>Regional</th>
			<th>Cuenta WU</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>


		@foreach($agencias as $agencia)
		<tr class="{{ $agencia->AGEN_activa ? '' : 'danger' }}">
			{{--<td style="width:50px;">{{ $agencia -> AGEN_id }}</td>--}}
			<td style="width:100px;">{{ $agencia -> AGEN_codigo }}</td>
			<td>{{ $agencia -> AGEN_nombre }}</td>
			<td>{{ $agencia -> regional -> REGI_nombre }}</td>
			<td style="width:100px;">{{ $agencia -> AGEN_cuentawu }}</td>
			<td>
				<!-- Botón Ver (show) -->
				<a class="btn btn-small btn-success btn-xs" href="{{ URL::to('agencias/'.$agencia->AGEN_id) }}">
					<span class="glyphicon glyphicon-eye-open"></span> Ver
				</a><!-- Fin Botón Ver (show) -->

				<!-- Botón Editar (edit) -->
				<a class="btn btn-small btn-info btn-xs" href="{{ URL::to('agencias/'.$agencia->AGEN_id.'/edit') }}">
					<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar
				</a><!-- Fin Botón Editar (edit) -->

				<!-- Botón Borrar (destroy) -->
				{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i> Borrar',[
						'class'=>'btn btn-xs btn-danger',
						'data-toggle'=>'modal',
						'data-target'=>'#pregModal'.$agencia -> AGEN_id ])
						}}

				<!-- Mensaje Modal. Bloquea la pantalla mientras se procesa la solicitud -->
				<div class="modal fade" id="pregModal{{ $agencia -> AGEN_id }}" role="dialog" tabindex="-1" >
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">¿Borrar?</h4>
							</div>
							<div class="modal-body">
								<p>
									<i class="fa fa-exclamation-triangle"></i> ¿Desea borrar el registro {{ $agencia -> AGEN_id }}?
								</p>
							</div>
							<div class="modal-footer">
									{{ Form::open(array('url' => 'agencias/'.$agencia->AGEN_id, 'class' => 'pull-right')) }}
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