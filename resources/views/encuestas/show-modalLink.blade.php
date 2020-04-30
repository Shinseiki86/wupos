@push('modals')
<!-- Mensaje Modal para obtener el enlace para responder la encuesta -->
<div class="modal fade" id="pregModalLink" role="dialog" tabindex="-1" >
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content panel-warning">
			<div class="modal-header panel-heading" style="border-top-left-radius: inherit; border-top-right-radius: inherit;">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Enlace del formulario de Respuestas</h4>
			</div>
			<div class="modal-body">
				<h4>
					<input id="urlResps" name="urlResps" class="form-control" value="{{ URL::to('encuestas/'. $encuesta->ENCU_ID .'/resps') }}" onclick="this.select();" readonly style="cursor: text">
				</h4>
			</div>
		</div>
	</div>
</div><!-- Fin de Mensaje Modal publicar encuesta.-->
@endpush

@push('scripts')
<script type="text/javascript">
	$('#pregModalLink').on('shown.bs.modal', function (event) {
		$('#urlResps').focus().select();
	})
</script>
@endpush