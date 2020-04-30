{{-- Botones de navegación de preguntas --}}
<div class="row">
	<div class="col-xs-6">
		<a name="btn-cancel" class="btn btn-sm btn-warning" role="button" href="{{ $preview == true ? URL::to('encuestas/'.$ENCU_ID) : URL::to('encuestas') }}" data-tooltip="tooltip" title="Salir del formulario.">
			<i class="fa fa-times" aria-hidden="true"></i> Cancelar
		</a>
	</div>
	<div class="col-xs-6 text-right">
		<button name="btn-prev" class="btn btn-sm btn-primary btnControl btnPrev" type="button" data-control="prev">
			<i class="fa fa-arrow-left" aria-hidden="true"></i> Ant<span class="hidden-xs">erior</span>
		</button>
		<button name="btn-next" class="btn btn-sm btn-primary btnControl btnNext" type="button" data-control="next">
			<i class="fa fa-arrow-right" aria-hidden="true"></i> Sig<span class="hidden-xs">uiente</span>
		</button>
	</div>
</div>