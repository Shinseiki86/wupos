<li class="sidebar-search">
	<div class="input-group custom-search-form">
		<input id="search-menu" type="text" class="form-control" placeholder="Buscar...">
		<span class="input-group-btn">
			<button class="btn btn-default" type="button">
				<i class="fas fa-search"></i>
			</button>
		</span>
	</div>
	<div class="search-icon">
		<a href="#"><i class="fas fa fa-search fa-fw"></i></a>
	</div>
	<!-- /input-group -->
</li>

@push('scripts')
<script type="text/javascript">
	$('#search-menu').on('input', function (event) {
		var filter = $(this).val().toLowerCase();
		var sidebar = $('#sidebar').find('.nav-first-level');
		
		sidebar.each(function(){
			var itemsMenu = $(this).find('.nav-second-level > li');
			var count = 0; 

			itemsMenu.each(function(){
				var item = $(this);

				if(item.text().trim().toLowerCase().indexOf(filter) == -1){
					item.hide();
				} else {
					item.show();
					count++;
				}

				if(count>0)
					itemsMenu.parent().parent().show();
				else
					itemsMenu.parent().parent().hide();
			});
			
		});
		
	})
</script>
@endpush