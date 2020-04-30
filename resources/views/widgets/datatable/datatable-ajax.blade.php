@rinclude('datatable')

@push('scripts')
@rinclude('datatable-footer')
<script type="text/javascript">
$(document).ready(function(){
	
	//var thead = $('#tabla thead tr th');

	var tbIndex = $('#tabla').DataTable({
		processing: true,
		serverSide: true,
		ajax: '{{$urlAjax}}',
		columns: [
		@foreach($columns as $i=>$col)
			@php
				//ctype_upper permite excluir la columna que tenga minúsculas para no realizar búsquedas
				$is_var = ctype_upper(str_replace(['_','.'],'',$col));
			@endphp
			{ data:       '{{ array_last(explode('.', $col)) }}',
			  name:       '{{$col}}',
			  //className:  thead.eq({{ $i }}).attr('class'),
			  searchable: {{ $is_var ? 'true' : 'false' }},
			  orderable:  {{ $is_var ? 'true' : 'false' }}
			},
		@endforeach
			{data:'action', orderable: false, searchable: false}
		],
		drawCallback : function(settings) {
			//Carga de datos a mensajes modales para eliminar registros	
			$('.btn-delete').on('click', function(event){
				var modal = $('#pregModalDelete');
				var button = $(event.currentTarget); // Button that triggered the modal
				var id = button.data('id'); // Se obtiene valor en data-id
				modal.find('.id').text(id); //Se asigna en la etiqueta con clase id

				var modelo = button.data('modelo');
				modal.find('.modelo').html(modelo);

				var descripcion = button.data('descripcion');
				modal.find('.descripcion').html(descripcion);

				var urlForm = button.data('action'); // Se cambia acción del formulario.
				modal.find('.frmModal').attr('action', urlForm);
			});
			//Muestra Tooltips de boostrap
			tooltips = $('[data-tooltip="tooltip"]');
			if(tooltips.length > 0)
				tooltips.tooltip();
	  	}
	});

	@rinclude('datatable-filters')
});
</script>
@endpush
