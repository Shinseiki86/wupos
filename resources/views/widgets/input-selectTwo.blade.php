@push('head')
  {!! Html::style('css/select2/select2.min.css') !!}
  {!! Html::style('css/select2/select2-bootstrap.min.css') !!}
@endpush

@push('scripts')
  {!! Html::script('js/select2/select2.min.js') !!}
  {!! Html::script('js/select2/es.js') !!}

  <script>
    $("#{{$name}}").select2({
      allowClear: {{isset($allowClear)?'true':'false'}},
      placeholder: "{{isset($placeholder)?$placeholder:''}}",
      theme: "bootstrap",      
    });
</script> 
@endpush
{{-- ejemplo de llamado
  @include('widgets.forms.input-selectTwo',['name'=>'EMPL_ID','placeholder'=>'Seleccione un Departamento','allowClear'=>true])
  --}}
