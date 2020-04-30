@push('head')
	{!! Html::style('css/jquery/jquery-ui.min.css') !!}
	{!! Html::style('css/jquery/jquery.ui.autocomplete.css') !!}
@endpush

@push('scripts')
	{!! Html::script('js/jquery/jquery-ui.min.js') !!}  
	<script type="text/javascript">
	$(function () {
		$("#{{ $first }}").autocomplete({
			source: function(request, response) {
				$.ajax({
					url: '{!! URL::route($ruta) !!}',
					dataType: "json",
					data: {
						term : request.term
					},
					success: function(data) {
						response(data);                   
					}
				});
			},
			minLength:1,
			select:function(e,ui){
				$('#{{ $first }}').val(ui.item.value);   
				@if (isset($cod))
					$('#{{ $cod }}').val(ui.item.cod);  
				@endif
				@if (isset($id))
					$('#{{ $id }}').val(ui.item.id); 
				@endif
			},
			autofocus:true,
		});
	});
	</script>
@endpush


{{-- 
@include('widgets.autocomplete',['first'=>'DX_DESCRIPCION','ruta'=>'autocomplete','cod'=>'CIE10','id'=>'DIAG_ID'])

public function autoComplete(Request $request) {
	$term = $request->term;
	$data=Diagnostico::where('DIAG_DESCRIPCION','LIKE','%'.$term.'%')
		->take(10)
		->get();
	$results=array();
	foreach ($data as $v) {
			$results[]=['id'=>$v->DIAG_ID,'value'=>$v->DIAG_DESCRIPCION,'cod'=>$v->DIAG_CODIGO];
	}
	if(count($results))
		 return $results;
	else
		return ['value'=>'No se encontró ningun Resultado','id'=>''];
} --}}
