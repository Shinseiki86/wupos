{{--@include('widgets.datepicker')--}}
@include('widgets.select2')

@include('widgets.forms.input', ['type'=>'text', 'name'=>'name', 'label'=>'Nombre interno', 'options'=>['maxlength' => '50'] ])

@include('widgets.forms.input', ['type'=>'text', 'name'=>'display_name', 'label'=>'Nombre para mostrar', 'options'=>['maxlength' => '50'] ])

@include('widgets.forms.input', ['type'=>'select', 'name'=>'roles', 'label'=>'Roles', 'data'=>$arrRoles, 'multiple'=>true])

@include('widgets.forms.input', [ 'type'=>'textarea', 'name'=>'description', 'label'=>'Descripción', 'options'=>['maxlength' => '100'] ])

<!-- Botones -->
@include('widgets.forms.buttons', ['url' => 'auth/roles'])
