<div id="btns-footer" class="row">
	<div class='col-xs-4'>
		<!-- Botón (FORM) para cambiar el orden de las preguntas -->
		{{ Form::open( ['url' => 'encuestas/'.$encuesta->ENCU_ID.'/pregs/ordenar', 'class' => 'form-horizontal'] ) }}
			{{ Form::hidden('inputPreguntas', '{% preguntas %}', [ 'id'=>'inputPreguntas' ] ) }}
			{{ Form::button('<i class="fa fa-sort" aria-hidden="true"></i> Ordenar<span class="hidden-xs"> Preguntas</span>', [
				'id'=>'btn-modOrden',
				'class'=>'btn btn-primary',
				!$encuesta->isOpen() ? 'disabled' : '',
				'data-tooltip'=>'tooltip',
				'title'=>'Permite cambiar el orden de las preguntas',
			]) }}
		{{ Form::close() }}
	</div>

	<div class="col-xs-8 text-right">
		<!-- Botón adicionar nueva pregunta -->
		<a class="btn btn-warning" role="button" href="{{ URL::to(mb_strtolower($strTitulo).'s') }}" data-tooltip="tooltip" title="Regresar">
			<i class="fa fa-arrow-left" aria-hidden="true"></i>
		</a>
		<!-- Botón regresar a vista encuestas -->
		<a name="add-preg" class="btn btn-primary {{ (!$encuesta->isOpen()) ? 'disabled' : '' }}" role='button' href="{{ URL::to('encuestas/'.$encuesta->ENCU_ID.'/pregs/create') }}">
			<i class="fa fa-plus" aria-hidden="true"></i> <span class="hidden-xs">Add Pregunta</span>
		</a>
	</div>
</div>