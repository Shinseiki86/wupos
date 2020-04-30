@extends('layouts.menu')
@section('title', '/ Crear Encuesta')
@section('page_heading', 'Nueva Encuesta')

@section('section')
	<!-- Para usar plantilla -->
	<div class="col-xs-12 col-sm-12"> 
	@include('widgets.forms.input', ['type'=>'select', 'name'=>'plantillasList', 'label'=>'Usar plantilla', 'placeholder'=>'Seleccione una plantilla...', 'hidden'=>(isset($encuesta->ENCU_ID) ? true : false), 'data'=>$arrPlantillas,
		'options'=>[
		]])
	</div>

	{{ Form::open(['route'=>'encuestas.store', 'class'=>'form-vertical', 'id'=>'frmEncuesta']) }}


		<!-- Elementos del formulario -->
		@rinclude('form-inputs')

		<!-- Botones -->
		<div class="col-xs-12">
			@include('widgets.forms.buttons', ['url' => 'encuestas'])
		</div>

	{{ Form::close() }}

	@push('scripts')
	<script type="text/javascript">
		$(function () {
			var plantillas = {!! $plantillas->toJson() !!};
			//usar plantilla
			$('#plantillasList').change(function() {
				var sel = $(this).val();
				var index = $(this).find(":selected").index();
				if(index>0){
					var pl = plantillas[index-1];
					$('#ENCU_TITULO').val(pl.ENCU_TITULO);
					$('#ENCU_FECHAVIGENCIA').val(pl.ENCU_FECHAVIGENCIA).trigger('change');
					$('#ENCU_DESCRIPCION').val(pl.ENCU_DESCRIPCION);

					$('#dirigidaA').val($.parseJSON(pl.ENCU_ROLESIDS)).trigger('change');
					$('#ENCU_PARADOCENTE').prop('checked', pl.ENCU_PARADOCENTE);
					
					urlCloneFromTemplate = '{{ route('encuestas.index') }}/'+ pl.ENCU_ID +'/clone';
					$('#frmEncuesta').attr('action', urlCloneFromTemplate);
					// $('#frmEncuesta :submit').removeAttr('disabled');
				} else {

					$('#frmEncuesta').attr('action', '{{ route('encuestas.store') }}');
				}
			});//.trigger('change');

		});
	</script>
	@endpush

@endsection

