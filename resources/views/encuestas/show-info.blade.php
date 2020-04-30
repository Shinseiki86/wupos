@if(!$encuesta->ENCU_PLANTILLA)
@push('head')
	<style type="text/css">
		div.new_html_code {
			height:50px;
			min-height:50px;
			overflow:hidden;
			display:block;
			/*border:1px solid red;*/
		}
		.carousel-caption{
			color: #000;
			text-shadow: none;
			bottom: 10px;
			padding-bottom: 0px;
		}
		.carousel-control {
			width: 10%;
			bottom: 50%;
			color: #000;
		}
		.carousel-control:focus, .carousel-control:hover {
    		color: #000;
    	}
    	.carousel-control.left, .carousel-control.right {
		    background-image: none;
		}
		.carousel-indicators {
    		bottom: 40px;
		}
		.carousel-indicators li {
		    border: 1px solid #ccc;
		}
		.carousel-indicators .active {
		    background-color: #000;
		}
	</style>
@endpush

<div id="infoEncuesta" class="carousel slide" data-ride="carousel">
	<!-- Indicators -->
	<ol class="carousel-indicators">
		<li data-target="#infoEncuesta" data-slide-to="0" class="active"></li>
		<li data-target="#infoEncuesta" data-slide-to="1"></li>
		<li data-target="#infoEncuesta" data-slide-to="2"></li>
		<li data-target="#infoEncuesta" data-slide-to="3"></li>
		<li data-target="#infoEncuesta" data-slide-to="4"></li>
		@if($encuesta->isClosed())
		<li data-target="#infoEncuesta" data-slide-to="5"></li>
		@endif
		@if($encuesta->isDeleted())
		<li data-target="#infoEncuesta" data-slide-to="6"></li>
		@endif
	</ol>

	<!-- Wrapper for slides -->
	<div class="carousel-inner" role="listbox">
		<div class="item active">
			<div class="new_html_code"></div>
			<div class="carousel-caption">
				<strong>Estado:</strong><br>
				{{ $encuesta->estado->ENES_DESCRIPCION }}
			</div>
		</div>

		<div class="item">
			<div class="new_html_code"></div>
			<div class="carousel-caption">
				<strong>Vigencia:</strong><br>
				{{ datetime($encuesta->ENCU_FECHAVIGENCIA, true) }}
			</div>
		</div>

		<div class="item">
			<div class="new_html_code"></div>
			<div class="carousel-caption">
				<strong>Usuarios con respuesta:</strong><br>
				{{ $encuesta->total_usuarios }}
			</div>
		</div>

		<div class="item">
			<div class="new_html_code"></div>
			<div class="carousel-caption">
				<strong>Total respuestas:</strong><br>
				{{ $encuesta->count_resps }}
			</div>
		</div>

		<div class="item">
			<div class="new_html_code"></div>
			<div class="carousel-caption">
				<strong>Último movimiento:</strong><br>
				{{ $encuesta->fecha_ult_resp ? $encuesta->fecha_ult_resp->diffForHumans() : 'Sin respuestas' }}
			</div>
		</div>

		@if($encuesta->isClosed())
		<div class="item">
			<div class="new_html_code"></div>
			<div class="carousel-caption">
				<strong>Motivo cierre:</strong><br>
				{{ $encuesta->ENCU_MOTIVOCIERRE ? $encuesta->ENCU_MOTIVOCIERRE : 'Finalizada' }}
			</div>
		</div>
		@endif

		@if($encuesta->isDeleted())
		<div class="item">
			<div class="new_html_code"></div>
			<div class="carousel-caption">
				<strong>Motivo eliminación:</strong><br>
				{{ $encuesta->ENCU_MOTIVOBORRADO }}
			</div>
		</div>
		@endif
	</div>

	<!-- Controls -->
	<a class="left carousel-control" href="#infoEncuesta" role="button" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		<span class="sr-only">Ant</span>
	</a>
	<a class="right carousel-control" href="#infoEncuesta" role="button" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		<span class="sr-only">Sig</span>
	</a>
</div>
@endif