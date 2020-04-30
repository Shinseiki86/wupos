@include('widgets.datepicker')
@include('widgets.select2')
@include('widgets.ckeditor')

<div class="col-xs-12 col-sm-8"> 
	@include('widgets.forms.input', ['type'=>'text', 'name'=>'ENCU_TITULO', 'label'=>'Título',
			'options'=>[
				'maxlength' => '50',
				$encuesta->isOpen() or $encuesta->isPublished() ? '' : 'readonly',
				'required',
			]])
</div>
<div class="col-xs-12 col-sm-4"> 
	@include('widgets.forms.input', ['type'=>'date', 'name'=>'ENCU_FECHAVIGENCIA', 'label'=>'Vigencia', 'withTime'=>true,
			'options'=>[
				'required'
			]])
</div>


<div class="col-xs-12 col-sm-12"> 
@include('widgets.forms.input', ['type'=>'textarea', 'name'=>'ENCU_DESCRIPCION', 'label'=>'Descripción', 'class'=>'ckeditor hidden',
		'options'=>[
			'maxlength'   => '3000',
			'placeholder' => 'Escriba aquí...',
			$encuesta->isOpen() or $encuesta->isPublished() ? '' : 'readonly',
			'required'
		]])
</div>


<!-- *************************************************** -->

<div class="col-xs-12 col-sm-6">
{{-- ¿Quiénes visualizarán la encuesta? --}}
	@include('widgets.forms.input', ['type'=>'select', 'name'=>'dirigidaA', 'label'=>'Dirigida a:','data'=>$arrRoles, 'multiple'=>true, 
		'options'=>[
			$encuesta->isOpen() ? '' : 'readonly',
			'required',
		]])
	@include('widgets.forms.input', ['type'=>'checkbox2', 'name'=>'ENCU_PARADOCENTE', 'label'=>'¿Evalúa a docentes?',
		'options'=>[
			$encuesta->isOpen() ? '' : 'readonly',
		]])

</div>

<!-- *************************************************** -->
<div class="col-xs-12 col-sm-6">

	@include('widgets.forms.input', ['type'=>'checkbox2', 'name'=>'ENCU_PLANTILLA', 'label'=>'¿Convertir en plantilla?',
		'options'=>[
			$encuesta->isOpen() ? '' : 'readonly',
		]])
	@include('widgets.forms.input', ['type'=>'checkbox2', 'name'=>'ENCU_PLANTILLAPUBLICA', 'label'=>'¿Es pública?', 'hidden'=>true,
		'options'=>[
			$encuesta->isOpen() ? '' : 'readonly',
		]])

</div>


