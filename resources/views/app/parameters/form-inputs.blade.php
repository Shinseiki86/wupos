{{--@include('widgets.datepicker')--}}
{{-- @include('widgets.select2') --}}

@include('widgets.forms.input', ['type'=>'text', 'name'=>'PGLO_DESCRIPCION', 'label'=>'Descripción', 'options'=>['maxlength' => '100', 'required'] ])

@include('widgets.forms.input', ['type'=>'text', 'name'=>'PGLO_VALOR', 'label'=>'Valor', 'options'=>['maxlength' => '100', 'required'] ])

@include('widgets.forms.input', [ 'type'=>'textarea', 'name'=>'PGLO_OBSERVACIONES', 'label'=>'Observaciones', 'options'=>['maxlength' => '300'] ])