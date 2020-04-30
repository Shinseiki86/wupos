@push('modals')
<!--  Mensaje Modal. Bloquea la pantalla mientras se procesa la solicitud  -->
<div class="modal fade" id="msgModal" role="dialog">
	<div class="modal-dialog modal-sm">
		<!-- Modal content -->
		<div class="modal-content">
			<div class="modal-header hide">
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				<h4 class="">
					<i id="iconFont" class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
					<span id="modal-text"></span>
				</h4>
			</div>
			<div class="modal-footer hide">
				<button name="btn-close" class="btn btn-default" type="button" data-dismiss="modal">
					<i class="fa fa-times" aria-hidden="true"></i> Cerrar
				</button>
			</div>
		</div>
	</div>
</div>
@endpush