<script type="text/javascript">
	$(document).ready(function() {
		$('form').submit( function() {
			var button = $(this).find("button[type=submit]:focus" )
			button.attr('disabled', true);
			$('body').css('cursor', 'progress');
			if(button.data('toggle')!='modal'){
				$('#msgModalLoading').modal('show');
			}			
		});
	});
</script>

<!-- Mensaje Modal al procesar submit del form -->
<div class="modal fade" id="msgModalLoading" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-body text-center">
				<h4>
					<i class="fas fa-cog fa-spin fa-2x fa-fw" style="vertical-align: middle;"></i> Procesando...
				</h4>
			</div>
		</div>

	</div>
</div>