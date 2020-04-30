@push('modals')
<!-- Mensaje Modal para publicar la encuesta -->
<div class="modal fade" id="pregModalPublicarENCU" role="dialog" tabindex="-1" >
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content panel-warning">
			<div class="modal-header panel-heading" style="border-top-left-radius: inherit; border-top-right-radius: inherit;">
				<h4 class="modal-title">¿Publicar?</h4>
			</div>
			<div class="modal-body">
				<h4>
					<i class="fa fa-exclamation-triangle"></i> ¿Desea publicar la encuesta {{ $encuesta->ENCU_ID }}?
				</h4>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
					<i class="fa fa-times" aria-hidden="true"></i> NO
				</button>

				<a name="btn-confirmPublish" class="btn btn-sm btn-success" href="{{ URL::to('encuestas/'. $encuesta->ENCU_ID .'/publicar') }}">
					<i class="fas fa-thumbs-up" aria-hidden="true"></i> SI
				</a>
			</div>
		</div>
	</div>
</div><!-- Fin de Mensaje Modal publicar encuesta.-->
@endpush
