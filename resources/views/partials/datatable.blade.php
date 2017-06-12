@section('head')
	{!! Html::style('assets/DataTables/datatables.min.css') !!}
@parent
@endsection

@section('scripts')
	{!! Html::script('assets/DataTables/datatables.min.js') !!}
	<script>
	 $(function () {

		/*
		para realizar la paginacion de una tabla lo unico que hay que hacer es asignarle un id a la tabla,
		en este caso el id es 'tabla' e invocar la función Datatable, lo demas que ven sobre esta función
		son configuraciones de presentación
		HFG--Se Realiza ajuste de texto, otros atributos
		*/
		if ( $.fn.dataTable.isDataTable( '#tbIndex' ) ) {
			var tbIndex = $('#tbIndex').DataTable();
		}
		else {
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
				//dom: '<"toolbar">Bflrtip',
				/*dom: "<'row'<'form-inline' <'col-sm-offset-5'B>>>"
					+"<'row' <'form-inline' <'col-sm-2'f>>>"
					+"<rt>"
					+"<'row'<'form-inline' <'col-sm-6 col-md-6 col-lg-6'l>"
					+"<'col-sm-6 col-md-6 col-lg-6'p>>>",*/
				/*buttons: [
					{//Bton CVS
						extend: 'csvHtml5',
						//exportOptions: { columns: columnss },
						text:   '<i class="fa fa-file-text-o"></i>',
						titleAttr: 'CSV',
						filename:name+fecha()
					},
					{//Boton Excel
						extend: 'excelHtml5',
						//exportOptions: { columns: columnss },
						text:      '<i class="fa fa-file-excel-o"></i>',
						titleAttr: 'Excel',
						filename:name+fecha()
					},
					{//Boton Imprimir
						extend: 'print',
						//exportOptions: {columns: [ 0, 1, 2, 3,4,5 ]},
						text: '<i class="fa fa-print"></i>',
						titleAttr: 'Imprimir'
					},
					{//Boton Ver
						extend: 'colvis',
						text: 'Ver Columnas'               
					}
				],
				columnDefs: [ {
					orderable: false,
					className: 'select-checkbox',
					targets:   0
				} ],
				select: {
					style:    'os',
					selector: 'td:first-child'
				},*/
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
			});
		 }

		
		
	  });
	</script>
@parent
@endsection
