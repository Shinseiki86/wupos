<div class="{{isset($column) ? $column : 'col-xs-12 col-sd-6 col-lg-4'}}">
	<div class="panel panel-info panel-chart">
		<div class="panel-heading">
			{{$title}}
			<div class="panel-control pull-right">
				<select id="type_chart{{$id}}" class="typeChart" disabled>
					<option value="" disabled selected hidden></option>
					<option value="bar">Barras</option>
					<option value="pie">Torta</option>
					<option value="line">Lineas</option>
				</select>
				{{--<a class="panelButton"><i class="fas fa-sync-alt"></i></a>
				<a class="panelButton"><i class="fas fa-minus"></i></a>
				<a class="panelButton"><i class="fas fa-times"></i></a>--}}
			</div>
		</div>
		<div class="panel-body">
			<canvas class="canvas-chart" id="chart{{$id}}" style="height:350px"></canvas>
		</div>
	</div>
</div>

@push('jsDashboard')
	newChart(
		'{{$chart['url']}}',
		'{!!isset($chart['title']) ? $chart['title'] : $title!!}',
		'{{$chart['columnX']}}',
		'{{$chart['columnY']}}',
		'chart{{$id}}',
		'{{$chart['type']}}',
	);
@endpush