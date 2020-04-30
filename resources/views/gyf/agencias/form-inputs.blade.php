@include('widgets.select2')

<div class='col-md-8 col-md-offset-2'>

	@include('widgets.forms.input', ['type'=>'number', 'column'=>4, 'name'=>'AGEN_CODIGO', 'label'=>'Código', 'options'=>['size' => '999999' ] ])

	@include('widgets.forms.input', ['type'=>'text', 'column'=>8, 'name'=>'AGEN_CUENTAWU', 'label'=>'Cuenta WU', 'options'=>['maxlength' => '100'] ])

	@include('widgets.forms.input', ['type'=>'text', 'column'=>11, 'name'=>'AGEN_NOMBRE', 'label'=>'Nombre', 'options'=>['maxlength' => '100'] ])

	@include('widgets.forms.input', ['type'=>'checkbox', 'column'=>1, 'name'=>'AGEN_ACTIVA', 'label'=>'Habilitado' ])

	@include('widgets.forms.input', ['type'=>'select',  'name'=>'REGI_ID', 'label'=>'Regional', 'data'=>$arrRegionales])


	@include('widgets.forms.input', [ 'type'=>'textarea', 'name'=>'AGEN_DESCRIPCION', 'label'=>'Descripción', 'options'=>['maxlength' => '300'] ])

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'gyf/agencias'])

</div>