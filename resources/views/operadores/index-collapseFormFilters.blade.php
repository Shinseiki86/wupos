@section('head')
	@parent
	<style>
		/* Define el tamaño de los input-group-addon para que sean todos iguales */
		.input-group-addon {
			min-width:100px;
			text-align:left;
		}
	</style>
@endsection

<div id="filters" class="collapse">
	<div class="form-group col-xs-12 col-md-8">
	<form>

		<div class="input-group">
			<div class="input-group-addon">Regional</div>
			{{ Form::select('REGI_id', [null => 'Seleccione una Regional...'] + $arrRegionales , old('REGI_id'), ['class' => 'form-control', 'required']) }}
		</div>

		<div class="input-group">
			<div class="input-group-addon">Estado</div>
			{{ Form::select('ESOP_id', $arrEstados , old('ESOP_id') or '1', ['class' => 'form-control', 'required']) }}
		</div>


		{{ Form::button( '<i class="fa fa-undo" aria-hidden="true"></i> Reset', ['class'=>'btn btn-warning', 'ng-click'=>'searchOperador = []'] ) }}
	</form>
	</div>
</div>