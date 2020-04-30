{{ Form::email( $name, isset($value)? $value:old($name), ['class'=>'form-control', 'maxlength'=>'320'] + (isset($options)?$options:[]) )}}
