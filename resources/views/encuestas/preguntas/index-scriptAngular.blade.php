{!! Html::script('js/momentjs/moment-with-locales.min.js') !!}
{!! Html::script('js/angular/ui-bootstrap-tpls-2.5.0.min.js') !!}
<script>
	var appEva360 = angular.module('appEva360', ['ng-sortable', 'ui.bootstrap'], function($interpolateProvider) {
		$interpolateProvider.startSymbol('{%');
		$interpolateProvider.endSymbol('%}');
	});
	appEva360.controller('PreguntasController', ['$scope', '$timeout', function($scope, $timeout){
		//Mostrar mensaje de carga
		$scope.show = true;

		//Formato de fecha
		$scope.formatDate = function(strDate){
			var strDateFormatted = moment(strDate).format('DD/MM/YYYY hh:mm A');
			return strDateFormatted;
		}

		var tbPregsEl = document.getElementById("tbPregs");
		var tbPregsSortable = Sortable.create(tbPregsEl, {'animation': 300,'disabled': true});
	
		function TblValuesToJSON(){
			var jsonRows = [];
			$('#tbPregs tr').each(function(row, tr){
					jsonRows[row] ={};

				jsonRows[row]['PREG_ID'] = $(tr).find('td:eq(0)').text();
				jsonRows[row]['PREG_POSICION'] = $(tr).find('td:eq(0)').text();

			});

			document.getElementById("inputPreguntas").value = JSON.stringify(jsonRows);
		};


		document.getElementById("btn-modOrden").onclick = function () {
			var disabled = tbPregsSortable.option("disabled");
			
			//Se cambia el texto del botón btn-modOrden y el cursor en tbPregs dependiendo del estado del objeto Sortable
			var btn_modOrden = document.getElementById("btn-modOrden");
			if(disabled){
				btn_modOrden.innerHTML = '<i class="fa fa-save" aria-hidden="true"></i> Guardar posición';
				document.getElementById("tbPregs").className = "tbPregsDrag";
				$('#msgModalHelp').modal('show');
			} else {
				//Si no está deshabibilitado, se envía el formulario con el arreglo de preguntas ordenado.
				TblValuesToJSON();
				btn_modOrden.setAttribute('type', 'submit');
			}

			//Se modifica propiedad 'disabled' del objeto Sortable
			tbPregsSortable.option("disabled", !disabled); 
		};

		$timeout( function(){
			$scope.preguntas = {!! json_encode($preguntas ,JSON_NUMERIC_CHECK) !!};
			$scope.ENCU_ID = {!! $encuesta -> ENCU_ID !!};
			$scope.ENCU_ESTADO = {!! $encuesta -> estado -> ENES_ID !!};
			$scope.ENCU_ABIERTA = {!! App\Models\EncuestaEstado::ABIERTA !!};
			$scope.show = false;
			$('#tbPregs').removeClass('hide');
		}, 500);  // artificial wait of 1/2 second
	
	appEva360.directive('tooltip', function(){
		return {
			restrict: 'A',
			link: function(scope, element, attrs){
				$(element).hover(function(){
					// on mouseenter
					$(element).tooltip('show');
				}, function(){
					// on mouseleave
					$(element).tooltip('hide');
				});
			}
		};
	});

	}]);
</script>