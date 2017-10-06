@section('head')
	<meta name="csrf-token" content="{{ csrf_token() }}">
@parent
@endsection

@section('scripts')
	{{--Librería para manejo de Excel --}}
	{!! Html::script('assets/js/js-xlsx/shim.js') !!}
	{!! Html::script('assets/js/js-xlsx/xlsx.core.min.js') !!}

	<script type="text/javascript">
		//Carga archivo de excel y crea los usuarios
		var workbook = null;
		var processing = false;
		var reload = false;
		var rABS = false; // true: readAsBinaryString ; false: readAsArrayBuffer
		var csrfToken = $('meta[name="csrf-token"]').attr('content');

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

			//Hoja 'ImportUsers' contiene los operadores a crear
			var sheetUsuarios = workbook.Sheets['ImportUsers'];
			var jsonSheet = XLSX.utils.sheet_to_json(sheetUsuarios);

			if(jsonSheet.length > 0){
				createOperadores(jsonSheet, 0);
			}

		});
		
		function createOperadores(jsonUsers, i) {
			var jsonUser = jsonUsers[i];
			i++;
			jsonUser['row'] = i;
			var cantRows = jsonUsers.length;
			var porcent = (i/cantRows*100).toFixed(0);

			$.ajax({
					async: true, 
					url: '{{ route('operadores.createFromAjax') }}',
					data: jsonUser,
					dataType: "json",
					type: "POST",
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
							createOperadores(jsonUsers, i);
						}

						if (typeof jqXHR.responseJSON === 'undefined')
							addLog(i, 'NetworkError: 500 Internal Server Error.');
						else
							addLog(i, jqXHR.responseJSON);
					}
				});
		}
		
		/*function asocEstudianteDoc(jsonSheet, i) {
			var jsonRow = jsonSheet[i];
			i++;
			jsonRow['row'] = i;
			var cantRows = jsonSheet.length;
			var porcent = (i/cantRows*100).toFixed(0);

			$.ajax({
					async: true, 
					url: 'asocEstudianteDoc',
					data: jsonRow,
					dataType: "json",
					type: "POST",
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
					console.log('proc: '+i+' de '+cantRows+'('+porcent+'%)');
					if (jqXHR === 'Forbidden') {
						updateBarProgress(100, 'danger');
						addLog(0, 'Error en la conexión con el servidor. Presione F5.');
					} else {
						if (i == cantRows) {
							processing = false;
							$('#archivo').prop('disabled', false);
							updateBarProgress(100);
						} else {
							updateBarProgress(porcent);
							asocEstudianteDoc(jsonSheet, i);
						}

						if (typeof jqXHR.responseJSON === 'undefined')
							addLog(i, 'NetworkError: 500 Internal Server Error.');
						else
							addLog(i, jqXHR.responseJSON);
					}
				});
		}*/

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
	</script>
@parent
@endsection

	<!-- Mensaje Modal. -->
	<div class="modal fade" id="pregModalImport" role="dialog" tabindex="-1" >
		<div class="modal-dialog">

			{{ Form::open( /*[ 'url'=>'usuarios/importXLS', 'class'=>'form-vertical', 'files'=>true ] */) }}

			<!-- Modal content-->
			<div class="modal-content panel-info">
				<div class="modal-header panel-heading" style="border-top-left-radius: inherit; border-top-right-radius: inherit;">
					<h4 class="modal-title">Importar XLS con usuarios</h4>
				</div>

				<div class="modal-body">

				{{-- Inicialmente se iba a generar la plantilla con los datos del modelo, pero por facilidad y poca disponibilidad de tiempo, se optó por un archivo ya creado y guardado en public.
					<a class='btn btn-primary' role='button' href="{{ URL::to('usuarios/plantilla/xlsx') }}">
						<i class="fa fa-download" aria-hidden="true"></i> Descargar plantilla
					</a>
				--}}
					<a class='btn btn-info' role='button' href="{{ asset('templates/TemplateImportOperadores.xlsx') }}" download>
						<i class="fa fa-download" aria-hidden="true"></i> Descargar plantilla
					</a>


					<div class="form-group">
						{{ Form::label('archivo', 'Archivo') }}
						{{ Form::file('archivo', [ 
							'class' => 'form-control',
							'accept' => '.xls*',
							'required',
						]) }}
					</div>

					<div class="progress">
						<div class="progress-bar progress-bar-primary" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
							<span class="valuePorcent"></span>
						</div>
					</div>

				</div>

				<div class="modal-footer">
					<div class="btn btn-link">
						<label>
							<input type="checkbox" id="scrollLog" checked> Scroll log
						</label>
					</div>
					{{ Form::button('<i class="fa fa-times" aria-hidden="true"></i> Cancelar', [ 'class'=>'btn btn-default', 'data-dismiss'=>'modal', 'type'=>'button', 'id'=>'cancelLoad' ]) }}
					{{ Form::button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Cargar', [ 'class'=>'btn btn-primary', 'type'=>'button', 'id'=>'cargarExcel', 'disabled' ]) }}

					<ul id="resultadosCarga" class="list-group" style="max-height: 150px; overflow-y: auto; margin-top: 10px;text-align: left;">
					</ul>
				</div>

			</div>

			{{ Form::close() }}
		</div>


	</div>
