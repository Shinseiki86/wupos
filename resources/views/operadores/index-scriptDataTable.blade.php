@section('head')
	{!! Html::style('assets/css/jquery.dataTables.min.css') !!}
@parent
@endsection

@section('scripts')
{!! Html::script('assets/js/jquery/jquery.dataTables.min.js') !!}
    <script>
    alert('mmm');
      $(function () {

      	/*
      	para realizar la paginacion de una tabla lo unico que hay que hacer es asignarle un id a la tabla,
      	en este caso el id es "tabla" e invocar la función Datatable, lo demas que ven sobre esta función
      	son configuraciones de presentación
      	*/
	 	var tbIndex = $('#tbIndex').DataTable({  
	        "sScrollY": "350px",
	        "pagingType": "full_numbers",
	        "bScrollCollapse": true,
	 	});


		// #Filter_ESOP_descripcion is a <select> element
		$('#Filter_ESOP_descripcion').change(function () {
		    tbIndex
		        .columns( 4 )
		        .search( this.find(':selected').text() )
		        .draw();
		} );

		// #Filter_REGI_nombre is a <select> element
		$('#Filter_REGI_nombre').change(function () {
		    tbIndex
		        .columns( 5 )
		        .search( $('#SALA_ID option:selected').text() )
		        .draw();
		} );



	  });

    </script>
@parent
@endsection