<div class="col-xs-{{isset($column) ? $column : 12}} {{ (isset($hidden) and $hidden) ? 'hidden' : '' }}"> 
@if($type=='checkbox2')
	<div class="checkbox input-group">
		@include('widgets.forms.input-checkbox2', compact('name','value','options','class'))
		{{ Form::label($name, $label, ['class' => 'form-control form-check-label'], false) }}
	</div>
@else
	<div class="form-group {{$errors->has($name)?'has-error':''}}">
		{{ Form::label($name, $label, ['class' => 'control-label'], false) }}
		@include('widgets.forms.input-'.$type, compact('name','value','options','data','ajax','multiple','class'))
		@include('widgets.forms.alerta',compact('name'))
	</div>
@endif
</div>