@push('scripts')
<script type="text/javascript">
$(function() {
	
	//Carga de datos a mensajes modales para eliminar registros	
	//$('.btn-delete').on('click', function(event){
	$('#pregModalAction').on('show.bs.modal', function (event) {
		var modal = $(this);
		var button = $(event.relatedTarget); // Button that triggered the modal
		
		var id = button.data('id'); // Se obtiene valor en data-id
		modal.find('.id').text(id); //Se asigna en la etiqueta con clase id
		var model = button.data('model');
		modal.find('.model').html(model);


		var descripcion = button.data('descripcion');
		modal.find('.modal-descripcion').html(descripcion);

		var urlForm = button.data('action'); 
		modal.find('.frmModal').attr('action', urlForm);

		var methodForm = button.data('method'); // Se cambia acción del formulario.
		modal.find('input[name="_method"]').attr('value', methodForm ? methodForm : 'PUT');

		var title = button.data('title');
		modal.find('.title').html(title);

		var alertType = button.data('class');
		var iconBtn = button.find('i').attr('class');
		modal.find('.modal-content').removeClass().addClass('modal-content panel-'+alertType);
		modal.find('.modal-descripcion.label').removeClass().addClass('modal-descripcion label label-'+alertType);
		modal.find(':submit')
			.removeClass().addClass('btn btn-xs btn-'+alertType)
			.find('i').removeClass().addClass(iconBtn);

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
<div class="modal fade" id="pregModalAction" role="dialog" tabindex="-1" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header panel-heading" style="border-top-left-radius: inherit; border-top-right-radius: inherit;">
				<h4 class="modal-title"><span class="title"></span> registro <span class="id"></span></h4>
			</div>

			<div class="modal-body">
				<div class="row">
					<div class="col-xs-1 col-md-offset-1">
						<i class="fas fa-exclamation-triangle fa-3x fa-fw"></i>
					</div>
					<div class="col-xs-9 col-xs-offset-1 col-md-9">
						<h4>¿<span class="title"></span> <span class="model" style="font-style: italic;"></span> <span class="modal-descripcion label"></span>?</h4>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<form id="frmDelete" method="POST" action="" accept-charset="UTF-8" class="frmModal pull-right">
					<button type="button" class="btn btn-xs btn-default" data-dismiss="modal">
						<i class="fas fa-times" aria-hidden="true"></i> NO
					</button>
					{{ Form::token() }}
					{{ Form::hidden('_method', '') }}
					{{ Form::button('<i class="fas fa-exclamation-triangle" aria-hidden="true"></i> SI ',[
						'class'=>'btn btn-xs btn-submit',
						'type'=>'submit',
						'data-toggle'=>'modal',
						'data-backdrop'=>'static',
						'data-keyboard'=>'false',
						'data-target'=>'#msgModalProcessing',
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
<div class="modal fade" id="msgModalProcessing" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-body text-center">
				<h4>
					<i class="fas fa-cog fa-spin fa-2x fa-fw" style="vertical-align: middle;"></i> Procesando...
				</h4>
			</div>
		</div>

	</div>
</div><!-- Fin de Mensaje Modal al borrar registro.-->

@endpush
