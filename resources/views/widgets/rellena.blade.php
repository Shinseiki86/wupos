
@push('scripts')  
  	<script>
   		@foreach($columns as $col =>$value)	   			
			$("#{{$col}}").val('{!! str_replace('script', '', $value) !!}');	
		@endforeach
	</script> 
@endpush