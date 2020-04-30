@rinclude('datatable')

@push('scripts')
@rinclude('datatable-footer')
<script type="text/javascript">
	$(function () {
		var tbIndex = $('#tabla').DataTable({
			columnDefs: [
				{ searchable: false, targets: 'notFilter'},
				{ orderable: false, targets: 'notOrder'}
			]
		});
		@rinclude('datatable-filters')
	});
</script>
@endpush
