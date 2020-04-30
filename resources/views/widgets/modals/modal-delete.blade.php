@push('scripts')
<script type="text/javascript">
$(function() {
	
	//Carga de datos a mensajes modales para eliminar registros	
	//$('.btn-delete').on('click', function(event){
	$('#pregModalDelete').on('show.bs.modal', function (event) {
		var modal = $(this);
		var button = $(event.relatedTarget); // Button that triggered the modal
		
		var id = button.data('id'); // Se obtiene valor en data-id
		modal.find('.id').text(id); //Se asigna en la etiqueta con clase id
		var modelo = button.data('modelo');
		modal.find('.modelo').html(modelo);

		var descripcion = button.data('descripcion');
		modal.find('.descripcion').html(descripcion);

		var urlForm = button.data('action'); // Se cambia acción del formulario.
		modal.find('.frmModal').attr('action', urlForm);
	});

	@if(Session::has('deleteWithRelations'))
	$(function() {
		var modal = $('#deleteWithRelations');
		modal.find('.nameClass').text('{{Session::get('deleteWithRelations')['nameClass']}}');
		modal.modal('show');
	})
	@endif

})
</script>
@endpush

@push('modals')
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
						<i class="fas fa-exclamation-triangle fa-3x fa-fw"></i>
					</div>
					<div class="col-xs-10">
						<h4>¿Borrar <span class="modelo" style="font-style: italic;"></span> <span class="descripcion label label-danger"></span>?</h4>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<form id="frmDelete" method="POST" action="" accept-charset="UTF-8" class="frmModal pull-right">
					<button type="button" class="btn btn-xs btn-default" data-dismiss="modal">
						<i class="fas fa-times" aria-hidden="true"></i> NO
					</button>

					{{ Form::token() }}
					{{ Form::hidden('_method', 'DELETE') }}
					{{ Form::button('<i class="fas fa-trash" aria-hidden="true"></i> SI ',[
						'class'=>'btn btn-xs btn-danger',
						'type'=>'submit',
						'data-toggle'=>'modal',
						'data-backdrop'=>'static',
						'data-keyboard'=>'false',
						'data-target'=>'#msgModalDeleting',
					]) }}
				</form>
			</div>
		</div>
	</div>
</div><!-- Fin de Mensaje Modal confirmar borrado de registro.-->

@if(Session::has('deleteWithRelations'))
<!-- Mensaje Modal para confirmar borrado de registro-->
<div class="modal fade" id="deleteWithRelations" role="dialog" tabindex="-1" >
	<div class="modal-dialog">
		<div class="modal-content panel-danger">
			<div class="modal-header panel-heading" style="border-top-left-radius: inherit; border-top-right-radius: inherit;">
				<h4 class="modal-title"><span class="nameClass"></span> con relaciones</h4>
			</div>

			<div class="modal-body">
				<div class="row">
					<div class="col-xs-2">
						<i class="fas fa-exclamation-triangle fa-3x fa-fw"></i>
					</div>
					<div class="col-xs-10">
						<h4><span class="nameClass"></span> tiene las siguientes relaciones:<h4>
						<ul>
						@foreach(Session::get('deleteWithRelations')['strRelations'] as $rel)
							<li>{{$rel}}</li>
						@endforeach
						</ul>
						No es posible borrar el registro.
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-xs btn-default" data-dismiss="modal">
					<i class="fas fa-times" aria-hidden="true"></i> OK
				</button>
			</div>
		</div>
	</div>
</div><!-- Fin de Mensaje Modal confirmar borrado de registro.-->
@endif

<!-- Mensaje Modal al borrar registro. Bloquea la pantalla mientras se procesa la solicitud -->
<div class="modal fade" id="msgModalDeleting" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-body text-center">
				<h4>
					<i class="fas fa-cog fa-spin fa-2x fa-fw" style="vertical-align: middle;"></i> Borrando registro...
				</h4>
			</div>
		</div>

	</div>
</div><!-- Fin de Mensaje Modal al borrar registro.-->

@endpush
