<?php

return [

    'unique' => 'El campo :attribute ya ha sido registrado',
    'required' => 'El campo :attribute es requerido',
    'max' => [
        'numeric' => 'El campo :attribute no puede ser mayor a :max',
        'file' => 'El campo :attribute no puede ser mayor a :max kilobytes',
        'string' => 'El campo :attribute no puede ser mayor a :max caracteres',
        'array' => 'El campo :attribute no puede tener más de :max elementos',
    ],
    'min' => [
        'numeric' => 'El campo :attribute debe ser al menos :min',
        'file' => 'El campo :attribute debe ser al menos :min kilobytes',
        'string' => 'El campo :attribute debe ser al menos :min caracteres',
        'array' => 'El campo :attribute debe tener al menos :min elementos',
    ],
    'email' => 'El campo :attribute debe ser una dirección de correo válida',
    'confirmed' => 'El campo :attribute no coincide',
    'date' => 'El campo :attribute no es una fecha válida',
    'numeric' => 'El campo :attribute debe ser un número',
    'integer' => 'El campo :attribute debe ser un número entero',
    'string' => 'El campo :attribute debe ser una cadena de caracteres',
    'alpha' => 'El campo :attribute debe contener solo letras',
    'min_digits' => 'El campo :attribute debe tener al menos :min_digits dígitos',
    'max_digits' => 'El campo :attribute no puede tener más de :max_digits dígitos',
    'between_digits' => 'El campo :attribute debe tener entre :min_digits y :max_digits dígitos',
    'between' => 'El campo :attribute debe estar entre :min y :max',

];
