<div class="dd-handle dd3-handle"></div>
<div class="dd3-content">
	<i class="fas {{ $item['MENU_ICON'] }} fa-fw"></i> 
	{{ $item['MENU_LABEL'] }} @if(!$item['MENU_ENABLED'])(DESHABILITADO)@endif
	<div class="pull-right">
		<!-- Botón Editar (edit) -->
		<a class="btn btn-small btn-info btn-xs" href="{{ URL::to('app/menu/'.$item['MENU_ID'].'/edit') }}" data-tooltip="tooltip" title="Editar">
			<i class="fas fa-edit" aria-hidden="true"></i>
		</a>
		<!-- carga botón de borrar -->
		{{ Form::button('<i class="fas fa-trash-alt" aria-hidden="true"></i>',[
			'class'       =>'btn btn-xs btn-danger btn-delete',
			'data-toggle' =>'modal',
			'data-class'  =>'danger',
			'data-id'     => $item['MENU_ID'],
			'data-model'  => 'Menú',
			'data-descripcion'=> $item['MENU_LABEL'],
			'data-method' => 'DELETE',
			'data-action' => 'menu/'.$item['MENU_ID'],
			'data-target' =>'#pregModalAction',
			'data-tooltip'=>'tooltip',
			'data-title'  =>'Borrar',
		])}}
	</div>
</div>

