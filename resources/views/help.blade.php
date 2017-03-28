@extends('layout')
@section('title', '/ Ayuda')

@section('head')
	{!! Html::script('assets/js/PDFObject/pdfobject.min.js') !!}
	<style>
		.pdfobject-container {
			width: 800px;
			max-width: 800px;
			height: 600px;
			margin: 2em 0;
		}
		.pdfobject { border: solid 1px #666; }
		#results { padding: 1rem; }
		.hidden { display: none; }
		.success { color: #4F8A10; background-color: #DFF2BF; }
		.fail { color: #D8000C; background-color: #FFBABA; }
	</style>
@parent
@endsection

@section('scripts')
@parent
@endsection

@section('content')

	<h1 class="page-header">Help!</h1>

	<div class="pull-left">
		<div class="panel panel-info" >
			<div class="panel-heading">¡Ayuda!</div>
			<div class="panel-body">
				En esta sección se documentará información sobre la app.<br>
				<div id="pdfRenderer"></div>
				<script>
					var options = {
						pdfOpenParams: {
							pagemode: "bookmarks",
							navpanes: 1,
							toolbar: 0,
							statusbar: 0,
							view: "FitV"
						},
						fallbackLink: '<div class="alert alert-warning">El navegador no soporta jsPDF.<br>Por favor descargar el pdf para su visualización.<br><a href="[url]" class="alert-link">Descargar Manual</a></div>'
					};
					PDFObject.embed(
						"manuales/Manual_Encuestas.pdf",
						"#pdfRenderer",
						options
					);
				</script>
			</div>
		</div>
	</div>

	<div class="pull-right">
		<div class="panel panel-primary">
			<div class="panel-heading">Acerca de...</div>

			<div class="panel-body">
					<strong>UNIAJC</strong>
					Institución Universitaria Antonio José Camacho
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">Acerca de...</div>

			<div class="panel-body">
					<strong>UNIAJC</strong>
					Institución Universitaria Antonio José Camacho
			</div>
		</div>
	</div>

@endsection
