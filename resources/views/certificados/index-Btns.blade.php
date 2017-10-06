
<!-- Filtrar datos en vista -->
<button type="button" class="btn btn-primary" ng-click="toggleFormFilter()" data-tooltip="tooltip" title="Filtrar resultados">
	<i class="fa fa-filter" aria-hidden="true"></i>
</button>

<!-- botón de crear nuevo reg -->
@if(in_array(auth()->user()->rol->ROLE_rol , ['admin']) && !$papelera)
<a class='btn btn-primary' role='button' href="{{ URL::to('certificados/create') }}">
	<i class="fa fa-plus" aria-hidden="true"></i>
</a>
<a class='btn btn-warning' role='button' href="{{ URL::to('certificados/papelera') }}">
	<i class="fa fa-trash-o" aria-hidden="true"></i>
</a>
@elseif($papelera)
	<!-- botón de vaciar papelera -->
	{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i> Vaciar <span class="hidden-xs">Papelera</span>',[
			'class'=>'btn btn-danger',
			'data-toggle'=>'modal',
			'data-id'=>'{% papelera %}',
			'data-descripcion'=>'registros en la papelera',
			'data-action'=>'certificados/papelera/vaciar',
			'data-target'=>'#pregModalDelete',
		])
	}}
@endif

<!-- botón de exportar -->
{{ Form::open( [ 'url'=>'certificados/export/xlsx', 'method'=>'GET', 'style' => 'display: inline;' ]) }}
	{{ Form::hidden('_papelera', ''.$papelera) }}
	{{ Form::button('<i class="fa fa-download" aria-hidden="true"></i> Exportar',[
			'class'=>'btn btn-success',
			'type'=>'submit',
	]) }}
{{ Form::close() }}
