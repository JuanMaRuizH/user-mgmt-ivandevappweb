<?php

/*
 * A continuación se detallan los mensajes que le pueden llegar
 * al controlador y la lógica de proceso para cada uno de ellos.
 * 
 * - Si la petición proviene de un usuario ya validado
 *   - Proceso Cerrar Sesión
 *      -- Eliminar la sesión PHP
 *      -- Mostrar la vista "formlogin" con el formulario de login
 *   - Otro Caso
 *      -- Mostrar la vista "private" con la información personlaizada del usuario
 * - Sino
 *   - Petición Inicial
 *     -- Mostrar la vista "formlogin" de petición de credenciales para iniciar una sesión con la aplicación.
 *   - Proceso Formulario Login
 *     -- Leer los valores del formulario (nombre de usuasio y contraseña)
 *     -- Si los credenciales son correctos mostrar la vista "private" con información personaizada
 *              sino mostrar la vista "formlogin" con un mensaje de error de validación  
 * 
 */

session_start();
$credenciales = [["ivan", "ivan"], ["pepe", "pepe"]];
$error = false;

if (isset($_SESSION['username'])) {
    if (filter_input(INPUT_POST, 'botonenviologout')) {
        session_unset();
        session_destroy();
        setcookie(session_name(), '', 0, '/');
        include 'vistas/formlogin.php';
    } else {
        include 'vistas/private.php';
    }
} else {
    if (empty($_POST)) {
        include 'vistas/formlogin.php';
    } elseif (filter_input(INPUT_POST, 'botonenviologin')) {
        $nombre = trim(filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING));
        $contrasenia = trim(filter_input(INPUT_POST, 'contrasenia', FILTER_SANITIZE_STRING));
        if (in_array([$nombre, $contrasenia], $credenciales)) {
            $_SESSION['username'] = $nombre;
            include 'vistas/private.php';
            die;
        } else {
            $error = true;
            include 'vistas/formlogin.php';
            die;
        }
    }
}