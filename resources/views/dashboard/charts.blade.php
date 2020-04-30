@extends('layouts.menu')
@section('title', '/ Dashboard')

@section('page_heading')
	<div class="row">
		<div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
			Dashboard
		</div>
		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
			
		</div>
	</div>
@endsection

@section('section')

	@include('widgets.charts.panelchart', ['idCanvas' => 'chart1', 'title' => 'Usuarios x Rol' ])

@endsection

@push('scripts')
	{!! Html::script('js/chart.js/Chart.min.js') !!}
	{!! Html::script('js/momentjs/moment-with-locales.min.js') !!}
	{!! Html::script('js/chart.js/dashboard.js') !!}
	<script type="text/javascript">
		$(function () {

			//función newChart para crear gráfico en los panelchart.
			newChart(
				'getDashboardUsuariosPorRol',
				'Usuarios x Rol',
				'Rol',
				'count',
				'chart1',
				'bar'
			);


			//Se habilitan selectores para cambiar el tipo de gráfico
			$('.typeChart').removeClass('disabled');
		});
	</script>
@endpush