<?php

define("REGEXP_IDENTIFICADOR", "^\w{3,25}$");
define("REGEXP_IDENTIFICADOR_DESC", "El identificador tiene entre 3 y 25 caracteres sin tildes, incluyendo letras, números y guiones");

define("REGEXP_CLAVE", "^(?=.*\d).{4,8}");
define("REGEXP_CLAVE_DESC", "La clave tiene entre 4 y 8 caracteres sin tildes e incluye al menos un número");

define("REGEXP_NOMBRE", "^[\wñáéíóú ]{3,30}");
define("REGEXP_NOMBRE_DESC", "El nombre tiene entre 3 y 30 caracteres");

define("REGEXP_APELLIDOS", "^[\wñáéíóú ]{3,70}");
define("REGEXP_APELLIDOS_DESC", "Los apellidos tienen entre 3 y 70 caracteres");

define("REGEXP_OCUPACION", "^[\wñáéíóú ]{3,100}");
define("REGEXP_OCUPACION_DESC", "La ocupación tiene entre 3 y 100 caracteres e incluye letras, números y guiones");

define("REGEXP_EMAIL", ".+@[^\.].*\.[a-z]{2,}");
define("REGEXP_EMAIL_DESC", "El correo electrónico debe tener el formato correcto");

$c = 'constant';
define(
    'REGLAS',
 ['identificador' => [['required', 'message' => 'Debe rellenar este campo'], ['regex', "/{$c('REGEXP_IDENTIFICADOR')}/", 'message' => REGEXP_IDENTIFICADOR_DESC]],
          'clave' => [['required', 'message' => 'Debe rellenar este campo'], ['regex', "/{$c('REGEXP_CLAVE')}/", 'message' => REGEXP_CLAVE_DESC]],
          'nombre' => [['regex', "/{$c('REGEXP_NOMBRE')}/", 'message' => REGEXP_NOMBRE_DESC]],
          'apellidos' => [['regex', "/{$c('REGEXP_APELLIDOS')}/", 'message' => REGEXP_APELLIDOS_DESC]],
          'ocupacion' => [['regex', "/{$c('REGEXP_OCUPACION')}/", 'message' => REGEXP_OCUPACION_DESC]],
          'email' => [['email', 'message' => REGEXP_EMAIL_DESC]]
]
);

// Lista de patrones utilizados para validar el formulario en el cliente

define(
    'PATRONES',
 ['identificador' => ['regexp' => REGEXP_IDENTIFICADOR, 'mensaje' => REGEXP_IDENTIFICADOR_DESC],
 'nombre' => ['regexp' => REGEXP_NOMBRE, 'mensaje' => REGEXP_NOMBRE_DESC],
 'clave' => ['regexp' => REGEXP_CLAVE, 'mensaje' => REGEXP_CLAVE_DESC],
 'apellidos' => ['regexp' => REGEXP_APELLIDOS, 'mensaje' => REGEXP_APELLIDOS_DESC],
 'ocupacion' => ['regexp' => REGEXP_OCUPACION, 'mensaje' => REGEXP_OCUPACION_DESC],
 'email' => ['regexp' => REGEXP_EMAIL, 'mensaje' => REGEXP_EMAIL_DESC]
]
);