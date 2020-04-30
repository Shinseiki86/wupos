/*
	Librería para realizar carga masiva de registros desde una plantilla de Excel.
	Shinseiki86
*/

//Carga archivo de excel
var workbook = null;
var processing = false;
var reload = false;
var rABS = false; // true: readAsBinaryString ; false: readAsArrayBuffer
var csrfToken = null;
var url_ws = null;

function initImportModelFromExcel(url, token){
	csrfToken = token;
	url_ws = url;
}


$(function() {

	/* processing array buffers, only required for readAsArrayBuffer */
	function fixdata(data) {
	  var o = "", l = 0, w = 10240;
	  for(; l<data.byteLength/w; ++l) o+=String.fromCharCode.apply(null,new Uint8Array(data.slice(l*w,l*w+w)));
	  o+=String.fromCharCode.apply(null, new Uint8Array(data.slice(l*w)));
	  return o;
	}


	$('#pregModalImport').on('hide.bs.modal', function(e) {
		//Si se esta procesando una carga, el modal no se puede cerrar.
		if(processing)
			e.preventDefault();
		if(reload)
			location.reload();
	});

	//Restaura el formulario para realizar una nueva carga.
	function resetForm() {
		$('.progress-bar').removeClass('progress-bar-success progress-bar-danger');
		updateBarProgress(0);
		$('#cargarExcel').prop('disabled', true);
		$('#cancelLoad').prop('disabled', false);
		$('#archivo').val('');
	}


	$('#archivo').on('click', function (e) {
		resetForm();
	});

	// Al seleccionar un archivo, lo carga en la variable global workbook.
	// Al terminar la carga, habilita el botón 'Cargar'.
	$('#archivo').on('change', function (e) {
		//e.preventDefault();
		//$('#cargarExcel').addClass('disabled');
		if ($('#archivo').val() != ''){
			var xlsFile = $('#archivo')[0].files[0];
			var reader = new FileReader();

			//Función al cargar el archivo
			reader.onload = function(e) {
			  var data = e.target.result;

			  if(rABS) {
				/* if binary string, read with type 'binary' */
				workbook = XLSX.read(data, {type: 'binary'});
			  } else {
				/* if array buffer, convert to base64 */
				var arr = fixdata(data);
				workbook = XLSX.read(btoa(arr), {type: 'base64'});
			  }

			  /* DO SOMETHING WITH workbook HERE */
			  $('#cargarExcel').prop('disabled', false);

			};

			if(rABS) reader.readAsBinaryString(xlsFile);
			else reader.readAsArrayBuffer(xlsFile);
		}
	});

	//Procesa el archivo previamente seleccionado y cargado. El botón solo estará habilitado si se ha cargado previamente un archivo. 
	$('#cargarExcel').on('click', function (e) {
		e.preventDefault();
		processing = true;
		reload = true;

		$('#archivo').prop('disabled', true);
		$('#cargarExcel').prop('disabled', true);
		$('#cancelLoad').prop('disabled', true);

		//Solo se carga la primer hoja del libro
		var sheet = workbook.Sheets[workbook.SheetNames[0]];
		var jsonSheet = XLSX.utils.sheet_to_json(sheet, {raw:false,  dateNF:'YYYY-MM-DD HH:mm:ss'});

		if(jsonSheet.length > 0){
			createModel(jsonSheet, 0);
		} else {
			processing = false;
			$('#archivo').prop('disabled', false);
			updateBarProgress(100, 'danger');
			addLog(0, 'Archivo de Excel sin registros.');
		}
	});
	
	function createModel(jsonSheet, i) {
		var data = jsonSheet[i];
		i++;
		data['row'] = i;
		var cantRows = jsonSheet.length;
		var porcent = (i/cantRows*100).toFixed(0);

		$.ajax({
				async: true, 
				url: url_ws,
				data: data,
				dataType: "json",
				type: "GET",
				headers: {
					'X-CSRF-TOKEN': csrfToken
				}
			})
			.done(function( data, textStatus, jqXHR ) {
				//console.log('Response: '+JSON.stringify(textStatus));
				//$('#response').html(JSON.stringify(response));
			})
			.fail(function( jqXHR, textStatus, errorThrown ) {
				//console.log('Err: '+JSON.stringify(jqXHR));
				//$('#response').html(event.responseText);
			})
			.always(function( data, textStatus, jqXHR ) {
				//console.log('proc: '+i+' de '+cantRows+'('+porcent+'%)');
				if (jqXHR === 'Forbidden') {
					updateBarProgress(100, 'danger');
					addLog(0, 'Error en la conexión con el servidor. Presione F5.');
				} else {
					if (i == cantRows) {
						processing = false;
						$('#archivo').prop('disabled', false);
						updateBarProgress(100);
					} else {
						if(data['csrfToken'] != '')
							csrfToken = data['csrfToken'];
						updateBarProgress(porcent);
						createModel(jsonSheet, i);
					}

					if (typeof jqXHR.responseJSON === 'undefined')
						addLog(i, 'NetworkError: 500 Internal Server Error.');
					else
						addLog(i, jqXHR.responseJSON);
				}
			});
	}
	
	function updateBarProgress(porcent, bar_class) {
		if (typeof bar_class === 'undefined') {var bar_class = 'primary';}

		var progBar = $('.progress-bar');

		progBar
			.css('width', porcent+'%')
			.css('min-width', '2em')
			.attr('aria-valuenow', porcent);

			if(bar_class == 'danger'){
				progBar.addClass('progress-bar-danger');
					//.find('.valuePorcent').append('<span> Error</span>');
			} else {
				if(porcent == 100){
					progBar.addClass('progress-bar-success')
				}
				progBar.find('.valuePorcent').text(porcent+' %');
			}
	}

	function addLog(row, log) {
		var status;
		var logMsg;

		if(typeof log === 'string'){
			logMsg = log;
		} else if(typeof log === 'object'){
			status = log['status'];
			logMsg = log['msg'];
		}

		var alert_class = '';
		switch(status){
			case 'OK':
				alert_class = 'success';
				break;
			case 'ERR':
			default:
				alert_class = 'danger';
				break;
		}

		var resultados = $('#resultadosCarga');
		resultados.append(
				'<li class="list-group-item list-group-item-'+alert_class+'" style="padding: 0px 15px;">'+
					'<strong>Fila '+row+': </strong>'+logMsg+
				'</li>'
			);
		if( $('#scrollLog').is(':checked') ){
			//console.log('scrollLog: '+ resultados.prop('scrollHeight'));
			resultados.scrollTop(resultados.prop('scrollHeight'));
		}
	}

})