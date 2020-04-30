<div class='col-md-8 col-md-offset-2'>

	@include('widgets.forms.input', ['type'=>'number', 'column'=>4, 'name'=>'REGI_CODIGO', 'label'=>'Código', 'options'=>['size' => '999999' ] ])
	@include('widgets.forms.input', ['type'=>'text', 'column'=>8, 'name'=>'REGI_NOMBRE', 'label'=>'Nombre', 'options'=>['maxlength' => '50'] ])

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'gyf/regionales'])

</div>