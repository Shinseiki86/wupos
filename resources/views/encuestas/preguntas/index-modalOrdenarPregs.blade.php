@push('modals')
<!-- Mensaje Modal. Muestra ayuda al presionar botón para ordenar preguntas -->
<div class="modal fade" id="msgModalHelp" role="dialog">
	<div class="modal-dialog" role="document">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Ordenando las preguntas...</h4>
			</div>
			<div class="modal-body">
				<p class="text-center">
					Para cambiar el orden de las preguntas, arrástrelas con el mouse:<br>
					{{ Html::image('manuales/organizar-preguntas.gif', 'Ordenando las preguntas', ['class'=>'img-responsive'] ) }}
					Al finalizar, se debe dar clic en el botón "Guardar posición" para conservar los cambios.
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
			</div>
		</div>
	</div>
</div>
@endpush
