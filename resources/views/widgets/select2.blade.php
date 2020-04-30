@push('head')
{!! Html::style('css/select2/select2.min.css') !!}
{!! Html::style('css/select2/select2-bootstrap.min.css') !!}
<style type="text/css">
	/*Fix para select ocultos*/
	.selectpicker {width: 100% !important;}
	.select2-results__options .select2-results__options--nested{margin-left: 15px;}
	.select2-container--bootstrap .select2-results__option[aria-selected=true]{
		background-color: #d6d6d6;
		color: #262626
	}
	span.select2.select2-container{width:100% !important;}
</style>
@endpush

@push('scripts')
{!! Html::script('js/select2/select2.min.js') !!}
{!! Html::script('js/select2/es.js') !!}

<script>
	$(function () {
		jQuery('select.readonly option:not(:selected)').attr('disabled',true);
		$.fn.select2.defaults.set('theme', 'bootstrap');
		$.fn.select2.defaults.set('width', '100%');
		$('.selectpicker').select2();
		$('.selectpickerAjax').select2({
			ajax: {
				cache: true,
				delay: 250,
				//headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: function (params) {
					return { q: params.term };
				},
				processResults: function (data) {
					return {results: $.map( data, function( value, index ) {
						return {id: index, text: value};
					})};
				}
			},
		});
	});

	$('form').on('reset', function() {
		$('.selectpicker').val([]).trigger('change');
	});
</script>
@endpush











