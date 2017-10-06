@section('scripts')
	{!! Html::script('assets/js/angular/angular.min.js') !!}
	{!! Html::script('assets/js/angular/angular-animate.min.js') !!}
	{!! Html::script('assets/js/angular/angular-sanitize.min.js') !!}
	{!! Html::script('assets/js/angular/ui-bootstrap-tpls-2.5.0.min.js') !!}
	{!! Html::script('assets/js/angular/dirPagination.js') !!}
	{!! Html::script('assets/js/momentjs/moment-with-locales.min.js') !!}
	<script type="text/javascript">
		var appWupos = angular.module('appWupos', ['ngAnimate', 'ngSanitize', 'dirPagination', 'ui.bootstrap'], function($interpolateProvider) {
			$interpolateProvider.startSymbol('{%');
			$interpolateProvider.endSymbol('%}');
		});

		appWupos.controller('OperadoresCtrl', ['$scope', '$timeout', function($scope, $timeout){
			//Mostrar mensaje de carga
			$scope.load = false;

			//paginación
			if(!localStorage.currentPageOperador || !localStorage.pageSizeOperador){
				localStorage.currentPageOperador = 1
				localStorage.pageSizeOperador = 25;
			}
			$scope.currentPage = localStorage.currentPageOperador;
			$scope.$watch('currentPage', function(currentPage) {
				localStorage.currentPageOperador = currentPage;
			});
			$scope.pageSize = localStorage.pageSizeOperador;
			$scope.$watch('pageSize', function(pageSize) {
				localStorage.pageSizeOperador = pageSize;
			});

			//Ordenamiento
			if(!localStorage.sortTypeOperador || !localStorage.sortReverseOperador){
				localStorage.sortTypeOperador = 'OPER_codigo';
				localStorage.sortReverseOperador = false;
			}
			$scope.sortType = localStorage.sortTypeOperador;
			$scope.$watch('sortType', function(sortType) {
				localStorage.sortTypeOperador = sortType;
			});

			$scope.sortReverse = JSON.parse(localStorage.sortReverseOperador);
			$scope.$watch('sortReverse', function(sortReverse) {
				localStorage.sortReverseOperador = sortReverse;
			});

			//Filtros
			if(!localStorage.searchOperador)
				localStorage.searchOperador = null;
			$scope.isFiltered = false;
			if(localStorage.searchOperador != 'null' && localStorage.searchOperador != 'undefined'){
				if (localStorage.searchOperador[0] === '{'){
					$scope.isFiltered = true;
					$scope.searchOperador = JSON.parse(localStorage.searchOperador);
				} else {
					$scope.searchOperador = localStorage.searchOperador;
				}
			}
			$scope.toggleFormFilter = function() {
				$scope.isFiltered = !$scope.isFiltered;
				//if(!$scope.isFiltered && typeof $scope.searchOperador == 'object')
					$scope.searchOperador = null;
			}

			$scope.$watchCollection('searchOperador', function(filter) {
				if(typeof filter == 'object')
					localStorage.searchOperador = JSON.stringify(filter);
				else
					localStorage.searchOperador = filter;
			});

			//Formato de fecha
			$scope.formatDate = function(strDate){
				var strDateFormatted = '';
				if( jQuery.inArray( strDate, ['', null, 'undefined']) == -1 )
					strDateFormatted = moment(strDate).format('DD/MM/YYYY hh:mm A');
				return strDateFormatted;
			}

			//Rellenar número con ceros o un string a la izquierda
			$scope.padLeft = function(num, cant, str){
    			return Array(cant-String(num).length+1).join(str||'0')+num;
			}

			//Cambiar color de cada fila según el estado del operador
			$scope.estadoOperador = {
				'PEND_CREAR' : {{\Wupos\EstadoOperador::PEND_CREAR}},
				'CREADO' : {{\Wupos\EstadoOperador::CREADO}},
				'PEND_ELIMINAR' : {{\Wupos\EstadoOperador::PEND_ELIMINAR}},
			};
			$scope.classEstado = function(estado){
				switch(estado){
					case $scope.estadoOperador['PEND_CREAR']:
						return 'warning';
					case $scope.estadoOperador['CREADO']:
						return 'success';
					case $scope.estadoOperador['PEND_ELIMINAR']:
						return 'danger';
				}
			}

			//$timeout( function(){
				$scope.operadores = {!! $operadores !!};
				$scope.regionales = {!! json_encode($arrRegionales ,JSON_NUMERIC_CHECK) !!};
				$scope.papelera = '{{ $papelera }}';
				$scope.load = true;
			//}, 500);  // artificial wait of 1/2 second

		}]);
	</script>
@parent
@endsection

