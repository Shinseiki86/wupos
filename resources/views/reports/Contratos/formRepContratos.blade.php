
@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'empresa', 'label'=>'Empresa', 'ajax'=>['model'=>'Empleador','column'=>'EMPL_NOMBRECOMERCIAL']])
@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'gerencia', 'label'=>'Gerencia', 'ajax'=>['model'=>'Gerencia','column'=>'GERE_DESCRIPCION']])

@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'centrocosto', 'label'=>'Centro de Costo', 'ajax'=>['model'=>'CentroCosto','column'=>'CECO_DESCRIPCION']])
@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'temporal', 'label'=>'Temporal',  'ajax'=>['model'=>'Temporal','column'=>'TEMP_NOMBRECOMERCIAL']])

@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'cargo', 'label'=>'Cargo', 'ajax'=>['model'=>'Cargo','column'=>'CARG_DESCRIPCION']])
@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'grupo', 'label'=>'Grupo de Empleado', 'ajax'=>['model'=>'Grupo','column'=>'GRUP_DESCRIPCION']])

@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'turno', 'label'=>'Turno', 'ajax'=>['model'=>'Turno','column'=>'TURN_DESCRIPCION']])
@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'estado', 'label'=>'Estado de Contrato', 'ajax'=>['model'=>'EstadoContrato','column'=>'ESCO_DESCRIPCION']])

@include('widgets.forms.input', ['type'=>'date', 'column'=>6, 'name'=>'fchaIngresoDesde', 'label'=>'Fecha ingreso desde' ])
@include('widgets.forms.input', ['type'=>'date', 'column'=>6, 'name'=>'fchaIngresoHasta', 'label'=>'Fecha ingreso hasta' ])

@include('widgets.forms.input', ['type'=>'text', 'column'=>12, 'name'=>'prospecto', 'label'=>'No. de Documento' ])
