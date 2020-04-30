<br>
{{ Form::text( $name, old($name)!==null?old($name):'0', ['class' => 'form-control input-color'] + (isset($options)?$options:[]) )}}