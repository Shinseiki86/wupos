@section('head')
	{!! Html::style('assets/DataTables/datatables.min.css') !!}
@parent
@endsection

@section('scripts')
	{!! Html::script('assets/DataTables/datatables.min.js') !!}
	{!! Html::script('assets/DataTables/Buttons-1.3.1/js/buttons.colVis.min.js') !!}
	<script>
	$(function () {

		/*
		para realizar la paginacion de una tabla lo unico que hay que hacer es asignarle un id a la tabla,
		en este caso el id es 'tabla' e invocar la función Datatable, lo demas que ven sobre esta función
		son configuraciones de presentación
		HFG--Se Realiza ajuste de texto, otros atributos
		*/
		var tbIndex = $('#tbIndex').DataTable({
			lengthMenu: [ [5, 10, 25, 50, -1], [5, 10, 25, 50, 'Todos'] ],
			//sScrollY: '350px',
			pagingType: 'simple_numbers', //'full_numbers',
			bScrollCollapse: true,
			//rowReorder: {selector: 'td:nth-child(2)'},
			rowReorder: false,
			responsive: true,
			select: false,
			stateSave: false,
			language: {
				buttons: {
					selectAll:   'Seleccionar todos',
					selectNone:  'Seleccionar ninguno'
				},
				sProcessing:     'Procesando...', 
				sLengthMenu:     'Mostrar _MENU_ registros', 
				sZeroRecords:    'No se encontraron resultados', 
				sEmptyTable:     'Ningún dato disponible en esta tabla', 
				sInfo:           'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros', 
				sInfoEmpty:      '<i class="fa fa-info-circle" aria-hidden="true"></i> No hay registos para mostrar', 
				sInfoFiltered:   '(filtrado de un total de _MAX_ registros)', 
				sInfoPostFix:    '', 
				sSearch:         '<i class="fa fa-search" aria-hidden="true"></i> Buscar:', 
				sUrl:            '', 
				sInfoThousands:  ',', 
				sLoadingRecords: '<i class="fa fa-cog fa-spin fa-fw" aria-hidden="true"></i> Cargando...', 
				oPaginate: { 
					sFirst:    'Primero', 
					sLast:     'Último', 
					sNext:     'Siguiente', 
					sPrevious: 'Anterior'
				}
			},
			dom: "<'col-sm-2' f> <'col-sm-offset-9' B>"
					 +"<rt>"
					 +"<'row'<'form-inline'"
					 +" <'col-sm-6 col-md-6 col-lg-6'l>"
					 +"<'col-sm-6 col-md-6 col-lg-6'p>>>",//'Bfrtip',
			buttons: [{
					extend: 'excelHtml5',
					//exportOptions: {columns: columnss},
					text:   '<i class="fa fa-file-excel-o"></i>',
					titleAttr: 'Excel',
					//filename:name+fecha()
				},{
					extend: 'colvis',
					text:  '<i class="fa fa-columns"></i>',
					titleAttr: 'Ver Columnas'
				}
			]

		}); //End DataTable


		tbIndex.columns(':not(.notFilter)').every( function () {
			var column = this;
			var select = $('<select><option value="">Todos</option></select>')
				.appendTo( $(column.footer()).empty() )
				.on( 'change', function () {
					var val = $.fn.dataTable.util.escapeRegex( $(this).val() );
					column
						.search( val ? '^'+val+'$' : '', true, false )
						.draw();
				});
		 
			column.data().unique().sort().each( function ( d, j ) {
				if(column.search() === '^'+d+'$'){
					select.append( '<option value="'+d+'" selected="selected">'+d+'</option>' )
				} else {
					select.append( '<option value="'+d+'">'+d+'</option>' )
				}
			});
		});


	}); //End Function
		
	</script>
@parent
@endsection
