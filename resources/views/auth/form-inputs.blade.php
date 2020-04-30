@include('widgets.select2')

@include('widgets.forms.input', ['type'=>'text', 'column'=>4, 'name'=>'username', 'label'=>'Nombre de Usuario','options'=>['maxlength' => '30']])

@include('widgets.forms.input', ['type'=>'text', 'column'=>8, 'name'=>'name', 'label'=>'Nombre', 'options'=>['maxlength' => '100'] ])

@include('widgets.forms.input', ['type'=>'number', 'column'=>4, 'name'=>'cedula', 'label'=>'Cédula', 'options'=>['size' => '999999999999999'] ])

@include('widgets.forms.input', ['type'=>'email', 'column'=>8, 'name'=>'email', 'label'=>'Correo electrónico'])

@include('widgets.forms.input', ['type'=>'select', 'name'=>'roles', 'label'=>'Roles', 'data'=>$arrRoles, 'multiple'=>true,])

