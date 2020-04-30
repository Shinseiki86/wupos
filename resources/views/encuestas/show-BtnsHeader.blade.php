<!-- botón de vista previa para responder la encuesta  fa-list-alt -->
<a name="btn-preview" class="btn btn-sm btn-success" href="{{ URL::to('encuestas/'. $encuesta->ENCU_ID .'/preview') }}" data-tooltip="tooltip" title="Vista previa">
	<i class="fa fa-list-ol" aria-hidden="true"></i>
</a>

@if(!$encuesta->ENCU_PLANTILLA)
	@if($encuesta->isOpen())
		<!-- botón de publicar la encuesta -->
		{{ Form::button('<i class="fas fa-thumbs-up" aria-hidden="true"></i>',[
			'name'=>'btn-publish',
			'class'=>'btn btn-sm btn-success',
			'data-toggle'=>'modal',
			'data-target'=>'#pregModalPublicarENCU',
			'data-tooltip'=>'tooltip',
			'title'=>'Publicar',
		]) }}

	@else
		<!-- carga botón de reporte -->
		<a name="btn-report" class="btn btn-sm btn-info" href="{{ URL::to('encuestas/'. $encuesta->ENCU_ID .'/reportes/loading') }}" data-tooltip="tooltip" title="Reportes">
			<i class="fas fa-chart-line" aria-hidden="true"></i>
		</a>
	@endif
	@if($encuesta->isPublished())
		<!-- botón Generar enlace Form Respuestas    fa-link  -->
		{{ Form::button('<i class="fas fa-share-square" aria-hidden="true"></i> <span class="hidden-xs"></span>',[
			'name'=>'btn-linkResp',
			'class'=>'btn btn-sm btn-success',
			'data-toggle'=>'modal',
			'data-target'=>'#pregModalLink',
			'data-tooltip'=>'tooltip',
			'title'=>'Obtener enlace formulario para responder',
		]) }}

		<!-- botón de cerrar la encuesta -->
		{{ Form::button('<i class="fa fa-hourglass-end" aria-hidden="true"></i> Cerrar',[
			'name'=>'btn-close',
			'class'=>'btn btn-sm btn-warning',
			'data-toggle'=>'modal',
			'data-target'=>'#pregModalCerrarENCU',
			'data-tooltip'=>'tooltip',
			'title'=>'Finalizar publicación',
		]) }}
	@endif
@endif
@if($encuesta->isOpen() or $encuesta->isPublished())
	<!-- Botón de editar la encuesta -->
	<a name="btn-edit" class="btn btn-sm btn-info" role='button' href="{{ URL::to(strtolower($strTitulo).'s/'. $encuesta->ENCU_ID .'/edit') }}" data-tooltip="tooltip" title="Editar encuesta">
		<i class="fas fa-pencil-alt" aria-hidden="true"></i>
	</a>
@endif