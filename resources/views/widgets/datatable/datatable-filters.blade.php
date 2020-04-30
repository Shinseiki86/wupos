//Filtro con input
tbIndex.columns(':not(.notFilter)').every( function () {
	var column = this;

	$( 'input', this.footer() ).on( 'keyup change', function () {
		if ( column.search() !== this.value ) {
			column.search( this.value ).draw();
		}
	});

	$(column.footer()).find('input').val(column.search());

});