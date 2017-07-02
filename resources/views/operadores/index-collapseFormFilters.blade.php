@section('head')
	<style>
		/* Define el tamaño de los input-group-addon para que sean todos iguales */
		.input-group-addon {
			min-width:100px;
			text-align:left;
		}
	</style>
@parent
@endsection

<div id="filters" class="collapse" uib-collapse="!isFiltered">
	<div class="form-group col-xs-12">
	<form id='frmFilter' class="form-inline">
	
		<div class="input-group has-feedback">
			<div class="input-group-addon control-label">Operador</div>
			<input type="text" class="form-control"
				placeholder="Por código..."
				ng-model="searchOperador.OPER_codigo">
			<span ng-if="searchOperador.OPER_codigo"
				name="btnClear"
				ng-click="searchOperador.OPER_codigo = ''"
				class="glyphicon glyphicon-remove-circle form-control-feedback"
				uib-tooltip="Borrar"></span>
		</div>

		<div class="input-group has-feedback">
			<div class="input-group-addon control-label">Cédula</div>
			{{ Form::text('OPER_cedula', null, ['class'=>'form-control', 'placeholder'=>'Por cédula...', 'ng-model'=>'searchOperador.OPER_cedula']) }}
			<span name="btnClear" class="hide glyphicon glyphicon-remove-circle form-control-feedback"></span>
		</div>
		<div class="input-group has-feedback">
			<div class="input-group-addon control-label">Nombre</div>
			{{ Form::text('OPER_nombre', null, ['class'=>'form-control', 'placeholder'=>'Por nombre del operador...', 'ng-model'=>'searchOperador.OPER_nombre']) }}
			<span name="btnClear" class="hide glyphicon glyphicon-remove-circle form-control-feedback"></span>
		</div>
		<div class="input-group has-feedback">
			<div class="input-group-addon control-label">Apellido</div>
			{{ Form::text('OPER_apellido', null, ['class'=>'form-control', 'placeholder'=>'Por apellido del operador...', 'ng-model'=>'searchOperador.OPER_apellido']) }}
			<span name="btnClear" class="hide glyphicon glyphicon-remove-circle form-control-feedback"></span>
		</div>

		<div class="input-group">
			<div class="input-group-addon">Regional</div>
			<select type="text" class="form-control" ng-model="searchOperador.REGI_nombre">
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
			<select type="text" class="form-control" ng-model="searchOperador.ESOP_descripcion">
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
