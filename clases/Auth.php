<?php

namespace App;

class Auth {

    public static function init() {
        session_start();
    }

    public static function logout() {
        session_unset();
        session_destroy();
        setcookie(session_name(), '', 0, '/');
    }

    public static function login($usuario) {
        $_SESSION['usuario'] = $usuario;
    }

    public static function loggedUsuario() {
        return (isset($_SESSION['usuario']) ? $_SESSION['usuario'] : false);
    }

    public static function check() {
        return (isset($_SESSION['usuario']));
    }

}
