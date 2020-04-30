{{ Form::textarea( $name, old($name), [
	'class' => 'form-control '.(isset($class)?$class:''),
	'size'  => '20x3',
	'style' => 'resize: vertical'
	] + (isset($options)?$options:[])
)}}
