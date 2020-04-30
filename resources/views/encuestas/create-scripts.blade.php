{!! Html::script('js/ckeditor/ckeditor.js') !!}
{!! Html::script('js/angular/angular.min.js') !!}
<script type="text/javascript">

	var appEva360 = angular.module('appEva360', [], function($interpolateProvider) {
		$interpolateProvider.startSymbol('{%');
		$interpolateProvider.endSymbol('%}');
	});

	appEva360.controller('EncuestasController', ['$scope', function($scope){
		$scope.plantillas = {!! json_encode($plantillas) !!};
		$scope.selectedPlantilla = '';

		$scope.ENCU_PLANTILLA = false;
		if( window.location.pathname.search( 'plantillas' ) > 0)
			$scope.ENCU_PLANTILLA = true;

		$scope.setPlantilla = function(){
			if($scope.selectedPlantilla != null){
				$scope.plantilla = $scope.plantillas[$scope.selectedPlantilla];

				CKEDITOR.instances['ENCU_descripcion'].setData($scope.plantilla.ENCU_descripcion);

				//$('#dttmpickerFchVigencia').data("DateTimePicker").date('$scope.plantilla.ENCU_FECHAVIGENCIA');
				$('#ROLE_ids').multiselect('deselectAll', false);
				$('#ROLE_ids').multiselect('select', jQuery.parseJSON($scope.plantilla.ENCU_rolesIds));
				var urlCloneFromTemplate = '{{ route('encuestas.index') }}/'+ $scope.plantilla.ENCU_ID +'/duplicar';
				$('#frmEncuesta').attr('action', urlCloneFromTemplate);
				$( '#frmEncuesta :submit' ).removeAttr('disabled');
			}
		};

	}]);

	$(function () {

		CKEDITOR.replace( 'ENCU_descripcion' );

		//¿Utilizar plantilla?
		$('#usarPlantilla').change(function() {
			var urlCreateEncu = '';
			//Si se activa #usarPlantilla, entonces se muestra dropdown para seleccionar plantilla.
			if( $(this).is(":checked") ) {
				$('#selectPlantilla').removeClass('hidden');
				$( '#frmEncuesta :submit' ).attr('disabled', true);
			} else {
				//Sino, se restablece acción del form para crear y se oculta dropdown #selectPlantilla 
				var urlCreateEncu = '{{ route('encuestas.store') }}';
				$('#selectPlantilla').addClass('hidden');
				$( '#frmEncuesta :submit' ).removeAttr('disabled');
			}

			$('#frmEncuesta').attr('action', urlCreateEncu);
		}).trigger('change');

		//¿Convertir en plantilla?
		$('#ENCU_PLANTILLA').change(function() {
			if($(this).is(":checked")) {
				$('#div_PLANTILLAPUBLICA').removeClass('hidden');
			} else {
				$('#div_PLANTILLAPUBLICA').addClass('hidden');
			}
		}).trigger('change');

		//¿Quiénes visualizarán la encuesta?
		$('#ROLE_ids').multiselect({
			includeSelectAllOption: true,
			maxHeight: 400,
			dropUp: true,
			//buttonWidth: '300px',
			selectAllText: ' Todos',
			nonSelectedText: 'Ninguno',
			nSelectedText: 'seleccionados',
			allSelectedText: 'Todos'
		});
		$('#ROLE_ids').multiselect('select', [3,4]);
		//$('#ROLE_ids').multiselect('updateButtonText');

		//Vigencia
		$('#dttmpickerFchVigencia').datetimepicker({
			locale: 'es',
			stepping: 5,
			//inline: true,
			format: 'DD/MM/YYYY hh:mm A',
			//extraFormats: [ 'YY/MM/DD HH:mm' ],
			useCurrent: false,  //Important! See issue #1075. Requerido para minDate
			minDate: new Date()-(5*1000+1), //-5min Permite seleccionar el dia actual
			sideBySide: true,
			icons: {
				time: "fa fa-clock-o",
				date: "fa fa-calendar",
				up: "fa fa-arrow-up",
				down: "fa fa-arrow-down",
				previous: 'fa fa-chevron-left',
				next: 'fa fa-chevron-right',
				today: 'glyphicon glyphicon-screenshot',
				clear: 'fa fa-trash',
				close: 'fa fa-times'
			},
			tooltips: {
				//today: 'Go to today',
				//clear: 'Clear selection',
				//close: 'Close the picker',
				selectMonth: 'Seleccione Mes',
				prevMonth: 'Mes Anterior',
				nextMonth: 'Mes Siguiente',
				selectYear: 'Seleccione Año',
				prevYear: 'Año Anterior',
				nextYear: 'Año Siguiente',
				selectDecade: 'Seleccione Década',
				prevDecade: 'Década Anterior',
				nextDecade: 'Década Siguiente',
				prevCentury: 'Siglo Anterior',
				nextCentury: 'Siglo Siguiente'
			}
		});
		$('#dttmpickerFchVigencia').data("DateTimePicker").date('{{ \Carbon\Carbon::now()->addWeek()->format(Config::get('view.formatDateTime')) }}');
	});
</script>