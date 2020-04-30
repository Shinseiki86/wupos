<div class="panel panel-default">
	<div class="panel-heading">
		{{ $preg->PREG_TITULO }}
	</div>
	<div class="panel-body">
		<div class="col-xs-12">
			{{ Form::label('preg', 'Pregunta '.$preg->PREG_POSICION.':') }}
			{!! str_replace('script', '', $preg->PREG_TEXTO) !!}
		</div>
		<table class="table table-striped">
			<thead>
				<tr>
					<th></th>
					@for ($i=1; $i <= 5; $i++)
					<th class="text-center escala">{{ $i }}</th>
					@endfor
				</tr>
			</thead>
			<tbody>
				@foreach($preg->itemPregs as $itemPreg)
				<tr name="preg_{{$preg->PREG_POSICION}}_item_{{ $itemPreg->ITPR_POSICION }}" class="itemValidate">
					<td class="text-justify">
						{{ $itemPreg->ITPR_TEXTO }}
						<span class="showError"></span>
					</td>
					@for ($i=1; $i <= 5; $i++)
					<td name="input-{{$i}}" class="text-center escala">
						<input type="radio"
							name="{{'resp_pregitem_'.$itemPreg->ITPR_ID}}"
							value="{{ $i }}"
							class="form-check-input"
							{{ $preg->PREG_REQUERIDO ? 'required' : ''}}
							data-tooltip="tooltip"
							title="{{ $i }}">
					</td>
					@endfor
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>