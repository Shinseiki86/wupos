{{-- Utilizado para mostrar mensajes provenientes de los controladores --}}

<!-- ALERTAS -->
<div class="alerts">

	@if (Session::has('alert-info'))
		@foreach(Session::get('alert-info') as $msg)
		<div class="alert alert-info alert-flash">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong><i class="fas fa-info-circle fa-2x fa-pull-left" aria-hidden="true"></i></strong>
			{{ $msg }}
		</div>
		@endforeach
	@endif

	@if (Session::has('alert-success'))
		@foreach(Session::get('alert-success') as $msg)
		<div class="alert alert-success alert-flash">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong><i class="fas fa-check fa-2x fa-pull-left" aria-hidden="true"></i></strong>
			{{ $msg }}
		</div>
		@endforeach
	@endif

	@if (Session::has('alert-warning'))
		@foreach(Session::get('alert-warning') as $msg)
		<div class="alert alert-warning alert-flash">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>
				<i class="fas fa-exclamation-triangle fa-2x fa-pull-left" aria-hidden="true"></i>
				{{ $msg }}
			</strong>
		</div>
		@endforeach
	@endif

	@if (Session::has('alert-danger'))
		@foreach(Session::get('alert-danger') as $msg)
		<div class="alert alert-danger alert-flash">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>
				<i class="fas fa-exclamation-circle fa-2x fa-pull-left" aria-hidden="true"></i>
				{{ $msg }}
			</strong>
		</div>
		@endforeach
	@endif
	
</div>

<!-- MODALES -->
<!-- Mensaje Modal-->
<div class="modal fade" id="messageModal" role="dialog" tabindex="-1" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header panel-heading" style="border-top-left-radius: inherit; border-top-right-radius: inherit;">
				<h4 class="modal-title"></h4>
			</div>

			<div class="modal-body">
				<div class="row">
					<div class="col-xs-2">
						<i class="fas fa-3x fa-fw"></i>
					</div>
					<div class="col-xs-10">
						<h4 id="message"></h4>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-xs btn-success" data-dismiss="modal">
					<i class="fas fa-times" aria-hidden="true"></i> OK
				</button>
			</div>
		</div>
	</div>
</div><!-- Fin de Mensaje Modal.-->

@push('scripts')
	<script type="text/javascript">

		//Se cierra la alerta a los 10 segundos.
		setTimeout(function () {
        	$('.alert-flash').slideUp(500, function(){
			    //$(this).alert('close');
			});
		}, 10*(1000));

		//Si el mensaje es modal, se configura la ventana según el tipo de mensaje (success, warning y danger).
		@if (Session::has('modal-info'))
			$(function() {
				var modal = $('#messageModal');
				modal.find('#message').html('{!!Session::get('modal-message')!!}');
				modal.find('.fas').addClass('fa-info-circle');
				modal.find('.modal-content')
					.addClass('panel-info')
					.find('.modal-title').text('Información');
				modal.modal('show');
			})
		@endif
		@if (Session::has('modal-success'))
			$(function() {
				var modal = $('#messageModal');
				modal.find('#message').html('{!!Session::get('modal-message')!!}');
				modal.find('.fas').addClass('fa-check');
				modal.find('.modal-content')
					.addClass('panel-success')
					.find('.modal-title').text('¡Operación exitosa!');
				modal.modal('show');
			})
		@endif
		@if (Session::has('modal-warning'))
			$(function() {
				var modal = $('#messageModal');
				modal.find('#message').html('{!!Session::get('modal-warning')!!}');
				modal.find('.fas').addClass('fa-exclamation-triangle');
				modal.find('.modal-content')
					.addClass('panel-warning')
					.find('.modal-title').text('¡Advertencia!');
				modal.modal('show');
			})
		@endif
		@if (session()->has('modal-danger'))
			$(function() {
				var modal = $('#messageModal');
				modal.find('#message').html('{!!Session::get('modal-danger')!!}');
				modal.find('.fas').addClass('fa-exclamation-circle');
				modal.find('.modal-content')
					.addClass('panel-danger')
					.find('.modal-title').text('¡Error!');
				modal.modal('show');
			})
		@endif
	</script>
@endpush