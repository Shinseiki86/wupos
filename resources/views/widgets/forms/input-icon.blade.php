@push('head')
	{!! Html::style('css/font-awesome/fontawesome-iconpicker.min.css') !!}
@endpush

@push('scripts')
	{!! Html::script('js/font-awesome/fontawesome-iconpicker.min.js') !!}
	<script type="text/javascript">
		var inputIcon = $('.icp');
		if(inputIcon.val()==''){
			inputIcon.val('fas fa-comment-alt');
		}
		inputIcon.iconpicker();
		
	</script>
@endpush

<div class="input-group">
	{{ Form::text( $name, old($name), ['class'=>'form-control icp'] + (isset($options)?$options:[]) ) }}
    <span class="input-group-addon"></span>
</div>
