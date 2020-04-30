<div class="panel panel-default">
	<div class="panel-heading">{{ $preg->PREG_TITULO }}</div>
	<div class="panel-body">
		
		<div class="row form-group itemValidate">

			<div class="col-xs-12 col-md-8">
				{{ Form::label('preg', 'Pregunta '.$preg->PREG_POSICION .':') }}
				{!! str_replace('script', '', $preg->PREG_TEXTO) !!}
				<span class="showError"></span>
			</div>

			<div class="col-xs-4 col-xs-offset-1 col-sm-2 col-md-2 col-md-offset-0">
				<div name="input-SI" class="radio">
					<div class="input-group">
						{{ Form::label('resp_SI_preg_'.$preg->PREG_ID, 'SI', [ 'class'=>'form-control form-check-label' ]) }}
						<span class="input-group-addon">
							{{ Form::radio('ENCU_PLANTILLA', 1, old('ENCU_PLANTILLA'), [
								'id'=>'resp_SI_preg_'.$preg->PREG_ID,
								'name'=>'resp_preg_'.$preg->PREG_ID,
								'class' => 'form-check-input',
								'style'=> 'position: relative; margin-left: 0px;',
								$preg->PREG_REQUERIDO ? 'required' : ''
							])}}
						</span>
					</div>
				</div>
			</div>

			<div class="col-xs-4 col-xs-offset-1 col-sm-2 col-md-2 col-md-offset-0">
				<div name="input-NO" class="radio">
					<div class="input-group">
						{{ Form::label('resp_NO_preg_'.$preg->PREG_ID, 'NO', [ 'class'=>'form-control form-check-label' ]) }}
						<span class="input-group-addon">
							{{ Form::radio('ENCU_PLANTILLA', 0, old('ENCU_PLANTILLA'), [
								'id'=>'resp_NO_preg_'.$preg->PREG_ID,
								'name'=>'resp_preg_'.$preg->PREG_ID,
								'class' => 'form-check-input',
								'style'=> 'position: relative; margin-left: 0px;',
							])}}
						</span>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
