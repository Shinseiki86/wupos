@section('scripts')
	<script type="text/javascript">
		//Carga de datos a mensajes modales para eliminar y clonar registros
		$(document).ready(function () {
			$('#pregModalDelete').on('show.bs.modal', function (event) {
				updateModalDelete($(event.relatedTarget), $(this));
			});

			$('#tbIndex').on('click', '.btn-delete', function(event){
				updateModalDelete($(event.currentTarget), $('#pregModalDelete'));
			});

			function updateModalDelete(button, modal) {
				var id = button.data('id'); // Se obtiene valor en data-id
				modal.find('.id').text(id); //Se asigna en la etiqueta con clase id

				var modelo = button.data('modelo');
				modal.find('.modelo').html(modelo);

				var descripcion = button.data('descripcion');
				modal.find('.descripcion').html(descripcion);

				var urlForm = button.data('action'); // Se cambia acción del formulario.
				modal.find('.frmModal').attr('action', urlForm);
			}
		});
	</script>
@parent
@endsection

<!-- Mensaje Modal para confirmar borrado de registro-->
<div class="modal fade" id="pregModalDelete" role="dialog" tabindex="-1" >
	<div class="modal-dialog">
		<div class="modal-content panel-danger">
			<div class="modal-header panel-heading" style="border-top-left-radius: inherit; border-top-right-radius: inherit;">
				<h4 class="modal-title">¿Borrar registro <span class="id"></span>?</h4>
			</div>

			<div class="modal-body">
				<div class="row">
					<div class="col-xs-2">
						<i class="fa fa-exclamation-triangle fa-3x fa-fw"></i>
					</div>
					<div class="col-xs-10">
						<h4>¿Borrar <span class="modelo"></span> <span class="descripcion"></span>?</h4>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<form id="frmDelete" method="POST" action="" accept-charset="UTF-8" class="frmModal pull-right">
					<button type="button" class="btn btn-xs btn-default" data-dismiss="modal">
						<i class="fa fa-times" aria-hidden="true"></i> NO
					</button>
					{{ Form::token() }}
					{{ Form::hidden('_method', 'DELETE') }}
					{{ Form::hidden('_modoBorrado', (isset($papelera) && $papelera) ? 'forceDelete' : 'softDelete') }}
					{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i> SI ',[
						'class'=>'btn btn-xs btn-danger',
						'type'=>'submit',
						'data-toggle'=>'modal',
						'data-backdrop'=>'static',
						'data-target'=>'#msgModalDeleting',
					]) }}
				</form>
			</div>
		</div>
	</div>
</div><!-- Fin de Mensaje Modal confirmar borrado de registro.-->


<!-- Mensaje Modal al borrar registro. Bloquea la pantalla mientras se procesa la solicitud -->
<div class="modal fade" id="msgModalDeleting" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-body">
				<h4>
					<i class="fa fa-cog fa-spin fa-3x fa-fw" style="vertical-align: middle;"></i> Borrando registro...
				</h4>
			</div>
		</div>

	</div>
</div><!-- Fin de Mensaje Modal al borrar registro.-->