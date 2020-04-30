{{-- Form::hidden($name, '0') --}} {{-- Cuando el checkbox no se selecciona, envía el valor false al controller--}}
<span class="input-group-addon">
	{{ Form::checkbox( $name, 1, old($name), [
		'id'   =>$name,
		'class'=>'form-check-input',
		'style'=>'position: relative; margin-left: 0px;'
		] + (isset($options)?$options:[])
	)}}
</span>