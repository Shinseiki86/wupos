@section('head')
{!! Html::style('assets/css/bootstrap-multiselect.css') !!}
<style>
	/* Define el tamaño de los input-group-addon para que sean todos iguales */
	.input-group-addon {
		min-width:100px;
		text-align:left;
	}
	span[name=btnClear] {
		cursor: pointer;
		pointer-events: all;
		z-index: 99; 
	}
</style>
@parent
@endsection



@section('scripts')
@parent
{!! Html::script('assets/js/bootstrap/bootstrap-multiselect.js') !!}
<script type="text/javascript">
$(function () {

	//Campos con multiselect
	var optionsMultiSelect = {
		includeSelectAllOption: true,
		maxHeight: 400,
		dropUp: true,
		//buttonWidth: '300px',
		selectAllText: ' Todos',
		nonSelectedText: 'Ninguno',
		nSelectedText: 'seleccionados',
		allSelectedText: 'Todos'
	};
	$('#REGI_nombre').multiselect(optionsMultiSelect);
	$('#ESOP_descripcion').multiselect(optionsMultiSelect);
	//$('#ESOP_descripcion').multiselect('selectAll', false);
	//$('#ESOP_descripcion').multiselect('updateButtonText');


	//Si la tabla no se ha inicializado como DataTable, se declara tbIndex
	if ( $.fn.dataTable.isDataTable( '#tbIndex' ) ) {
		var tbIndex = $('#tbIndex').DataTable();
	}

	/*
	$.fn.dataTable.ext.search.push(
		function( settings, data, dataIndex ) {
			console.log(dataIndex);
			var input_nombre_completo = $('input[name=OPER_nombre_completo]').val();
			var data_nombre_completo = data[3] + data[4];

			console.log('  input_nombre_completo = '+input_nombre_completo);
			console.log('  data_nombre_completo  = '+data_nombre_completo);
			console.log('  equal? '+data_nombre_completo.search(input_nombre_completo) );

			if ( data_nombre_completo.search(input_nombre_completo) )
			{
				return true;
			}
			return false;
		}
	);*/

	//Búsqueda global en la tabla
	$('input[name=searchOperador]').on('input', function() {
	    tbIndex.search($(this).val(), true, true).draw();
		$(this).next().removeClass('hide');
	});
	//Búsquedas por columna
	$('input[name=OPER_codigo]').on('input', function() {
		filterTable(this, '.codigo');
	});
	$('input[name=OPER_cedula]').on('input', function() {
		filterTable(this, '.cedula');
	});
	$('input[name=OPER_nombre]').on('input', function() {
		filterTable(this, '.nombres');
	});
	$('input[name=OPER_apellido]').on('input', function() {
		filterTable(this, '.apellidos');
	});
	$('select[name=REGI_nombre]').on('change', function() {
		filterTable(this, '.regional');
	});
	$('select[name=ESOP_descripcion]').on('change', function() {
		filterTable(this, '.estado');
	});

	function filterTable(input, column) {
		tbIndex
			.columns( column )
			.search( input.value )
			.draw();
		//$(this).parent().find('span[name=btnClear]').removeClass('hide');
		$(input).next().removeClass('hide');
	}

	$('span[name=btnClear]').on('click', function() {
		$(this).prev().val('');
		$(this).prev().trigger('input');
		$(this).addClass('hide');
	});
	$('#resetFilter').on('click', function() {
		$('#frmFilter').trigger("reset");
		//$('input[name^=OPER_]').val('').trigger('input');
		//$('input[name^=REGI_]').val('').trigger('change');
		$('span[name=btnClear]').addClass('hide');
	});
});
</script>
@endsection



<div id="filters" class="collapse">
	<div class="form-group col-xs-12 col-md-8">
	<form id='frmFilter'>
		<div class="input-group has-feedback">
			<div class="input-group-addon control-label">Operador</div>
			{{ Form::number('OPER_codigo', null, ['class'=>'form-control', 'placeholder'=>'Por código...']) }}
			<span name="btnClear" class="hide glyphicon glyphicon-remove-circle form-control-feedback"></span>
		</div>

		<div class="input-group has-feedback">
			<div class="input-group-addon control-label">Cédula</div>
			{{ Form::number('OPER_cedula', null, ['class'=>'form-control', 'placeholder'=>'Por cédula...']) }}
			<span name="btnClear" class="hide glyphicon glyphicon-remove-circle form-control-feedback"></span>
		</div>

		<div class="input-group has-feedback">
			<div class="input-group-addon control-label">Nombre</div>
			{{ Form::text('OPER_nombre', null, ['class'=>'form-control', 'placeholder'=>'Por nombre del operador...']) }}
			<span name="btnClear" class="hide glyphicon glyphicon-remove-circle form-control-feedback"></span>
		</div>
		<div class="input-group has-feedback">
			<div class="input-group-addon control-label">Apellido</div>
			{{ Form::text('OPER_apellido', null, ['class'=>'form-control', 'placeholder'=>'Por apellido del operador...']) }}
			<span name="btnClear" class="hide glyphicon glyphicon-remove-circle form-control-feedback"></span>
		</div>

		<div class="input-group">
			<div class="input-group-addon">Regional</div>
			<select type="text" class="form-control" name="REGI_nombre" id="REGI_nombre">
				<option value="">Todas</option>
				@foreach($arrRegionales as $regional)
				<option value="{{ $regional }}">
					{{ $regional }}
				</option>
				@endforeach
			</select>
		</div>
		<div class="input-group">
			<div class="input-group-addon">Estado</div>
			<select type="text" class="form-control" name="ESOP_descripcion" id="ESOP_descripcion">
				<option value="">Todas</option>
				@foreach($arrEstados as $estado)
				<option value="{{ $estado }}">
					{{ $estado }}
				</option>
				@endforeach
			</select>
		</div>
		{{ Form::button( '<i class="fa fa-undo" aria-hidden="true"></i> Reset', ['class'=>'btn btn-warning', 'id'=>'resetFilter'] ) }}
	</form>
	</div>
</div>

