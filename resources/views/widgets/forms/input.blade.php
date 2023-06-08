<div class="input-{{$type}} col-xs-{{isset($column)?$column:12}} {{isset($hidden)?'hide':''}}"> 
	<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
		
		{{ Form::label($name, $label,  [ 'class'=>'control-label' ], false) }}
		
		@yield('input_label_'.$name)
		
		@include('widgets.forms.input-'.$type, [
			'type'    =>$type,
			'name'    =>$name,
			'value'   =>isset($value) ? $value : null,
			'options'   =>isset($options) ? $options : null,
			//'data'    =>$dataArray,
			//'ajax'    =>$ajax,
			'multiple'=>isset($multiple) ? $multiple : null,
			'class'   =>isset($class) ? $class : null,
		])

		@include('widgets.forms.alerta',compact('name'))
	</div>
</div>