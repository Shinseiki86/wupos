$(function () {

	$.fn.datetimepicker.defaults.locale = 'es';
	$.fn.datetimepicker.defaults.icons  = {
		time:    'fas fa-clock',
		date:    'fas fa-calendar',
		up:      'fas fa-arrow-up',
		down:    'fas fa-arrow-down',
		previous:'fas fa-chevron-left',
		next:    'fas fa-chevron-right',
		today:   'fas fa-crosshairs',
		clear:   'fas fa-trash',
		close:   'fas fa-times'
	};
	$.fn.datetimepicker.defaults.tooltips= {
		today:       'Hoy',
		clear:       'Limpiar',
		close:       'Cerrar',
		selectMonth: 'Seleccione Mes',
		prevMonth:   'Mes Anterior',
		nextMonth:   'Mes Siguiente',
		selectYear:  'Seleccione Año',
		prevYear:    'Año Anterior',
		nextYear:    'Año Siguiente',
		selectDecade:'Seleccione Década',
		prevDecade:  'Década Anterior',
		nextDecade:  'Década Siguiente',
		prevCentury: 'Siglo Anterior',
		nextCentury: 'Siglo Siguiente'
	}
	$.fn.datetimepicker.defaults.format= 'YYYY-MM-DD';

	window.initDateTimePicker = function () {
		$('.datepicker').datetimepicker();
		$('.datetimepicker').datetimepicker({
			format: 'YYYY-MM-DD HH:mm:ss',
			sideBySide: true
		});
		$('.onlytimepicker').datetimepicker({
			format: 'HH:mm:ss'
		});
	};
	window.initDateTimePicker();

});