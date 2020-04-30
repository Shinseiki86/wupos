<div class="form-group">
	<div class="col-xs-8 col-xs-offset-4 text-right">

		@if(isset($url))
		<a class="btn btn-warning" role="button" href="{{ isset($url) ? url()->to($url) : ( url()->previous() ==  url()->previous() ? url()->to('/') : url()->previous()) }}" data-tooltip="tooltip" title="Regresar">
			<i class="fas fa-arrow-left" aria-hidden="true"></i>
		</a>
		@endif

		@if(isset($reset) and $reset=false)
		@else
		{{ Form::button('<i class="fas fa-undo" aria-hidden="true"></i> Reset', [
			'class'=>'btn btn-warning',
			'type'=>'reset',
		]) }}
		@endif

		{{ Form::button('<i class="fas fa-'.(isset($icon)?$icon:'save').'" aria-hidden="true"></i> '.(isset($text)?$text:'Guardar'), [
			'class'=>'btn btn-primary',
			'name'=>'submit',
			'type'=>'submit',
			'data-tooltip'=>(isset($text)?:'tooltip'),
			'title'=>(!isset($text)?:$text),
		]) }}
	</div>
</div>