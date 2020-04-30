@push('head')
	{!! Html::style('css/spectrum.css') !!}
@endpush

@push('scripts')
	{!! Html::script('js/spectrum.js') !!}
	<script type="text/javascript">
		$(".input-color").spectrum({
		    color: 'red',
		    showPalette: true,
		    palette: [
		        ['red','yellow','green'],
		        ['blue','magenta','cyan'],
		        ['orange','grey','deepskyblue'],
		        ['pink','saddlebrown']
		    ]
		});
	</script>
@endpush