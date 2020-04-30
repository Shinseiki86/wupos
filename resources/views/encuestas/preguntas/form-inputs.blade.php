@include('widgets.select2')

@push('head')
	<style>
		.checkbox{margin-top: 22px;}
	</style>
@endpush

@push('scripts')
{!! Html::script('js/ckeditor/ckeditor.js') !!}
{!! Html::script('js/ckeditor/adapters/jquery.js') !!}
<script type="text/javascript">
	$(function () {
		CKEDITOR.replaceAll();

		$('#PRTI_ID').change(function() {
			var tipo_preg = $(this).find(":selected").val();
			//¿Pregunta requiere Items de pregunta?
			if( tipo_preg >= 3 && tipo_preg <= 5 ) {
				$('#div_preg_items').removeClass('hidden');
				$('.valueItem').removeAttr('disabled').attr('required',true);
			} else {
				$('#div_preg_items').addClass('hidden');
				$('.valueItem').attr('disabled',true).removeAttr('required');
			}
		}).trigger('change');
	})
</script>
@endpush


<div class="col-xs-12 col-sm-12"> 
@include('widgets.forms.input', ['type'=>'text', 'name'=>'PREG_TITULO', 'label'=>'Título',
	'options'=>[
		'maxlength' => '50',
		'required',
	]])
</div>

<div class="col-xs-12 col-sm-12"> 
@include('widgets.forms.input', ['type'=>'textarea', 'name'=>'PREG_TEXTO', 'label'=>'Descripción', 'class'=>'hidden',
	'options'=>[
		'maxlength'   => '300',
		'placeholder' => 'Formule aquí la pregunta...',
		'required'
	]])
</div>


<div class="col-xs-12 col-sm-6">
@include('widgets.forms.input', ['type'=>'select', 'name'=>'PRTI_ID', 'label'=>'Tipo Pregunta:','data'=>$arrTiposPreguntas,
	'options'=>[
		'required',
	]])
</div>


<div class="col-xs-12 col-sm-6">
@include('widgets.forms.input', ['type'=>'checkbox2', 'name'=>'PREG_REQUERIDO', 'label'=>'¿Es obligatorio responderla?',
	'options'=>[]])
	{{-- 'style'=> 'position: relative; margin-left: 0px;', --}}
</div>

<div class="row">
	<div class='col-xs-12 col-sm-11 col-sm-offset-1'>
		<div id="div_preg_items" class="hidden">
			@rinclude('preg_items')
		</div>
	</div>
</div>


<!-- Botones -->
<div class="col-xs-12">
	@include('widgets.forms.buttons', ['url' => 'encuestas/'.$ENCU_ID])
</div>