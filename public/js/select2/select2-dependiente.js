function fillDropDownAjax($selectPadre, $selectHijo, $url, $idBusqueda, $nombreBusqueda, $msgModel){
	$(document).on('change','#'+$selectPadre,function(){

		$selectHijo.empty().prop('disabled', true);
		var opt='';
		var padre_ID = $(this).val();
		if (padre_ID !== null){//El select padre se encuentra sin datos seleccionados.
			$.ajax({
				type: 'get',
				url:  $url,
				data: { id : padre_ID },
				success: function(data){;
					if (data.length==0) {
						var msg = 'No se encontraron '+$msgModel;
						toastr['warning'](msg+' para la opción seleccionada.', 'Datos No Encontrados');
						$selectHijo.next().find('input').attr('placeholder',msg);
					} else {
						//opt += '<option value="0" selected disabled>'+placeholder+'</option>';
						$.each(data, function( index, value ) {
							opt += '<option value="'+value[$idBusqueda]+'">'+value[$nombreBusqueda]+'</option>';
						});
						$selectHijo.append(opt);
						$selectHijo.prop('disabled', false);
						$selectHijo.val([]).trigger('change');
					}
				},
				error: function( jqXHR, textStatus, errorThrown ){
					var msgErr;
					if (errorThrown === 'Unauthorized')
						msgErr = 'Sesión ha caducado. Presione F5 e inicie sesión.';
					else if (errorThrown === 'Forbidden')
						msgErr = 'Error en la conexión con el servidor. Presione F5.';
					else
						msgErr = 'No hay datos disponibles para las listas dependientes';

					toastr['error'](msgErr, 'Error');
				}
			});
		}
	});
}
