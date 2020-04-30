	$.extend( true, $.fn.dataTable.defaults, {
		lengthMenu: [[5,10,25,50,-1], [5,10,25,50,'Todos']],
		//retrieve: true,
		pagingType: 'simple_numbers',
		//bScrollCollapse: true,
		//sScrollY: '300px',
		responsive: true,
		stateSave:  true,
		language: { 
			sProcessing:     'Procesando...', 
			sLengthMenu:     'Mostrar _MENU_ registros', 
			sZeroRecords:    'No se encontraron resultados', 
			sEmptyTable:     'Ningún dato disponible en esta tabla', 
			sInfo:           'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros', 
			sInfoEmpty:      'Mostrando registros del 0 al 0 de un total de 0 registros', 
			sInfoFiltered:   '(filtrado de un total de _MAX_ registros)', 
			sSearch:         'Buscar:', 
			sInfoThousands:  ',', 
			sLoadingRecords: 'Cargando...', 
			oPaginate: {
				sFirst:    '<i class="fas fa-angle-double-left" aria-hidden="true"></i>',
				sLast:     '<i class="fas fa-angle-double-right" aria-hidden="true"></i>',
				sNext:     '<i class="fas fa-chevron-right" aria-hidden="true"></i>',
				sPrevious: '<i class="fas fa-chevron-left" aria-hidden="true"></i>'
			}
		},
		dom: "<'row' <'col-xs-12 col-sm-4'<'pull-left' f>> <'col-xs-12 col-sm-8'<'pull-right' B>>>"
			 +"<rt>"
			 +"<'row'<'form-inline'"
			 +" <'col-sm-6 col-md-6 col-lg-6'l>"
			 +"<'col-sm-6 col-md-6 col-lg-6'p>>>",
		buttons: [{
				extend: 'csvHtml5',
				text:  '<i class="fas fa-file-alt"></i>',
                //exportOptions: { columns: ':visible' },
				titleAttr: 'CSV',
			},{
				extend: 'excelHtml5',
				text:   '<i class="fas fa-file-excel"></i>',
                //exportOptions: { columns: ':visible' },
				titleAttr: 'Excel',
			},{
				extend: 'pdfHtml5',
				text:    '<i class="fas fa-file-pdf"></i>',
                //exportOptions: { columns: ':visible' },
				titleAttr: 'PDF',
			},{
				extend: 'print',
				text:    '<i class="fas fa-print"></i>',
                //exportOptions: { columns: ':visible' },
				titleAttr: 'Imprimir',
			},{
				extend: 'colvis',
				text:  '<i class="fas fa-columns"></i>',
				titleAttr: 'Ver Columnas'
			}
		]
	});