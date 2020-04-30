
@push('scripts')
{!! Html::script('js/ckeditor/ckeditor.js') !!}
{!! Html::script('js/ckeditor/adapters/jquery.js') !!}
<script type="text/javascript">
	$(function () {

		$('.ckeditor').ckeditor();
		$('.ckeditor').change(function() {
			divHidden = $(this).parents('.checkbox').parent();
			if($(this).is(":checked")) {
				divHidden.removeClass('hidden');
			} else {
				divHidden.addClass('hidden');
			}
		}).trigger('change');

	});
</script>
@endpush