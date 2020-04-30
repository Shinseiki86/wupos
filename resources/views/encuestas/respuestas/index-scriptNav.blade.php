<script type='text/javascript'>

	$.validator.messages.required = '¡Campo requerido!';
	var form = $('#formResps');
	form.validate({
		errorPlacement: function(error, element) {
			if(error.text() != ""){
				var item = element.closest('.itemValidate');
				error
					.appendTo(item.find('.showError'))
					.parent().parent().addClass('bg-danger');
			}
		},
		success: function(label) {
			label
				.text('')
				.parent().parent().removeClass('bg-danger');
		}
	});
	form.validate().settings.ignore = ':disabled,:hidden';

	$('.btnControl').click(function (e) {
		e.preventDefault()
		var btnClick = $( this )
		var target = $('#tabsPregs li.active');

		//Si el botón es tipo submit, envía el form
		if( btnClick.attr('type') === 'submit') {
			if( form.valid() ){
				var modal = $('#msgModalSaving');
				if(form[0].hasAttribute('readonly')){
					modal.find('#modal-text').html('Prueba exitosa!');
					modal.find('.modal-footer').removeClass('hide');
					modal.find('#iconFont').removeClass('fa-spinner fa-pulse').addClass('fa-thumbs-o-up');
					modal.prop('tabindex', -1).modal('show');
				} else {
					btnClick.attr('disabled', true);
					modal.modal({backdrop: 'static', keyboard: false});
					modal.find('#modal-text').html('Guardando respuestas...');
					modal.find('#iconFont').addClass('fa-spinner fa-pulse');
					modal.find('.modal-footer').addClass('hide');
					modal.modal('show');
					return form.submit();
				}
			} else {
				showModalError();
			}
		}

		var sibling = null;
		if(btnClick.data('control') === 'next') //Si el control del botón es next (sig)...
			sibling = target.next();
		else //Sino, entonces contról del botón debe ser prev (ant)...
			sibling = target.prev();
		
		//Si el pariente es <li>, entonces se selecciona/activa
		if ( sibling.is( 'li' ) ){
			if(form.valid()){
				sibling.removeClass('disabled')
				sibling.find('a').attr('data-toggle','tab')
				sibling.children('a').trigger('click');
				
				//Valida si la siguiente es la última pregunta
				validaUltimaPreg(target.next(), btnClick);
			} else {
				showModalError();
			}
		}

	});

	//Valida si target es la última pregunta del formulario.
	function validaUltimaPreg(target, btnClick){
		//Si target corresponde al último <li> (last-child) y el evento lo produce el btn next...
		//entonces cambiar botón a submit.
		if( target.is( 'li:last-child' ) && btnClick.data('control') === 'next' ){
			//var btnNext = $('[data-control=='next']'); //No funciona ¿?
			$('.btnNext')
				//.removeClass('btn-xs').addClass('btn-sm')
				.removeClass('btn-primary').addClass('btn-success')
				.html('<i class="fa fa-save" aria-hidden="true"></i> Enviar')
				.attr('type', 'submit');
		} else {
			$('.btnNext')
				//.removeClass('btn-sm').addClass('btn-xs')
				.removeClass('btn-success').addClass('btn-primary')
				.html('<i class="fa fa-arrow-right" aria-hidden="true"></i> Sig<span class="hidden-xs">uiente</span>')
				.attr('type', 'button');
		}
	}

	//Muestra modal informando que hay campos obligatorios pendientes por diligenciar.
	function showModalError(){
		modal = $('#msgModalSaving');
		modal.find('#iconFont').removeClass('fa-spinner fa-pulse').addClass('fa-exclamation-triangle');
		modal.find('#modal-text').html('Hay datos pendientes por responder.');
		modal.find('.modal-footer').removeClass('hide');
		modal.prop('tabindex', -1).modal('show');
	}

	
	// Select first tab
	$('#tabsPregs a:first').tab('show');
	validaUltimaPreg($('#tabsPregs li.active'), $('.btnNext'));

	/*disable non active tabs*/
	$('#tabsPregs li')
		.not('.active').addClass('disabled')
		.not('.active').find('a').removeAttr('data-toggle');

	/*$('#tabsPregs a').click(function (e) {
		e.preventDefault()
		form.validate().settings.ignore = ':disabled,:hidden';
		return form.valid()
	})*/


	//Contador pra finalizar la fecha de vigencia de la encuesta
	$('#countdownVigencia').countdown('{{$encuesta->ENCU_FECHAVIGENCIA}}', function(event) {
		$(this).html(event.strftime('%-w semana%!w %-d día%!D %H:%M:%S'));
	}).on('finish.countdown', function(event) {
		//Al cumplise la fecha...
		modal = $('#msgModalSaving');
		modal.modal({backdrop: 'static', keyboard: false});
		modal.find('#modal-text').html('¡La fecha de vigencia ha finalizado!');
		modal.find('#iconFont').removeClass('fa-spinner fa-pulse').addClass('fa-exclamation-triangle');
		modal.find('.modal-footer').addClass('hide');
		modal.modal('show');
		window.setTimeout(function(){ location.reload(); }, 5000);

	});
	
</script>