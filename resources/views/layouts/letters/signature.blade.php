@push('head')
	<style type="text/css">
		.signature{
			position: fixed;
			bottom: 400px;
			margin-left: 20px;
			margin-right: 20px;
		}
	</style>
@endpush

@section('signature')
	<div class="signature">
		Cordialmente,
		<br>
		<p align="left">
			<img src="{{ asset('assets/images/empleadores/'.$empleador->EMPL_ID.'/signaturerep.png') }}" height="140" />
		</p>

		<p align="left" style="font-family:Arial;">
			<b>{{ $empleador->responsable->nombre_completo }}</b><br>
			{{ $empleador->responsable->contratos()->activos()->first()->cargo->CARG_DESCRIPCION }}<br>
			{{ $empleador->EMPL_RAZONSOCIAL }}<br>
			<b>Pbx:</b> {{ $empleador->EMPL_TELEFONO }}<br>
			<img src="{{ asset('assets/images/empleadores/'.$empleador->EMPL_ID.'/footer_logo.png') }}" height="40" />
		</p>

		<p align="justify" style="font-family:Arial; font-size: 12px;">
			<b>Nota:</b> Este certificado fue generado de forma automática por nuestro sistema de información. Para verificar esta información, ingrese a la página
			web: <b>http://certificados.promoambiental.com</b> y use el código de verificación que se detalla a continuación.
		</p>

		<p align="center" style="font-family:Arial;">
			<b>Código de Verificación: {{ $certificado->CERT_ID }}</b>
		</p>
	</div>
@endsection
