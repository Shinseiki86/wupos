<div class='col-md-8 col-md-offset-2'>

	@include('widgets.forms.input', ['type'=>'text', 'column'=>8, 'name'=>'PRTI_DESCRIPCION', 'label'=>'Descripción', 'options'=>['maxlength' => '25'] ])

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'encuestas/preguntatipos'])

</div>