@push('head')
	{!! Html::style('css/fontawesome-iconpicker.min.css') !!}
@endpush

@push('scripts')
	{!! Html::script('js/fontawesome-iconpicker.min.js') !!}
	<script type="text/javascript">
		$('.icp').iconpicker();
	</script>
@endpush
