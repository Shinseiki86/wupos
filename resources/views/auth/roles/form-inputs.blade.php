{{--@include('widgets.datepicker')--}}
@include('widgets.select2')

<div class="col-xs-12 col-sm-6"> 
	@include('widgets.forms.input', ['type'=>'text', 'name'=>'name', 'label'=>'Nombre interno', 'options'=>['maxlength' => '15'] ])
	@include('widgets.forms.input', ['type'=>'text', 'name'=>'display_name', 'label'=>'Nombre para mostrar', 'options'=>['maxlength' => '50'] ])
	@include('widgets.forms.input', [ 'type'=>'textarea', 'name'=>'description', 'label'=>'Descripción', 'options'=>['maxlength' => '100', 'required'] ])
</div>
<div class="col-xs-12 col-sm-6"> 
	@include('widgets.forms.input', ['type'=>'select', 'name'=>'permissions', 'label'=>'Permisos', 'data'=>$arrPermGroups, 'multiple'=>true])
</div>

<!-- Botones -->
@include('widgets.forms.buttons', ['url' => 'auth/roles'])
