@section('head')
	<style>
		/* Define el tamaño de los input-group-addon para que sean todos iguales */
		.input-group-addon {
			min-width:100px;
			text-align:left;
		}
		span[name=btnClear]{
			z-index: 999;
			cursor: pointer;
			pointer-events: all;
		}
		.filter{ padding: 0px; }
	</style>
@endsection

@section('scripts')
@parent
<script type="text/javascript">
$(function () {
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
	$('input[name=OPER_codigo]').on('input change', function() {
		filterTable(this, '.codigo');
	});
	$('input[name=OPER_cedula]').on('input', function() {
		filterTable(this, '.cedula');
	});
	$('input[name=OPER_nombre]').on('input', function(event) {
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

		$('#frmFilter').find('input').trigger('input');
		//$('input[name^=REGI_]').val('').trigger('change');

		$('span[name=btnClear]').addClass('hide');
		tbIndex.search('', true, true).draw();
	});
});
</script>
@endsection


<div id="filters" class="collapse">
	<div class="form-group col-xs-12">
	<form id='frmFilter' class="form-inline">
		<div class="input-group has-feedback">
			<div class="input-group-addon control-label">Operador</div>
			{{ Form::text('OPER_codigo', null, ['class'=>'form-control', 'placeholder'=>'Por código...']) }}
			<span name="btnClear" class="hide glyphicon glyphicon-remove-circle form-control-feedback"></span>
		</div>

		<div class="input-group has-feedback">
			<div class="input-group-addon control-label">Cédula</div>
			{{ Form::text('OPER_cedula', null, ['class'=>'form-control', 'placeholder'=>'Por cédula...']) }}
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
				<option value="">Todos</option>
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
