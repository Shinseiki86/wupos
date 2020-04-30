@push('scripts')
<script type="text/javascript">
	//Carga de datos a mensajes modales para clonar registros
	$(document).ready(function () {
		$('#pregModalClone').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget); // Button that triggered the modal
			var modal = $(this);

			var id = button.data('id'); 
			modal.find('.id').text(id);

			var descripcion = button.data('descripcion'); 
			modal.find('.descripcion').text(descripcion);
			
			var urlForm = button.data('action');
			$('.frmModal').attr('action', urlForm);
		});
	});
</script>
@endpush

@push('modals')
<!-- Mensaje Modal para confirmar duplicado de registro-->
<div class="modal fade" id="pregModalClone" role="dialog" tabindex="-1" >
	<div class="modal-dialog">
		<div class="modal-content panel-warning">
			<div class="modal-header panel-heading" style="border-top-left-radius: inherit; border-top-right-radius: inherit;">
				<h4 class="modal-title">¿Duplicar registro <span class="id"></span>?</h4>
			</div>

			<div class="modal-body">
				<div class="row">
					<div class="col-xs-2">
						<i class="fas fa-exclamation-triangle fa-3x fa-fw"></i>
					</div>
					<div class="col-xs-10">
						<h4>¿Desea duplicar la <span class="modelo" style="font-style: italic;">{{ $strTitulo }}</span> <span class="descripcion label label-warning"></span>?</h4>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<form id="frmDuplicarEncu" method="GET" action="" class="frmModal pull-right">

					<button type="button" class="btn btn-xs btn-default" data-dismiss="modal">
						<i class="fa fa-times" aria-hidden="true"></i> NO
					</button>

					{{ Form::token() }}
					{{ Form::button('<i class="fas fa-copy" aria-hidden="true"></i> SI ',[
						'name'=>'btn-confirmClone',
						'class'=>'btn btn-xs btn-success',
						'type'=>'submit',
						'data-toggle'=>'modal',
						'data-backdrop'=>'static',
						'data-target'=>'#msgModalCloning',
					]) }}

				</form>
			</div>
		</div>
	</div>
</div><!-- Fin de Mensaje Modal confirmar duplicado de registro.-->


<!-- Mensaje Modal al procesar solicitud registro. Bloquea la pantalla mientras se procesa la solicitud -->
<div class="modal fade" id="msgModalCloning" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-body">
				<h4>
					<i class="fa fa-cog fa-spin fa-3x fa-fw" style="vertical-align: middle;"></i> Duplicando {{ $strTitulo }}...
				</h4>
			</div>
		</div>		
	</div>
</div><!-- Fin de Mensaje Modal.-->
@endpush
