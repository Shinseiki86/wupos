{{ Form::select(
	isset($multiple) && $multiple ? $name.'[]':$name,
	(isset($multiple) && $multiple ? []:[''=>'']) + (isset($data)?$data:[]) , 
	isset($value)? $value:old($name),
	[
		'id'=>$name,
		'class'=>'form-control '.(isset($ajax)?'selectpickerAjax':'selectpicker').(isset($class)?' '.$class:''),
		//'data-allow-clear'=>isset($allowClear) && $allowClear ?'true':'false',
		'data-allow-clear'=>'true',
		'data-placeholder'=>isset($placeholder) ?$placeholder:'Seleccione una opción',
	] + 
	(isset($ajax) && is_array($ajax)
		? ( isset($ajax['model']) ? ['data-ajax--url'=> url('getArrModel').'?model='.$ajax['model'].'&column='.$ajax['column']]
								: ['data-ajax--url'=> $ajax['url']] )
		: []
	) +
	(isset($multiple) && $multiple ? ['multiple']:[]) +
	(isset($allowNew) && $allowNew ? ['data-tags'=>'true', 'data-select-on-close'=>'true']:[]) +
	(isset($options) ? $options : [])
) }}

@if(is_array(old($name)) or isset(${$name}))
@push('scripts')
<script type="text/javascript">
	$('#{{$name}}')
		.val(
			{{ ((old($name)!=null or old($name)!='') and is_array(old($name)))
				? json_encode(array_map('intval', old($name)))
				: (isset(${$name})?''.${$name}:'')
			}}
		);
</script>
@endpush
@endif