<div class="row">
	<div class="col-xs-12 col-sm-6">
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'empresa', 'label'=>'Empresa', 'ajax'=>['model'=>'Empleador','column'=>'EMPL_NOMBRECOMERCIAL']])
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'gerencia', 'label'=>'Gerencia', 'ajax'=>['model'=>'Gerencia','column'=>'GERE_DESCRIPCION']])
	</div>

	<div class="col-xs-12 col-sm-6">
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'centrocosto', 'label'=>'Centro de Costo', 'ajax'=>['model'=>'CentroCosto','column'=>'CECO_DESCRIPCION']])
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'temporal', 'label'=>'Temporal',  'ajax'=>['model'=>'Temporal','column'=>'TEMP_NOMBRECOMERCIAL']])
	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-sm-6">
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'negocio', 'label'=>'Negocio de Nómina', 'ajax'=>['model'=>'Negocio','column'=>'NEGO_DESCRIPCION']])

		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'cargo', 'label'=>'Cargo', 'ajax'=>['model'=>'Cargo','column'=>'CARG_DESCRIPCION']])
	</div>
	<div class="col-xs-12 col-sm-6">
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'grupo', 'label'=>'Grupo de Empleado', 'ajax'=>['model'=>'Grupo','column'=>'GRUP_DESCRIPCION']])
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'turno', 'label'=>'Turno', 'ajax'=>['model'=>'Turno','column'=>'TURN_DESCRIPCION']])
	</div>
</div>

<div class="row">
	<div class="col-xs-6 col-sm-6">
	@include('widgets.forms.input', ['type'=>'date', 'column'=>6, 'name'=>'fchaIngresoDesde', 'label'=>'Fecha ingreso desde'])
	@include('widgets.forms.input', ['type'=>'date', 'column'=>6, 'name'=>'fchaIngresoHasta', 'label'=>'Fecha ingreso hasta'])
	</div>

	<div class="col-xs-6 col-sm-6">
		@include('widgets.forms.input', ['type'=>'text', 'column'=>6, 'name'=>'prospecto', 'label'=>'No. de Documento' ])
	</div>
</div>






