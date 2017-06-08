
<!-- Filtrar datos en vista -->
<a class='btn btn-primary' role='button' data-toggle="collapse" data-target="#filters" href="#" data-tooltip="tooltip" title="Filtrar resultados">
	<i class="fa fa-filter" aria-hidden="true"></i>
</a>

@if(in_array(auth()->user()->rol->ROLE_rol , ['admin']))
	@if(!$papelera)
	<a class='btn btn-primary' role='button' href="{{ URL::to('operadores/create') }}">
		<i class="fa fa-plus" aria-hidden="true"></i> Nuevo
	</a>
	<!-- botón de importar usuarios -->
	{{ Form::button('<i class="fa fa-file-excel-o" aria-hidden="true"></i>',[
		'class'=>'btn btn-primary',
		'data-toggle'=>'modal',
		'data-target'=>'#pregModalImport',
		'data-tooltip'=>'tooltip',
		'title'=>'Importar operadores desde Excel',
	])}}
	<a class='btn btn-warning' role='button' href="{{ URL::to('operadores-borrados') }}">
		<i class="fa fa-trash-o" aria-hidden="true"></i> Papelera
	</a>
	<!-- botón de exportar -->
	<div class="btn-group">
		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fa fa-download" aria-hidden="true"></i> Pendientes <span class="caret"></span>
		</button>
		<ul class="dropdown-menu">
			<li><a href="{{ URL::to('operadores/export/'.\Wupos\EstadoOperador::PEND_CREAR) }}">Por crear</a></li>
			<li><a href="{{ URL::to('operadores/export/'.\Wupos\EstadoOperador::PEND_ELIMINAR) }}">Por eliminar</a></li>
		</ul>
	</div>
	@else
	<!-- botón de vaciar papelera -->
	{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i> Vaciar <span class="hidden-xs">Papelera</span>',[
		'class'=>'btn btn-danger',
		'data-toggle'=>'modal',
		'data-id'=>'{% papelera %}',
		'data-descripcion'=>'registros en la papelera',
		'data-action'=>'operadores-borrados/vaciarPapelera',
		'data-target'=>'#pregModalDelete',
	])}}
	@endif
@endif
