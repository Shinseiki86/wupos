<div class="panel panel-default">
	<div class="panel-heading">{{ $preg->PREG_TITULO }}</div>
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
					<div class="form-group">
						@foreach($preg->itemPregs as $index => $itemPreg)
						<tr>
							<td>
								{{ $itemPreg->ITPR_TEXTO }}
							</td>
							<td name="preg_{{$preg->PREG_POSICION}}_item_{{$itemPreg->ITPR_POSICION}}">
								<input type="radio"
									name="{{'resp_preg_'.$preg->PREG_ID}}" 
									value="{{ $itemPreg->ITPR_ID }}"
									class="form-check-input"
									{{ $preg->PREG_REQUERIDO ? 'required' : ''}}>
							</td>
						</tr>
						@endforeach
					</div>
				 </tbody>
			</table>
		</div>
	</div>
</div>