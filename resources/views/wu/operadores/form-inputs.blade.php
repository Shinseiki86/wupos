@include('widgets.select2')

<div class='col-md-8 col-md-offset-2'>

	@include('widgets.forms.input', ['type'=>'text', 'column'=>4, 'name'=>'OPER_CODIGO', 'label'=>'Código', 'options'=>['maxlength' => '100'] ])

	@include('widgets.forms.input', ['type'=>'number', 'column'=>4, 'name'=>'OPER_CEDULA', 'label'=>'Cédula', 'options'=>['size' => '999999999999999' ] ])

	@include('widgets.forms.input', ['type'=>'select', 'column'=>4, 'name'=>'ESOP_ID', 'label'=>'Estado', 'data'=>$arrEstados])

	@include('widgets.forms.input', ['type'=>'text', 'column'=>6, 'name'=>'OPER_NOMBRE', 'label'=>'Nombre', 'options'=>['maxlength' => '100'] ])
	@include('widgets.forms.input', ['type'=>'text', 'column'=>6, 'name'=>'OPER_APELLIDO', 'label'=>'Apellido', 'options'=>['maxlength' => '100'] ])


	@include('widgets.forms.input', ['type'=>'select',  'name'=>'REGI_ID', 'label'=>'Regional', 'data'=>$arrRegionales])



	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'wu/operadores'])

</div>