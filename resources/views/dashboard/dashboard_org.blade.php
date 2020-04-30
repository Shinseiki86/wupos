@extends('layout')

@section('scripts')
	{!! Html::script('assets/js/jquery/jquery.countdown.min.js') !!}
	{!! Html::script('assets/js/momentjs/moment-with-locales.min.js') !!}
	{!! Html::script('assets/js/chart.js/Chart.min.js') !!}

	<script type="text/javascript">
		moment.locale('es');
		/*
		var appDashboard = angular.module('appDashboard', [], function($interpolateProvider) {
			$interpolateProvider.startSymbol('{%');
			$interpolateProvider.endSymbol('%}');
		});
		
		appDashboard.controller('DashboardCtrl', function($scope, $interval, $http){

			//Para que sea en tiempo real, se debe implementar "server push", sino se corre riesgo de saturar el servidor con peticiones.
			//https://es.wikipedia.org/wiki/Comet
			//https://es.wikipedia.org/wiki/Tecnolog%C3%ADa_Push

			var getEncuestas = function(){
				//location.reload();
				$http.get('encuestas/getEncuestas')
					.then(function(response) {
						$scope.encuestas = response.data;
						console.log('jsonEncuestas: '+JSON.stringify($scope.encuestas));
						$scope.loading = false;
					});
			}
			getEncuestas();
			$interval(getEncuestas, 1*60*1000); //1 min (1000==1seg)
		});*/

		$(document).ready(function () {
			//Formato de fecha
			var formatDate = function(strDate){
				var strDateFormatted = '';
				if(strDate != null && strDate != '')
					strDateFormatted = moment(strDate).format('DD/MM/YYYY hh:mm A');
				return strDateFormatted;
			}
			
			//Minutos para recargar la página
			if(! localStorage.minutos){localStorage.minutos = 5;}
			$('#minutos').val(localStorage.minutos);
			$('#minutos').change(function() {
				localStorage.minutos = $(this).val();
				location.reload();
			});
			
			window.setInterval(function(){
				location.reload();
			}, localStorage.minutos*60*1000); //1 min (1000==1seg)

			//Aplicando formato a las fechas
			var encuestas = $('.encuesta');
			encuestas.each(function( index ) {
				var encuesta = $( this );
				var fechaVigencia = encuesta.find('.fechaVigencia');
				var fechaPublicacion = encuesta.find('.fechaPublicacion');

				//Formato para el contador de tiempo
				var formatCounterTime = '%-w semana%!w %-d día%!D';
				//Contador para finalizar la fecha de vigencia de la encuesta
				encuesta.find('.counterTime').countdown(fechaVigencia.text(), {elapse: true})
				.on('update.countdown', function(event) {
					var weeks = event.offset.weeks;
					var days = event.offset.totalDays;

					if(weeks == 0)
						formatCounterTime = '%-d día%!D %H:%M:%S';
					if(weeks==0 && days==0)
						formatCounterTime = '%H:%M:%S';

					var $this = $(this);
					if (event.elapsed) {
						encuesta.addClass('bg-danger');
					} else {
						if(days == 0){
							encuesta.addClass('bg-warning');
						} else {
							encuesta.addClass('bg-success');
						}
					}
					$this.html(event.strftime(formatCounterTime));
				});

				//Se da formato a la fecha publicación.
				var fechaStr = formatDate(fechaPublicacion.text().trim());
				fechaPublicacion.html(fechaStr);
				//Se da formato a la fecha vigencia.
				var fechaStr = formatDate(fechaVigencia.text().trim());
				fechaVigencia.html(fechaStr);
			});



			//Agrupación de fecha para mostrar en la línea de tiempo
			if(! localStorage.groupResps) {localStorage.groupResps = 'week';}
			$('#groupResps').val(localStorage.groupResps);
			$('#groupResps').change(function() {
				localStorage.groupResps = $(this).val();
				window.chartLineResps.options.scales.xAxes[0].time.unit = localStorage.groupResps;
				window.chartLineResps.update();
			});

			var fechas = {!! json_encode($resps['fechacreado'] ,JSON_NUMERIC_CHECK) !!}
			var countResps = {!! json_encode($resps['count'] ,JSON_NUMERIC_CHECK) !!};

			var chartData = {
				labels: fechas,
				datasets: [{
					label: 'Registros',
					fill: false,
					lineTension: 0.1,
					backgroundColor: 'rgba(75,192,192,0.4)',
					borderColor: 'rgba(75,192,192,1)',
					borderCapStyle: 'butt',
					borderDash: [],
					borderDashOffset: 0.0,
					borderJoinStyle: 'miter',
					pointBorderColor: 'rgba(75,192,192,1)',
					pointBackgroundColor: '#fff',
					pointBorderWidth: 1,
					pointHoverRadius: 5,
					pointHoverBackgroundColor: 'rgba(75,192,192,1)',
					pointHoverBorderColor: 'rgba(220,220,220,1)',
					pointHoverBorderWidth: 2,
					pointRadius: 1,
					pointHitRadius: 10,
					data: countResps,
					spanGaps: false,
				}]
			};

			var opcs = {
				maintainAspectRatio: false,
				responsive: true,
				title: {
					display: false,
					fontSize: 20,
					text: 'Actividad en el sistema'
				},
				scales: {
					xAxes: [{
						type: 'time',
						time: {
							min: fechas[0],
							max: fechas[fechas.length-1],
							unit: localStorage.groupResps,
							tooltipFormat: 'dddd, L',
							displayFormats: {
								day: 'ddd DD-MMM',
								week: 'DD-MMM',
								month: 'MMMM'
							}
						},
						scaleLabel: {
							display: true,
							labelString: 'Fecha'
						}
					}],
					yAxes: [{
						scaleLabel: {
							display: true,
							labelString: 'Registro'
						}
					}]
				},
				legend: {
					display: false,
					position: 'top',
					onClick: null,
					labels: {
						fontSize: 16
					}
				},
			};

			var canvas = document.getElementById('chartLineResps').getContext('2d');
			window.chartLineResps = new Chart(canvas, {
				type: 'line',
				data: chartData,
				options: opcs
			}); // Fin window.chartLineResps
			window.chartLineResps.update();
		});
	</script>
@parent
@endsection

@section('content')
	<h1 class="page-header">Dashboard</h1>

	<ul class="list-group">
		<li class="list-group-item">
			Total encuestas publicadas: <span>{{$encuestas->count()}}</span>
			<div class="pull-right">
				Actualizar cada 
				<select id="minutos">
					<option value="0.17">10 segundos</option>
					<option value="0.5">30 segundos</option>
					<option value="1">1 minuto</option>
					<option value="5">5 minutos</option>
					<option value="10">10 minutos</option>
				</select>
			</div>
		</li>
	</ul>

	<table id="tbIndex" class="table table-bordered">
		<thead>
			<tr class="active">
				<th class="col-sm-3">Encuesta</th>
				<th class="col-sm-1">Resps</th>
				<th class="hidden-xs col-sm-2">Publicada</th>
				<th class="hidden-xs col-sm-2">Vence</th>
				<th class="hidden-xs col-sm-1">Últ. mov.</th>
				<th class="col-sm-2">Cierra en</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($encuestas as $encuesta)
			<tr class="encuesta">
				<td>
					<a href="{{ url('encuestas/'.$encuesta->ENCU_ID) }}">
						{{ $encuesta->ENCU_ID .' - '. $encuesta->ENCU_TITULO }}
					</a>
				</td>
				<td>{{ $encuesta->count_resps }}</td>
				<td class="hidden-xs fechaPublicacion">
					{{ $encuesta->ENCU_FECHAPUBLICACION }}
				</td>
				<td class="hidden-xs fechaVigencia">
					{{ $encuesta->ENCU_FECHAVIGENCIA }}
				</td>
				<td class="hidden-xs">
					{{ $encuesta->fecha_ult_resp ? $encuesta->fecha_ult_resp->diffForHumans() : 'Sin respuestas' }}
				</td>
				<td class="counterTime"></td>
				<td class="hidden-xs botones">
					<!-- botón para ver -->
					<a class="btn btn-xs btn-success" href="{{ url('encuestas/'.$encuesta->ENCU_ID) }}" role="button" data-tooltip="tooltip" title="Ver encuesta">
						<span class="glyphicon glyphicon-eye-open"></span>
					</a>
					<!-- botón de reporte -->
					<a class="btn btn-xs btn-info" href="{{ url('encuestas/'.$encuesta->ENCU_ID.'/reportes/loading') }}" role="button" data-tooltip="tooltip" title="Ver reportes">
						<i class="fas fa-chart-line" aria-hidden="true"></i>
					</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	<div class="col-xs-12 col-md-6">
		<div class="panel panel-info" >
			<div class="panel-heading">
				Actividad en el sistema
				<div class="pull-right">
					Agrupar por
					<select id="groupResps">
						<option value="day">dia</option>
						<option value="week">semana</option>
					</select>
				</div>
			</div>
			<div class="panel-body">
				<canvas class="canvas-chart" id="chartLineResps" style="height:250px"></canvas>
			</div>
		</div>
	</div>
	<!--div class="col-xs-12 col-md-6">
		<div class="panel panel-info" >
			<div class="panel-heading">
				Gráficas
				<div class="pull-right">
					Agrupar por
					<select id="groupOther">
						<option value="day">dia</option>
						<option value="week">semana</option>
					</select>
				</div>
			</div>
			<div class="panel-body">
				<canvas class="canvas-chart" id="chartLine" style="height:250px"></canvas>
			</div>
		</div>
	</div-->


@endsection
