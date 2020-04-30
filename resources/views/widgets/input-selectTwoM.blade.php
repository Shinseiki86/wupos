@push('head')
  {!! Html::style('css/select2/select2.min.css') !!}
  {!! Html::style('css/select2/select2-bootstrap.min.css') !!}
@endpush

@push('scripts')
  {!! Html::script('js/select2/select2.min.js') !!}
  {!! Html::script('js/select2/es.js') !!}
  <script>
    @foreach($columns as $col)      
      $("#{{$col['name']}}").select2({
        allowClear: {{isset($col['allowClear'])?'true':'false'}},
        placeholder: "{{isset($col['placeholder'])?$col['placeholder']:''}}",
        theme: "bootstrap",
        
      });
    @endforeach
</script> 
@endpush

{{-- ejemplo de llamado
  @include('widgets.forms.input-selectTwoM',['columns'=>[['name'=>'PROS_ID','placeholder'=>'Seleccione un Departamento','allowClear'=>true],['name'=>'EMPL_ID','placeholder'=>'Seleccione un Departamento','allowClear'=>true],['name'=>'TEMP_ID','placeholder'=>'Seleccione un Departamento','allowClear'=>true]]])
  --}}
  