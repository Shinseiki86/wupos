@extends('layouts.menu')
@section('title', '/ Dashboard')

@section('page_heading')
	<div class="row">
		<div id="title" class="col-xs-8 col-md-6 col-lg-6">
			Dashboard
		</div>
		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
			
		</div>
	</div>
@endsection


@php 
	$charts = [[
		'title' => 'Usuarios x Rol',
		'chart' =>[
			'url'   => 'getDashboardUsuariosPorRol',
			'title' =>'Usuarios activos por rol',
			'columnX' =>'Rol',
			'columnY' =>'count',
			'type' =>'pie',
		]],[
		'title'    => 'Certificados x Regional',
		'column'   => 'col-xs-12 col-sd-12 col-lg-8',
		'chart' =>[
			'url'      => 'wu/getCertificadosPorRegional',
			'title' =>'Certificados por Regional',
			'columnX' =>'Regional',
			'columnY' =>'count',
			'type' =>'bar',
		]],[
		'title'    => 'Operadores x Regional',
		'column'   => 'col-xs-12 col-sd-12 col-lg-12',
		'chart' =>[
			'url'      => 'wu/getOperadoresPorRegional',
			'title' =>'Operadores por Regional',
			'columnX' =>'Regional',
			'columnY' =>'count',
			'type' =>'bar',
		]]
	];
@endphp


@section('section')
	@foreach($charts as $i => $chart)
		@include('widgets.charts.panelchart', $chart+['id'=>$i+1])
	@endforeach
@endsection

@push('scripts')
	{!! Html::script('js/chart.js/Chart.min.js') !!}
	{!! Html::script('js/momentjs/moment-with-locales.min.js') !!}
	{!! Html::script('js/chart.js/dashboard.js') !!}
	<script type="text/javascript">
		$(function () {

			//funciones newChart para crear gráfico en los panelchart.
			@stack('jsDashboard')

			//Se habilitan selectores para cambiar el tipo de gráfico
			$('.typeChart').removeClass('disabled');
		});
	</script>
@endpush