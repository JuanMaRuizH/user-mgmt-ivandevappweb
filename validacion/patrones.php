<?php

define("REGEXP_IDENTIFICADOR", "^\w{3,25}$");
define("REGEXP_IDENTIFICADOR_DESC", "El identificador tiene entre 3 y 25 caracteres, incluyendo letras, números y guiones");

define("REGEXP_CLAVE", "^(?=.*\d).{4,8}$");
define("REGEXP_CLAVE_DESC", "La clave tiene entre 4 y 8 caracteres e incluye al menos un número");

define("REGEXP_NOMBRE", "^[\p{L} '.]{3,30}$");
define("REGEXP_NOMBRE_DESC", "El nombre tiene entre 3 y 30 caracteres");

define("REGEXP_APELLIDOS", "^[\p{L} '.]{3,70}$");
define("REGEXP_APELLIDOS_DESC", "Los apellidos tienen entre 3 y 70 caracteres");

define("REGEXP_OCUPACION", "^[\p{L} ]{3,100}");
define("REGEXP_OCUPACION_DESC", "La ocupación tiene entre 3 y 100 caracteres e incluye letras, números y guiones");

define("REGEXP_EMAIL", ".+@[^\.].*\.[a-z]{2,}");
define("REGEXP_EMAIL_DESC", "El correo electrónico debe tener el formato correcto");