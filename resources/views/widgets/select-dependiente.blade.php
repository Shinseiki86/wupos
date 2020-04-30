@push('scripts')
	{!! Html::script('js/select2/select2-dependiente.js') !!}
	<script type='text/javascript'>
		$(document).ready(function(){
			if( $('#{{$selectHijo}}').val() == '' || $('#{{$selectHijo}}').val() == null)
				$('#{{$selectHijo}}').prop('disabled', true);

			fillDropDownAjax(
				'{{$selectPadre}}',
				$('#{{$selectHijo}}'),
				'{!!URL::to($url)!!}',
				'{{isset($idBusqueda)?$idBusqueda:$selectHijo}}',
				'{{$nombreBusqueda}}',
				'{{isset($msgModel)?$msgModel:'datos'}}'
			)
		});
	</script>
@endpush