<div class="row">
	<div class="col-md-3">
		<div class="input-group">
			<span class="input-group-addon">Registros por pág</span>
			<select class="form-control" ng-model="pageSize">
			  <option value="5" ng-selected="pageSize==5">5</option>
			  <option value="10" ng-selected="pageSize==10">10</option>
			  <option value="25" ng-selected="pageSize==25">25</option>
			  <option value="100" ng-selected="pageSize==100">100</option>
			  <option value="-1" ng-selected="pageSize==-1">Todos</option>
			</select>
		</div>
	</div>
	<div class="col-md-9 text-right">
		<dir-pagination-controls
			boundary-links="true"
			on-page-change="pageChangeHandler(newPageNumber)"
			template-url="{{ asset('assets/js/angular/dirPagination.tpl.html') }}" >
		</dir-pagination-controls>
	</div>
</div>