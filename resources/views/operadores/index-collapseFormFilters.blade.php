@section('head')
	<style>
		/* Define el tamaño de los input-group-addon para que sean todos iguales */
		.input-group-addon {
			min-width:100px;
			text-align:left;
		}
		.filter{ padding: 0px; }
	</style>
@parent
@endsection

@section('scripts')

	<script type="text/javascript">
		var filtered = {{ isset($filtered) ? 'true' : 'false' }};
		if(filtered)
			$('#filters').collapse("show");
	</script>
	
@parent
@endsection

@section('scripts')
@parent
{!! Html::script('assets/js/bootstrap/bootstrap-multiselect.js') !!}
<script type="text/javascript">
	$(function () {
	});
</script>
@endsection


<div id="filters" class="collapse">
	<div class="form-group col-xs-12 col-md-8">
	{{ Form::open(['url' => 'operadores/search', 'method' => 'GET', 'class' => 'form-vertical']) }}
		<div class="row">
			<div class="col-xs-4 filter">
				{{ Form::number('OPER_codigo', Request::get('OPER_codigo'), [
					'class'=>'form-control', 'placeholder'=>'Código Operador...',
				])}}
			</div>
			<div class="col-xs-8 filter">
				{{ Form::number('OPER_cedula', Request::get('OPER_cedula'), [
					'class'=>'form-control', 'placeholder'=>'Cédula...',
				])}}
			</div>
			<div class="col-xs-6 filter">
				{{ Form::text('OPER_nombre', Request::get('OPER_nombre'), [
					'class'=>'form-control', 'placeholder'=>'Nombres...',
				])}}
			</div>
			<div class="col-xs-6 filter">
				{{ Form::text('OPER_apellido', Request::get('OPER_apellido'), [
					'class'=>'form-control', 'placeholder'=>'Apellidos...',
				])}}
			</div>
			<div class="col-xs-12 col-sm-6 filter">
				<div class="input-group">
					<div class="input-group-addon">Regional</div>
					{{ Form::select('REGI_id', [null => 'Todas'] + $arrRegionales , old('REGI_id'), [
						'id'=>'REGI_id',
						'data-placeholder'=>'Seleccione una regional...',
						'class' => 'form-control',
					]) }}
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 filter">
				<div class="input-group">
					<div class="input-group-addon">Estado</div>
					{{ Form::select('ESOP_id', [null => 'Todos'] + $arrEstados , old('ESOP_id'), [
						'id'=>'ESOP_id',
						'data-placeholder'=>'Seleccione un estado...',
						'class' => 'form-control',
					]) }}
				</div>
			</div>

			<div class="col-xs-12 filter">
				<div class="pull-right">
					{{ Form::button('<i class="fa fa-search" aria-hidden="true"></i> Buscar', [
						'class'=>'btn btn-primary',
						'type'=>'submit',
					]) }}
				</div>
			</div>
		</div>
	{{ Form::close() }}
	</div>
</div>


