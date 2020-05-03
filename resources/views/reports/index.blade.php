@extends('layouts.menu')
@section('title', '/ Reportes')

@include('widgets.datatable.datatable-export')
@include('widgets.datepicker')
@include('widgets.select2')

@section('page_heading')
	<div class="row">
		<div id="title" class="col-xs-8 col-md-6 col-lg-6">
			Reportes
		</div>
		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
		</div>
	</div>
@endsection

@section('section')

	@include('widgets.forms.input', ['type'=>'select', 'column'=>10, 'name'=>'REPO_ID', 'label'=>'Seleccionar reporte', 'data'=>array_pluck($arrReports, 'display', 'route')])

	<div class="col-xs-2 hide btnViewForm">
		<button type="button" id="btnViewForm" class="btn btn-link">
			<span class="fa fa-caret-down iconBtn"></span>
			<span class="textBtn">Filtros</span>
		</button>
	</div>

	{{ Form::open(['url' => 'getData/', 'id'=>'formRep', 'class'=>'form-horizontal hide']) }}
		<div class="col-xs-12" >
			<div id="fieldsForm" class="hide">Filtros</div>
			@rinclude('index-botones')
		</div>
	{{ Form::close() }}


	{{-- REPORTE --}}
	<div id="tabsReport" class="hide">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tabTable" data-toggle="tab">Reporte</a></li>
			<li><a href="#tabGraf" data-toggle="tab">Gráfico</a></li>
			<div class="ctrlChart hide">
				<div class="col-xs-7 col-sm-5">
					{{ Form::select('columnChart', [''=>''], null, [
						'id'=>'columnChart',
						'class'=>'form-control selectpicker',
						'data-allow-clear'=>'true',
						'data-placeholder'=>'Seleccione una columna',
					])}}
				</div>
				<div class="col-xs-5 col-sm-2" >
					{{ Form::select('typeChart', ['bar'=>'Barras','pie'=>'Torta'], 'bar', [
						'id'=>'typeChart',
						'class'=>'form-control',
					])}}
				</div>
			</div>
		</ul>

		<div class="tab-content">
			<div class="tab-pane active" id="tabTable">
				<table id="tbQuery" class="table table-striped">
					<thead><tr><th></th></tr></thead>
					<tbody><tr><td></td></tr></tbody>
				</table>        	
			</div>
			<div class="tab-pane" id="tabGraf">
				<canvas class="canvas-chart" id="chart" style="height:380px; min-height: 300px"></canvas>
			</div>
		</div>
	</div>

	<div class="col-xs-12 showErr">
		<code id="err" class="hide"></code>
	</div>

@endsection


@push('scripts')
	{!! Html::script('js/chart.js/Chart.min.js') !!}
	{!! Html::script('js/momentjs/moment-with-locales.min.js') !!}
	{!! Html::script('js/chart.js/dashboard.js') !!}
	<script type="text/javascript">

	$(function () {

		var nameApp = '{{config('app.name', 'MyApp')}}';
		var formRep = $('#formRep');
		var btnViewForm = $('#btnViewForm');
		var fieldsForm = $('#fieldsForm');
		var filterRequired = {!!json_encode(array_column($arrReports, 'filter_required', 'id'), JSON_NUMERIC_CHECK) !!};

		var dataJson = null;

		var tabsReport = $('#tabsReport');
		var tbQuery = $('#tbQuery');

		var divErr = $('#err');

		window.chart['chart'] = null;
		var columnChart = $('#columnChart');
		var typeChart = $('#typeChart');

		//Selects para formularios
		columnChart.change(function() {
			if($(this).val() != null)
				buildChartFromJson();
		});
		typeChart.change(function() {
			if($(this).val() != null)
				buildChartFromJson();
		});

		//Select para formularios
		$('#REPO_ID').change(function() {
			clearTable();
			fieldsForm.html('<i class="fas fa-cog fa-spin fa-fw" aria-hidden="true"></i>Cargando filtros...');
			var id_selected = $(this).val();
			if(id_selected != null && id_selected != ''){
				//título de ventana, afecta nombre de archivo exportado
				$(document).attr('title', nameApp+' / Rep '+$(this).find(':selected').text());

				formRep
					.attr('action', 'reports/getData/'+id_selected)
					.removeClass('hide');

				//Si el formulario tiene filtros obligatorios, muestra campos de filtro y no permite ocultarlos.
				btnViewForm.parent().removeClass('hide');
				if(filterRequired[id_selected] === true){
					btnViewForm
						.addClass('disabled')
						.find('.iconBtn')
						.addClass('fa-caret-up')
						.removeClass('fa-caret-down');
					fieldsForm.removeClass('hide');
				} else {
					btnViewForm
						.removeClass('disabled');
				}

				//Ajax para obtener campos de filtro
				$.ajax({
					type: 'GET',
					url: 'reports/viewForm',
					data: {form: id_selected},
					dataType: 'json',
				}).done(function( data, textStatus, jqXHR ) {
					fieldsForm.html(data);
					initComponents();
					$('.selectpicker').select2();
					$('.selectpickerAjax').select2({
						ajax: {
							cache: true,
							delay: 250,
							//headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
							data: function (params) {
								return { q: params.term };
							},
							processResults: function (data) {
								return {results: $.map( data, function( value, index ) {
									return {id: index, text: value};
								})};
							}
						},
					});
				})
				.fail(function( jqXHR, textStatus, errorThrown ) {
					var msgErr = 'Error: '+jqXHR.responseText;
					divErr.html(msgErr).removeClass('hide');
				})
				.always(function( data, textStatus, jqXHR ) {
				});

			} else {
				formRep.addClass('hide'); //form
				btnViewForm.parent().addClass('hide');
				$(document).attr('title', nameApp+' / Reportes');
			}
		});

		//Oculta/muestra el formulario para filtrar los resultados.
		$('#btnViewForm').click(function() {
			var btn = $(this);
			if(!btn.hasClass('disabled')){
				btn.find('.iconBtn')
					.toggleClass('fa-caret-up')
					.toggleClass('fa-caret-down');

				fieldsForm.toggleClass('hide');
				initComponents();
			}
		});

		//Reset de formulario
		$('form').on('reset', function() {
			clearTable();
		});

		//Realiza la solicitud del formulario via ajax y construye el datatable.
		formRep.submit(function(e) {
			e.preventDefault();
			clearTable();
			var url = formRep.attr('action');

			$.ajax({
				type:     'POST',
				url:      url.replace('_', '/'),
				data:     formRep.serialize(),
				dataType: 'json',
			}).done(function( data, textStatus, jqXHR ) {
				if ( data.data.length > 0 ){
					dataJson = data;
					buildDataTable();
					$('a[href="#tabTable"]').tab('show');
				} else {
					divErr.html('No se encontraron registros.').removeClass('hide');
				}
			})
			.fail(function( jqXHR, textStatus, errorThrown ) {
				if (jqXHR.statusText === 'Forbidden')
					msgErr = 'Error en la conexión con el servidor. Presione F5.';
				else if (jqXHR.statusText === 'Unauthorized')
					msgErr = 'Sesión ha caducado. Presione F5.';
				else
					msgErr = 'Error: '+jqXHR.responseText;
				divErr.html(msgErr).removeClass('hide');
			})
			.always(function( data, textStatus, jqXHR ) {
				formRep.find("button[type=submit]").attr('disabled', false);
				$('body').css('cursor', 'auto');
				if(filterRequired[$('#REPO_ID').val()] != true){
					fieldsForm.addClass('hide');
				}

				//Init all components
				initComponents();

				//hide modal
				$('#msgModalLoading').modal('hide');
			});

		});


		//Construye la tabla con el Json recibido
		function buildDataTable(){
			clearTable();

			var columns = [];
			for(var i in dataJson.keys){
				columns.push({title: dataJson.keys[i]});
			}

			columnChart.find('option').remove();
			$.each(columns, function(i, col) {   
				columnChart
					.append($("<option/>", {
						value: i,
						text: col.title
					}));

				if(dataJson.columnChart == col.title)
					columnChart.val(i).trigger('change');
			});

			tabsReport.removeClass('hide');

			tbQuery = $('#tbQuery').DataTable({
				data: dataJson.data,
				columns: columns
			});
		}

		function buildChartFromJson() {
			$('.ctrlChart').removeClass('hide');
			if(window.chart['chart'] != null)
				window.chart['chart'].destroy();

			var arr = jQuery.map( dataJson.data, function( n, i ) {
			  return n[columnChart.val()];
			});

			var labelsChart = $.grep(arr,function(v,k){
								return $.inArray(v,arr) === k;
							});
			var dataChart = [];

			$(labelsChart).each(function (index, value) {
				var nbOcc = 0;
				for (var i = 0; i < arr.length; i++) {
				  if (arr[i] == value) {
					nbOcc++;
				  }
				}
				dataChart.push(nbOcc);
			});

			buildChart(
				'', //title
				labelsChart, //labels
				dataChart, //data
				[], //colores
				'chart', typeChart.val()
			);
		}

		//Destruye la tabla y limpia el log de errores.
		function initComponents(){
			$('[data-tooltip="tooltip"]').tooltip('hide');
			window.initDateTimePicker();
		}

		//Destruye la tabla y limpia el log de errores.
		function clearTable(){

			if ( $.fn.dataTable.isDataTable( '#tbQuery' ) ) {
				tbQuery = $('#tbQuery').DataTable().destroy();
			}
			$('#tbQuery').empty();

			tabsReport.addClass('hide');

			$('.ctrlChart').addClass('hide');
			if(window.chart['chart'] != null)
				window.chart['chart'].destroy();

			divErr.html('').addClass('hide');
		}

		//Reajusta el ancho de las columnas al activar #tabTable
		//(Al redimensionar la ventana, thead no se redimensiona).
		$('a[href="#tabTable"]').on( 'shown.bs.tab', function (e) {
			$('.ctrlChart').addClass('hide');
			tbQuery.columns.adjust().draw();
		});
		//Cambia el alto del canvas al activar #tabGraf
		//(al ocultar el tab, el canvas queda con height=0).
		$('a[href="#tabGraf"]').on( 'shown.bs.tab', function (e) {
			$('#chart').css('height', '300px')
			buildChartFromJson();
		});

	});
	</script>
@endpush

@push('head')
	<style type="text/css">
		.row{margin: 0px 0px;}
		.ctrlChart>div{padding: 8px 0px;}
		.showErr{padding-top: 20px;}
		.btnViewForm{margin-top: 25px; left: -25px;}
	</style>
@endpush
