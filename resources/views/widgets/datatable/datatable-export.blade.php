@rinclude('datatable')

@push('scripts')
@rinclude('datatable-footer')
<script type="text/javascript">
	$(function () {
		var tbIndex = $('#tabla').DataTable({
			columnDefs: [
				{ searchable: false, targets: 'notFilter'},
				{ orderable: false, targets: 'notOrder'}
			],
			drawCallback : function(settings) {
				
				//Mostrar alerta de filtro aplicado
				var title = $('.page-header>.row>#title');
				var alertFilter = title.find('small');
				var sSearch = $.trim(settings.oPreviousSearch.sSearch);
				var aoPreSearchCols = settings.aoPreSearchCols.find(function(val) {
					return $.trim(val.sSearch)!='';
				});

				if((sSearch!='' || aoPreSearchCols) && (alertFilter.length==0 || alertFilter=='undefined')){
					title.append('<small class="badge text-warning">Filtrado <i class="fas fa-times" aria-hidden="true"></i></small>');
				} else if(sSearch==='' && !aoPreSearchCols) {
					alertFilter.remove()
				}

				//Quita todos los filtros
				title.find('small').click(function() {
					tbIndex.search('');
					inputSearch.val('').change();
					tbIndex.draw();
				});
			}
		});
		@rinclude('datatable-filters')

		//Marca los input de búsqueda que tienen datos
		var inputSearch = $('#tabla_wrapper').find('input[type="search"]');
		inputSearch.change(function() {
			$(this).val()!=''
				? $(this).parent().addClass('has-warning')
				: $(this).parent().removeClass('has-warning');
		}).change();

	});
</script>
@endpush
