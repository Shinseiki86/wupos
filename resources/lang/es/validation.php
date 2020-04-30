<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */

    'accepted'             => 'Debe ser aceptado.',
    'active_url'           => 'No es una URL válida.',
    'after'                => 'Debe ser una fecha posterior a :date.',
    'alpha'                => 'Solo debe contener letras.',
    'alpha_dash'           => 'Solo debe contener letras, números y guiones.',
    'alpha_num'            => 'Solo debe contener letras y números.',
    'array'                => 'Debe ser un conjunto.',
    'before'               => 'Debe ser una fecha anterior a :date.',
    'between'              => [
        'numeric' => 'Debe estar entre :min - :max.',
        'file'    => 'Debe pesar entre :min - :max kilobytes.',
        'string'  => 'Debe tener entre :min - :max caracteres.',
        'array'   => 'Debe tener entre :min - :max ítems.',
    ],
    'boolean'              => 'Debe tener un valor verdadero o falso.',
    'confirmed'            => 'La confirmación no coincide.',
    'date'                 => 'No es una fecha válida.',
    'date_format'          => 'No corresponde al formato :format.',
    'different'            => ':attribute y :other deben ser diferentes.',
    'digits'               => 'Debe tener :digits dígitos.',
    'digits_between'       => 'Debe tener entre :min y :max dígitos.',
    'dimensions'           => 'Las dimensiones de la imagen :attribute no son validas.',
    'distinct'             => 'contiene un valor duplicado.',
    'email'                => 'No es un correo válido',
    'exists'               => ':attribute es inválido.',
    'file'                 => 'debe ser un archivo.',
    'filled'               => 'Es obligatorio.',
    'image'                => 'Debe ser una imagen.',
    'in'                   => 'Es inválido.',
    'in_array'             => 'No existe en :other.',
    'integer'              => 'Debe ser un número entero.',
    'ip'                   => 'Debe ser una dirección IP válida.',
    'json'                 => 'Debe tener una cadena JSON válida.',
    'max'                  => [
        'numeric' => 'No debe ser mayor a :max.',
        'file'    => 'No debe ser mayor que :max kilobytes.',
        'string'  => 'No debe ser mayor que :max caracteres.',
        'array'   => 'No debe tener más de :max elementos.',
    ],
    'mimes'                => 'Debe ser un archivo con formato: :values.',
    'min'                  => [
        'numeric' => 'Tamaño debe ser de al menos :min.',
        'file'    => 'Tamaño debe ser de al menos :min kilobytes.',
        'string'  => 'Debe contener al menos :min caracteres.',
        'array'   => 'Debe tener al menos :min elementos.',
    ],
    'not_in'               => 'Es inválido.',
    'numeric'              => 'Debe ser numérico.',
    'present'              => 'Debe estar presente.',
    'regex'                => 'El formato es inválido.',
    'required'             => 'Es obligatorio.',
    'required_if'          => 'Es obligatorio cuando :other es :value.',
    'required_unless'      => 'Es obligatorio a menos que :other esté en :values.',
    'required_with'        => 'Es obligatorio cuando :values está presente.',
    'required_with_all'    => 'Es obligatorio cuando :values está presente.',
    'required_without'     => 'Es obligatorio cuando :values no está presente.',
    'required_without_all' => 'Es obligatorio cuando ninguno de :values estén presentes.',
    'same'                 => ':attribute y :other deben coincidir.',
    'size'                 => [
        'numeric' => 'El tamaño debe ser :size.',
        'file'    => 'El tamaño debe ser :size kilobytes.',
        'string'  => 'Debe contener :size caracteres.',
        'array'   => 'Debe contener :size elementos.',
    ],
    'string'               => 'Debe ser una cadena de caracteres.',
    'timezone'             => 'Debe ser una zona válida.',
    'unique'               => 'Ya ha sido registrado.',
    'url'                  => 'El formato es inválido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom'               => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes'           => [
        'name'                  => 'nombre',
        'username'              => 'usuario',
        'email'                 => 'correo electrónico',
        'first_name'            => 'nombre',
        'last_name'             => 'apellidos',
        'password'              => 'contraseña',
        'password_confirmation' => 'confirmación de la contraseña',
        'city'                  => 'ciudad',
        'country'               => 'país',
        'address'               => 'dirección',
        'phone'                 => 'teléfono',
        'mobile'                => 'móvil',
        'age'                   => 'edad',
        'sex'                   => 'sexo',
        'gender'                => 'género',
        'year'                  => 'año',
        'month'                 => 'mes',
        'day'                   => 'día',
        'hour'                  => 'hora',
        'minute'                => 'minuto',
        'second'                => 'segundo',
        'title'                 => 'título',
        'body'                  => 'contenido',
        'description'           => 'descripción',
        'excerpt'               => 'extracto',
        'date'                  => 'fecha',
        'time'                  => 'hora',
        'subject'               => 'asunto',
        'message'               => 'mensaje',
		
		
        'PAIS_ID'               => 'ID país',
        'PAIS_CODIGO'           => 'Código país',
        'PAIS_NOMBRE'           => 'Nombre país',
        'DEPA_ID'               => 'ID departamento',
        'DEPA_CODIGO'           => 'Código departamento',
        'DEPA_NOMBRE'           => 'Nombre departamento',

        'CIUD_CODIGO'           => 'Código ciudad',
        'CIUD_NOMBRE'           => 'Nombre ciudad',

        'ENCU_TITULO'           => 'Título',
        'ENCU_descripcion'      => 'Descripción',
        'ENCU_FECHAVIGENCIA'    => 'Fecha de Vigencia de la encuesta',

        'PREG_TITULO'           => 'Título',
        'PREG_texto'            => 'Formulación',

        'PRTI_id'               => 'Tipo de pregunta',
        'PRTI_descripcion'      => 'Descripción',

        'ENES_id'               => 'Estado de encuesta',
        'ENES_descripcion'      => 'Descripción',

    ],

];
