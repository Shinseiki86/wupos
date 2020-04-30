<!-- Botones -->
<div class="col-xs-12 text-right" style="">
	{{ Form::button('<i class="fas fa-undo" aria-hidden="true"></i>', [
		'class'=>'btn btn-warning',
		'type'=>'reset',
		'data-tooltip'=>'tooltip',
		'title'=>'Reset',
	]) }}
	{{ Form::button('<i class="fas fa-cog" aria-hidden="true"></i>', [
		'class'=>'btn btn-primary',
		'type'=>'submit',
		'data-tooltip'=>'tooltip',
		'title'=>'Procesar',
	]) }}
</div>