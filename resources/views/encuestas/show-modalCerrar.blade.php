@push('scripts')
	<script type="text/javascript">
		var form = $('#frmCerrarEncu');
		//Carga de datos a mensajes modales para eliminar y clonar registros
		$('#submit').click(function (e) {
			var ENCU_motivoCierre = form.find('#ENCU_motivoCierre').val();
			if(ENCU_motivoCierre != ''){
				$('#msgModalClosing')
					.modal({backdrop: 'static', keyboard: false})
					.modal('show');
				return form.submit();
			} else {
				return form.submit(); //Se retorna para que valide el campo y muestre el tooltip.
			}
			e.preventDefault()
		});
	</script>
@endpush

@push('modals')
<!-- Mensaje Modal para confirmar borrado de registro-->
<div class="modal fade" id="pregModalCerrarENCU" role="dialog" tabindex="-1" >
	<div class="modal-dialog">
		<div class="modal-content panel-danger">
			<div class="modal-header panel-heading" style="border-top-left-radius: inherit; border-top-right-radius: inherit;">
				<h4 class="modal-title">¿Cerrar?</h4>
			</div>

			<div class="modal-body">
				<h4>
					<i class="fa fa-exclamation-triangle"></i> ¿Desea cerrar la encuesta {{ $encuesta->ENCU_ID }}?
				</h4>
					{{ Form::open( ['url' => 'encuestas/'. $encuesta->ENCU_ID .'/cerrar', 'id'=>'frmCerrarEncu', 'class' => 'form-vertical'] ) }}

						{{ Form::label('ENCU_motivoCierre', 'Motivo del cierre de la encuesta:') }}
						{{ Form::textarea('ENCU_motivoCierre', old('ENCU_motivoCierre'), [
							'class' => 'form-control',
							'size' => '20x3',
							'placeholder' => 'Escriba aquí...',
							'style' => 'resize: vertical',
							'required'
						]) }}
			</div>

			<div class="modal-footer">
					{{ Form::button('<i class="fa fa-times" aria-hidden="true"></i> Cancelar',[
						'class'=>'btn btn-xs btn-default',
						'data-dismiss'=>'modal',
					]) }}
					{{ Form::button('<i class="fa fa-times-circle" aria-hidden="true"></i> Cerrar ',[
						'name'=>'btn-confirmClose',
						'class'=>'btn btn-xs btn-success',
						'id'=>'submit',
						'type'=>'submit',
					]) }}
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div><!-- Fin de Mensaje Modal confirmar borrado de registro.-->


<!-- Mensaje Modal al borrar registro. Bloquea la pantalla mientras se procesa la solicitud -->
<div class="modal fade" id="msgModalClosing" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-body">
				<h4>
					<i class="fa fa-cog fa-spin fa-3x fa-fw" style="vertical-align: middle;"></i> Cerrando encuesta...
				</h4>
			</div>
		</div>
	</div>
</div><!-- Fin de Mensaje Modal al borrar registro.-->
@endpush
