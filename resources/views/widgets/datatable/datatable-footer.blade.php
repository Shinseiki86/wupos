<script type="text/javascript">
$(document).ready(function(){
	var tfoot = $('#tabla thead tr').clone();

	tfoot.find('th').removeClass(function (index, className) {
			return (className.match (/\bcol-\S+/g) || []).join(' ');
		})
		.html( function (index, oldhtml) {
			if(oldhtml){
				var text = notFilter ? 'Buscar '+oldhtml : oldhtml;
				var notFilter = $(this).hasClass('notFilter');
				return '<input type="text" class="form-control input-sm" style="width:98%" title="'+text+'" placeholder="'+text+'" '+(notFilter?'disabled':'')+' />';
			}
		})
		.css('padding','8px 0px');

	$('#tabla').append(
		$('<tfoot/>').append( tfoot )
	)
});
</script>
