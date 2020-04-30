<div class="panel panel-default">
	<div class="panel-heading">{{ $preg->PREG_TITULO }}</div>
	<div class="panel-body">
		<div class="form-group itemValidate">
			{{ Form::label('resp_preg_'.$preg->PREG_ID, 'Pregunta '.$preg->PREG_POSICION.':') }}
			{!! str_replace('script', '', $preg->PREG_TEXTO) !!}
			<span class="showError"></span>
			{{ Form::textarea('resp_preg_'.$preg->PREG_ID, old('resp_preg_'.$preg->PREG_ID), [
				'class' => 'form-control', 
				'size' => '20x3', 
				'maxlength'=>'500',
				'placeholder' => 'Escriba aquí...',
				'style' => 'resize: vertical',
				$preg->PREG_REQUERIDO ? 'required' : '',
			])}}
		</div>
	</div>
</div>