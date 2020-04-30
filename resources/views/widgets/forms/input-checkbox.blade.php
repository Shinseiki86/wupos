{{ Form::hidden($name, '0') }} {{-- Cuando el checkbox no se selecciona, envía el valor false al controller--}}
{{ Form::checkbox( $name, 1, old($name), ['class'=>'form-control'] + (isset($options)?$options:[]) )}}
