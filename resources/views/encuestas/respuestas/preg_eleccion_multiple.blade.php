<div class="panel panel-default">
	<div class="panel-heading">{{ trim($preg->PREG_TITULO) }}</div>
	<div class="panel-body">
		
		<div class="itemValidate">
			<div class="col-xs-12">
				{{ Form::label('preg', 'Pregunta '.$preg->PREG_POSICION.':') }}
				{!! str_replace('script', '', $preg->PREG_TEXTO) !!}
				<span class="showError"></span>
			</div>

			<table class="table table-striped">
				<thead>
					<tr>
						<th></th>
						<th style="width:50px;"></th>
					</tr>
				</thead>
				<tbody>
					@foreach($preg->itemPregs as $index => $itemPreg)
					<tr>
						<td>
							{{ $itemPreg->ITPR_TEXTO }}
						</td>
						<td name="preg_{{$preg->PREG_POSICION}}_item_{{$itemPreg->ITPR_POSICION}}" class="text-center escala">
							<input type="checkbox"
								{{--title="Debe seleccionar mínimo una opción!"--}}
								name="{{'resp_pregitem_'.$itemPreg->ITPR_ID}}" 
								value="{{ $itemPreg->ITPR_ID }}"
								class="form-check-input"
								{{-- $preg->PREG_REQUERIDO ? 'required' : ''--}}>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
