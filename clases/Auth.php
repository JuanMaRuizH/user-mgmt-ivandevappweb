<?php

namespace App;

class Auth {

    protected static $auth = null;

    public static function getAuth() {
        if (!self::$auth) {
            self::$auth = new Auth();
        }
        return self::$auth;
    }

    public function init() {
        session_start();
    }

    public function logout() {
        session_unset();
        session_destroy();
        setcookie(session_name(), '', 0, '/');
    }

    public function login($usuario) {
        $_SESSION['usuario'] = $usuario;
    }

    public function loggedUsuario() {
        return $_SESSION['usuario'];
    }

    public function check() {
        return (isset($_SESSION['usuario']));
    }

}
