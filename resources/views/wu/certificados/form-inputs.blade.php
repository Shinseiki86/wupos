@include('widgets.select2')

<div class='col-md-8 col-md-offset-2'>

	@include('widgets.forms.input', ['type'=>'text', 'column'=>4, 'name'=>'CERT_CODIGO', 'label'=>'Código', 'options'=>['maxlength' => '100'] ])

	@include('widgets.forms.input', ['type'=>'text', 'column'=>6, 'name'=>'CERT_EQUIPO', 'label'=>'Hostname', 'options'=>['maxlength' => '100'] ])

	@include('widgets.forms.input', ['type'=>'select', 'name'=>'REGI_ID', 'label'=>'Regional', 'data'=>$arrRegionales])

	@include('widgets.forms.input', ['type'=>'select', 'name'=>'AGEN_ID', 'label'=>'Agencia', 'data'=>$arrAgencias])
	@include('widgets.select-dependiente', ['url'=>'wu/certificados/filterAgencia', 'selectPadre'=>'REGI_ID', 'selectHijo'=>'AGEN_ID', 'nombreBusqueda'=>'AGEN_NOMBRE'])


	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'wu/certificados'])

</div>