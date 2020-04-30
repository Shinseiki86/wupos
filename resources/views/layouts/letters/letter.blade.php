<!DOCTYPE html>
<html lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title></title>

		<style type="text/css">
			@page {
				margin-top: 120px;
				margin-bottom: 82px;
				margin-left: 40px;
				margin-right: 40px;
			}
			.page-break { page-break-after: always; }
			.header{
				position: fixed;
				top: -120px;
				width: 100%;
				margin-left: 20px;
				margin-right: 20px;
			}
			.title{
				position: absolute;
				top: -90px;
				width: 100%;
				text-align: center;
			}
			.title>h2{margin-bottom: 0;}
			.title>h3{margin-top: 0;}
			.footer{
				position: fixed;
				bottom: 30px;
				width: 100%;
				color: #606060;
				margin-left: 20px;
				margin-right: 20px;
			}

			body{
				padding-left:20px;
				padding-right:20px;
				font-family:Arial;
				/*font-size: 12px;*/
			}

			thead{ background-color: LightGray; }
			table { border-collapse: collapse; }
			table#info-docente{width:950px;/*table-layout: fixed;*/}
			table#result-encuesta{width:940px;}
			table, td, th { border: 1px solid black; }
			.td-text{ text-align: justify; }
			.td-number{
				text-align: center;
				width:50px;
			}
		</style>
		@stack('head')
	</head>
	
	<body>

		<div class="header">
			<p align="right">
				<img src="{{ asset('assets/images/empleadores/'.$empleador->EMPL_ID.'/logo.png') }}" height="70" />
			</p>
			<hr style="color:gray;">
		</div>

		<div class="footer">
			<p align="right" style="font-family:Arial;">
				<img src="{{ asset('assets/images/empleadores/'.$empleador->EMPL_ID.'/footer.png') }}" height="40" />
				<img src="{{ asset('assets/images/empleadores/'.$empleador->EMPL_ID.'/signaturecert.png') }}" height="50"  />
			</p>
			<p align="right" style="font-family:Arial; font-size: 10px;">
				Dirección <b>{{ $empleador->EMPL_DIRECCION }}</b> | Teléfono <b>{{ $empleador->EMPL_TELEFONO }}</b> | Fax: <b>{{ $empleador->EMPL_FAX }}</b>
			</p>
		</div>

		@yield('content')
		@yield('signature')

	</body>
</html>