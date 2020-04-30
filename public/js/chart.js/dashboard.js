moment.locale('es');
window.chart = [];
window.chartData = [];

$('.typeChart').on('change', function(ev) {
	var idCanvas = $(this).closest('.panel-chart').find('.canvas-chart').attr('id');
	var type = $(this).find(":selected").val();

	var chart = window.chart[idCanvas];
	var chartData = window.chartData[idCanvas][type];
	var opcs = getOptionsChart(type);
	opcs.title.text = chart.config.options.title.text;
	
	window.chart[idCanvas].destroy();
	var canvas = document.getElementById(idCanvas).getContext('2d');
	window.chart[idCanvas] = new Chart(canvas, {
		type: type,
		data: chartData,
		options: opcs
	});// Fin window.chart
	window.chart[idCanvas].update();
});

function newChart($route, $title, $nameX, $nameY, $idCanvas, $type){
	$.ajax({
		//async: false, 
		url: $route,
		dataType: "json",
		type: "GET",
		headers: {
			"X-CSRF-TOKEN": $('input[name="_token"]').val()
		},
		success: function($result) {
			var labels = [], data=[], colors=[];
			$result.forEach(function(packet) {
				labels.push(packet[$nameX]);
				data.push(parseInt(packet[$nameY]));
				if(typeof packet['COLOR'] == 'string'){ colors.push(packet['COLOR']); }
			});
			buildChart($title, labels, data, colors, $idCanvas, $type);
		},
		error: function($e){
			console.log('Error ajax: '+$e);
		}
	});
}

function buildChart($title, $labels, $data, $colors, $idCanvas, $type){

		var chartData = getChartData($labels, $data, $colors, $idCanvas, $type);
		var opcs = getOptionsChart($type);
		opcs.title.text = $title;

		var canvas = document.getElementById($idCanvas).getContext('2d');
		window.chart[$idCanvas] = new Chart(canvas, {
			type: $type,
			data: chartData,
			options: opcs
		});// Fin window.chart
		window.chart[$idCanvas].update();
	
}

//Genera colores aleatorios.
var randomColorFactor = function() {
	return Math.round(Math.random() * 255);
};
var randomColor = function() {
	return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',0.8)';
};

//Función para validar si un número es entero (Compatibilidad para IE11 e inferiores)
var isNumber = function(x) {
	return ! isNaN (x-0) && x !== null && x !== "" && x !== false;
}

//Retorna un color predeterminado en un array como RGB.
var getColor = function (name) {
	var colorsRGB = {
		'red':         'rgba(255,0,0,0.8)',
		'yellow':      'rgba(255,255,0,0.8)',
		'green':       'rgba(0,128,0,0.8)',
		'blue':        'rgba(0,0,255,0.8)',
		'magenta':     'rgba(255,0,255,0.8)',
		'cyan':        'rgba(0,255,255,0.8)',
		'orange':      'rgba(255,165,0,0.8)',
		'grey':        'rgba(128,128,128,0.8)',
		'deepskyblue': 'rgba(0,191,255,0.8)',
		'pink':        'rgba(255,192,203,0.8)',
		'saddlebrown': 'rgba(139,69,19,0.8)',
	};

	//Si name es un número, entonces se debe buscar el indice en el arreglo
	if(isNumber(name)){
		index = name;
		var keys = Object.keys(colorsRGB);
		if(index >= 0 && index < keys.length )
				return colorsRGB[keys[index]];
		else
				return randomColor();

	}//Sino, entonces se buscará por llave asociativa.
	else if (typeof colorsRGB[name.toLowerCase()] != 'undefined'){
		return colorsRGB[name.toLowerCase()];
	}

	//No se encontró...
	return false;
}; // Fin function $scope.getColor

//Adiciona porcentaje como texto en el gráfico de barras (bar)
var drawLabelBar = function (ctx, dataset) {
	for (var i = 0; i < dataset.data.length; i++) {
		var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
		if(ctx.canvas.clientWidth > 600){
			//ctx.font = '14px Arial';
			ctx.fillText(dataset.data[i], model.x, model.y -12);
		} else {
			ctx.save();
			// Translate 0,0 to the point you want the text
			ctx.translate(model.x, model.y);
			/*/ Rotate context by -90 degrees
			ctx.rotate(-90 * Math.PI / 180);*/

			// Draw text
			ctx.shadowColor = "white";
			ctx.shadowOffsetX = 1; 
			ctx.shadowOffsetY = 1;
			ctx.shadowBlur = 1;
			ctx.fillText(dataset.data[i], 2, -5);
			ctx.restore();
		}
	}
} // Fin function drawLabelBar

//Adiciona porcentaje como texto en el gráfico de torta (pie)
var drawLabelPie = function (obj) {
	var self = obj,
	chartInstance = obj.chart,
	ctx = chartInstance.ctx;

	ctx.font = '18px Arial';
	ctx.textAlign = "center";
	ctx.fillStyle = "#ffffff";

	Chart.helpers.each(self.data.datasets.forEach(function (dataset, datasetIndex) {
		var meta = self.getDatasetMeta(datasetIndex),
			total = 0, //total values to compute fraction
			labelxy = [],
			offset = Math.PI / 2, //start sector from top
			radius,
			centerx,
			centery, 
			lastend = 0; //prev arc's end line: starting with 0

		for (var val in dataset.data) {
				total += dataset.data[val];
		}

		Chart.helpers.each(meta.data.forEach( function (element, index) {
			radius = 0.9 * element._model.outerRadius - element._model.innerRadius;
			centerx = element._model.x;
			centery = element._model.y;
			var thispart = dataset.data[index],
				arcsector = Math.PI * (2 * thispart / total);
			if (element.hasValue() && dataset.data[index] > 0) {
				labelxy.push(lastend + arcsector / 2 + Math.PI + offset);
			}
			else {
				labelxy.push(-1);
			}
			lastend += arcsector;
		}), self) //Chart.helpers.each

		var lradius = radius * 3 / 4;
		for (var idx in labelxy) {
			if (labelxy[idx] === -1) continue;
			var langle = labelxy[idx],
			dx = centerx + lradius * Math.cos(langle),
			dy = centery + lradius * Math.sin(langle),
			val = dataset.data[idx] / total * 100;

			ctx.save();
			ctx.shadowColor = "black";
			ctx.shadowOffsetX = 1; 
			ctx.shadowOffsetY = 1; 
			ctx.shadowBlur = 1;
			ctx.fillText(val.toFixed(2) + ' %', dx, dy);
			ctx.restore();
		}
	}), self); //Chart.helpers.each
}// Fin function drawLabelPie

//Retorna json con las opcines para construir el gráfico según el tipo.
var getOptionsChart = function ($type) {
	switch($type){
		case 'bar':
			return {
				animation: {
					duration: 0,
					onComplete: function () {
						// render the value of the chart above the bar
						var ctx = this.chart.ctx;
						Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
						ctx.fillStyle = this.chart.config.options.defaultFontColor;
						ctx.textAlign = 'center';
						ctx.textBaseline = 'bottom';
						this.data.datasets.forEach(function (dataset) {
							drawLabelBar(ctx, dataset);
						});
					}
				},
				elements: {rectangle: {borderWidth: 2, borderSkipped: 'bottom'}},
				scales: {
					yAxes: [{ticks: {
							beginAtZero: true,
							min: 0,
							//stepSize: 1,
							fontSize: 16
					}}],
					xAxes: [{ticks: {fontSize: 16}}]
				},
				maintainAspectRatio: false,
				responsive: true,
				title: {
					display: true,
					fontSize: 20,
					padding: 30
				},
				legend: {position:'bottom'}
			};
		break;
	
		case 'pie':
			return {
				maintainAspectRatio: false,
				responsive: true,
				title: {
					display: true,
					fontSize: 20
				},
				legend: {
					position: 'bottom',
					onClick: null,
					labels: {fontSize: 16}
				},
				animation: {
					duration: 0,
					onComplete: function(){ drawLabelPie(this); }
				}
			};
		break;
	}
}// Fin function getOptionsChart


//Retorna json con las opcines para construir el gráfico según el tipo.
var getChartData = function ($labels, $data, $colors, $idCanvas, $type){
	var $datasets = [];
	window.chartData[$idCanvas] = [];

	$labels.forEach(function ($label, $index) {
		$colors.push(getColor($index));
		$datasets.push( {
			label: $label,
			backgroundColor: [$colors.length != 0 ? $colors[$index] : getColor($index)],
			data: [$data[$index]]
		});
	});
	
	window.chartData[$idCanvas]['bar'] = {
		labels:  [''],
		datasets: $datasets
	};
	

	if($colors.length === 0){
		$labels.forEach(function ($label, $index) {
			$colors.push(getColor($index));
		});
	}
	window.chartData[$idCanvas]['pie'] = {
		labels: $labels,
		datasets: [{
			backgroundColor: $colors,
			data: $data,
		}]
	};

	return window.chartData[$idCanvas][$type];
}// Fin function getOptionsChart


//Muestra mensaje cuando no hay datos para construir el gráfico.
Chart.plugins.register({
	afterDraw: function(chart) {
		if (chart.data.datasets[0].data.length === 0) {
			// No data is present
			var ctx = chart.chart.ctx;
			var width = chart.chart.width;
			var height = chart.chart.height
			chart.clear();

			ctx.save();
			ctx.textAlign = 'center';
			ctx.textBaseline = 'middle';
			ctx.font = "16px normal 'Helvetica Nueue'";
			ctx.fillText('No hay datos para mostrar', width / 2, height / 2);
			ctx.restore();
		}
	}
});
