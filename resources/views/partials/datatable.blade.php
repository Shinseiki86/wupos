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
				//bScrollCollapse: true,
				//rowReorder: {selector: 'td:nth-child(2)'},
				rowReorder: false,
				responsive: true,
				select: false,
				stateSave: false,
				dom: '<"toolbar">Bflrtip',
				buttons: [
			        'excel',
			        //'selectAll',
			        //'selectNone'
			    ],
		        /*columnDefs: [ {
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

		$('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
			$.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust().draw();
		});
		
		$('#tbIndex').find('tbody').removeClass('hide');
		$('#tbIndex').find('tfoot').addClass('hide');
		
	  });
	</script>
@parent
@endsection
