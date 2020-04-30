{{-- 
	Modal con formulario para realizar carga de archivo excel con información para crear/actualizar registros.
	Las filas son procesadas por Javascript y enviadas una por una al controlador. -Shinseiki86-

		@include('widgets.modals.modal-import', ['model'=>'User'])
--}}

@push('scripts')
	{{--Librería para manejo de Excel --}}
	{!! Html::script('js/js-xlsx/shim.min.js') !!}
	{!! Html::script('js/js-xlsx/xlsx.core.min.js') !!}
	{!! Html::script('js/importModelFromExcel.js') !!}
	<script type="text/javascript">
		$(function() {
			initImportModelFromExcel('{{ route('app.createFromAjax',[$model]) }}', '{{ csrf_token() }}');
		})
	</script>
@endpush

{{ Form::button('<i class="fas fa-file-excel" aria-hidden="true"></i>',[
	'class'=>'btn btn-primary',
	'data-toggle'=>'modal',
	'data-target'=>'#pregModalImport',
	'data-tooltip'=>'tooltip',
	'title'=>'Importar desde Excel',
]) }}

@push('modals')
<div class="modal fade" id="pregModalImport" role="dialog" tabindex="-1" >
	<div class="modal-dialog">
	{{ Form::open( ) }}
		<div class="modal-content panel-info">

			<div class="modal-header panel-heading" style="border-top-left-radius: inherit; border-top-right-radius: inherit;">
				<h4 class="modal-title">
					Importar XLS
					<span class="pull-right">
						<a class='btn btn-info btn-xs' role='button' href="{{ asset('templates/TemplateImport'.$model.'.xlsx') }}" download>
							<i class="fas fa-download" aria-hidden="true"></i> Descargar plantilla
						</a>
					</span>
				</h4>
			</div>

			<div class="modal-body">

				<div class="form-group">
					{{ Form::label('archivo', 'Archivo') }}
					{{ Form::file('archivo', [ 
						'class' => 'form-control',
						'accept' => '.xls*',
						'required',
					]) }}
				</div>

				<div class="progress">
					<div class="progress-bar progress-bar-primary" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
						<span class="valuePorcent"></span>
					</div>
				</div>

			</div>

			<div class="modal-footer">

				<div class="btn btn-link">
					<label>
						<input type="checkbox" id="scrollLog" checked> Scroll log
					</label>
				</div>

				{{ Form::button('<i class="fa fa-times" aria-hidden="true"></i> Cancelar', [ 'class'=>'btn btn-default', 'data-dismiss'=>'modal', 'type'=>'button', 'id'=>'cancelLoad' ]) }}
				{{ Form::button('<i class="fa fa-save" aria-hidden="true"></i> Cargar', [ 'class'=>'btn btn-primary', 'type'=>'button', 'id'=>'cargarExcel', 'disabled' ]) }}

				<ul id="resultadosCarga" class="list-group" style="max-height: 150px; overflow-y: auto; margin-top: 10px;text-align: left;">
				</ul>

			</div>
		</div>
	{{ Form::close() }}
	</div>
</div>
@endpush
