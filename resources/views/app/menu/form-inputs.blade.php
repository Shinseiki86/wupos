{{-- @include('widgets.datepicker') --}}
@include('widgets.select2')
<div class='col-md-8 col-md-offset-2'>
	
	@include('widgets.forms.input', ['type'=>'text', 'column'=>8, 'name'=>'MENU_LABEL', 'label'=>'Label', 'options'=>['maxlength' => '20'] ])

	@include('widgets.forms.input', ['type'=>'icon', 'column'=>3, 'name'=>'MENU_ICON', 'label'=>'Ícono', ])
	@include('widgets.forms.input', ['type'=>'checkbox', 'column'=>1, 'name'=>'MENU_ENABLED', 'label'=>'Habilitado' ])

	@include('widgets.forms.input', ['type'=>'select', 'column'=>4, 'name'=>'PERM_ID', 'label'=>'Permiso', 'data'=>$arrPermisos])

	@include('widgets.forms.input', ['type'=>'select', 'column'=>8, 'name'=>'MENU_URL', 'label'=>'Destino (URL)', 'data'=>$arrRoutes, 'allowNew'=>true, 'allowClear'=>true])

</div>