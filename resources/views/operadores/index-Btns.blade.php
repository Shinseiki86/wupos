
<!-- Filtrar datos en vista -->
<a class='btn btn-primary' role='button' data-toggle="collapse" data-target="#filters" href="#" data-tooltip="tooltip" title="Filtrar resultados">
	<i class="fa fa-filter" aria-hidden="true"></i>
</a>

<!-- botón de importar usuarios -->
{{ Form::button('<i class="fa fa-file-excel-o" aria-hidden="true"></i>',[
	'class'=>'btn btn-primary',
	'data-toggle'=>'modal',
	'data-target'=>'#pregModalImport',
	'data-tooltip'=>'tooltip',
	'title'=>'Importar usuarios desde Excel',
])}}

<a class='btn btn-primary' role='button' href="{{ URL::to('roles') }}" data-tooltip="tooltip" title="Roles">
	<i class="fa fa-male" aria-hidden="true"></i> <i class="fa fa-female" aria-hidden="true"></i>
</a>

{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i>',[
		'class'=>'btn btn-danger',
		'data-toggle'=>'modal',
		'data-descripcion'=>'todos los usuarios con rol Estudiante',
		'data-action'=>'usuarios/deleteEstudiantes',
		'data-target'=>'#pregModalDelete',
		'data-tooltip'=>'tooltip',
		'title'=>'Borrar todos los estudiantes',
	])
}}
<a class='btn btn-primary' role='button' href="{{ URL::to('register') }}" data-tooltip="tooltip" title="Nuevo Usuario">
	<i class="fa fa-user-plus" aria-hidden="true"></i>
</a>

@if(in_array(auth()->user()->rol->ROLE_rol , ['admin']) && !$papelera)
<a class='btn btn-primary' role='button' href="{{ URL::to('operadores/create') }}">
	<i class="fa fa-plus" aria-hidden="true"></i> Nuevo Operador
	<span class="sr-only">Nuevo</span>
</a>
<a class='btn btn-warning' role='button' href="{{ URL::to('operadores-borrados') }}">
	<i class="fa fa-trash-o" aria-hidden="true"></i> 
	Papelera
</a>
@elseif($papelera)
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

<!-- botón de exportar -->
<a class='btn btn-success' role='button' href="{{ URL::to('operadores/export/'.\Wupos\EstadoOperador::PEND_CREAR) }}">
	<i class="fa fa-download" aria-hidden="true"></i> Exportar Pend crear
</a>
