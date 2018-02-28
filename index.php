<?php

/*
 * A continuación se detallan los mensajes que le pueden llegar
 * al controlador y la lógica de proceso para cada uno de ellos.
 * 
 * - Si la petición proviene de un usuario ya validado
 *   - Proceso Cerrar Sesión
 *      -- Eliminar la sesión PHP
 *      -- Mostrar la vista "formlogin" con el formulario de login
 *   - Petición de formulario de Perfil
 *      -- Mostrar la vista perfil con el formulario de perfil del usuario
 *   - Petición de Proceso de datos de perfil
 *      -- Recuperar el usuario de la sesión
 *      -- Modificar sus propiedades con los campos del formulario
 *      -- Si el nombre del pintor favorito ha cambiado 
 *           -- Recuperar el objeto correspondiente al nuevo pintor
 *           -- Relacionar el usuario con el nuevo pintor
 *      -- Pedir al usuario que persista sus cambios
 *      -- Pedir al usuario un cuadro aleatorio
 *      -- Mostrar la vista "private" con la información personalizada del usuario
 *   - Petición de baja
 *      -- Recuperar el usuario que tiene la sesión abierta
 *      -- Pedir al usuario que se borre
 *      -- Cerrar la sesión
 *   - En otro caso
 *      -- Recuperar el usuario que tiene la sesión abierta
 *      -- Pediro al usuario un cuadro aleatorio
 *      -- Mostrar la vista "private" con la información personalizada del usuario
 * - Sino
 *   - Petición Inicial
 *     -- Mostrar la vista "formlogin" de petición de credenciales para iniciar una sesión con la aplicación.
 *   - Proceso Formulario Login
 *     -- Leer los valores del formulario (nombre de usuasio y contraseña)
 *     -- Si los credenciales son correctos 
 *           -- mostrar la vista "private" con información personaizada
 *        sino 
 *           -- mostrar la vista "formlogin" con un mensaje de error de validación
 *   - Petición de Registro
 *     -- Recuperar la lista de pintores
 *     -- Mostrar el formulario de registro de usuario
 *   - Proceso de formulario de registro
 *     -- Leer los datos del formulario de registro
 *     -- Construyo un usuario para persistir
 *     -- Pido al usuario que se persista
 *     -- Inicio una sesión en nombre del usuario
 *     -- Pido al usuario un cuadro aleatorio
 *     -- Mostrar la vista "private" con la información personalizada del usuario
 *   - En cualquier otro caso
 *     -- Mostrar la vista de login
 * 
 * 
 * 
 */

require "vendor/autoload.php";

use eftec\bladeone;
use Dotenv\Dotenv;
use App\BD;
use App\Auth;
use App\Usuario;
use App\Pintor;

define("ERROR_CON_BD", -1);
define("ERROR_AUT", -2);

$views = __DIR__ . '/vistas';
$cache = __DIR__ . '/cache';
define("BLADEONE_MODE", 1); // (optional) 1=forced (test),2=run fast (production), 0=automatic, default value.
$blade = new bladeone\BladeOne($views, $cache);

$dotenv = new Dotenv(__DIR__);
$dotenv->load();

$auth = Auth::getAuth();

$auth->init();

try {
    $bd = BD::getConexion();
} catch (Exception $e) {
    $error = ERROR_CON_BD;
    echo $blade->run("formlogin", compact('error', 'auth'));
    die;
}
// Si el usuario ya está validado
if ($auth->check()) {
    // Si es una petición de cierre de sesión
    if (isset($_REQUEST['botonpetlogout'])) {
        // destruyo la sesión
        $auth->logout();
        // Redirijo al cliente a la vista del formulario de login
        echo $blade->run("formlogin", compact('auth'));
        die;
    } else if (isset($_REQUEST['botonpetperfil'])) {
        $pintores = Pintor::recuperaPintores($bd);
        $usuario = $auth->loggedUsuario();
        // Muestro la vista de formulario de perfil

        echo $blade->run("perfil", compact('auth', 'usuario', 'pintores'));
        die;
    } else if (isset($_POST['botonpetprocperfil'])) {
        $usuario = $auth->loggedUsuario();
        $nombre = $_POST['nombre'];
        $clave = $_POST['clave'];
        $email = $_POST['email'];
        $pintor = $_POST['pintor'];

        $usuario->setNombre($nombre);
        $usuario->setClave($clave);
        $usuario->setEmail($email);
        $pintor = Pintor::recuperaPintorPorNombre($bd, $pintor);
        $usuario->setPintor($pintor);
        $usuario->persiste($bd);
        $cuadro = $usuario->getPintor()->getCuadroAleatorio();
        echo $blade->run("private", compact('auth', 'usuario', 'cuadro'));
        die;
    } else if (isset($_REQUEST['botonpetbaja'])) {
        $usuario = $auth->loggedUsuario();
        $usuario->elimina($bd);
        $auth->logout();
        echo $blade->run("formlogin", compact('auth'));
        die;
    }
    //En otro caso 
    else {
        // Redirijo al cliente a la vista de contenido
        $usuario = $auth->loggedUsuario();
        $cuadro = $usuario->getPintor()->getCuadroAleatorio();
        echo $blade->run("private", compact('auth', 'usuario', 'cuadro'));
        die;
    }

// Si se está solicitando el formulario de login
} else if ((empty($_REQUEST)) || isset($_REQUEST['botonpetlogin'])) {
    // Redirijo al cliente a la vista del formulario de login
    echo $blade->run("formlogin", compact('auth'));
    die;

    // Si se está enviando el formulario de login con los datos
} else if (isset($_REQUEST['botonpetproclogin'])) {
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $nombreOK = filter_var(trim($nombre), FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => "/^\w{3,25}$/"]]);
    $clave = filter_input(INPUT_POST, 'clave', FILTER_SANITIZE_STRING);
    $claveOK = filter_var(trim($clave), FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => "/^\w{3,25}$/"]]);

    if (!$nombreOK || !$claveOK) {
        echo $blade->run("formlogin", compact('auth', 'nombre', 'nombreOK', 'clave', 'claveOK'));
        die;
    }
    $usuario = Usuario::recuperaUsuarioPorCredencial($bd, $nombre, $clave);
    if ($usuario) {
        $auth->login($usuario);
        // Redirijo al cliente a la vista de contenido

        $cuadro = $usuario->getPintor()->getCuadroAleatorio();

        echo $blade->run("private", compact('auth', 'usuario', 'cuadro', 'error'));
        die;
    }

    // Si los credenciales son incorrectos
    else {
        // Establezco un mensaje de error para la 
        $error = true;
        // Redirijo al cliente a la vista del formulario de login
        echo $blade->run("formlogin", compact('auth', 'error'));
        die;
    }
// En cualquier otro caso
} else if (isset($_REQUEST['botonpetregistro'])) {
    $pintores = Pintor::recuperaPintores($bd);
    // Si los credenciales son correctos
    echo $blade->run("registro", compact('auth', 'pintores'));
    die;
} else if (isset($_POST['botonpetprocregistro'])) {
    // Si los credenciales son correctos
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $nombreOK = filter_var(trim($nombre), FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => "/^\w{3,25}$/"]]);
    $clave = filter_input(INPUT_POST, 'clave', FILTER_SANITIZE_STRING);
    $claveOK = filter_var(trim($clave), FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => "/^\w{3,25}$/"]]);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $emailOK = filter_var(trim($email), FILTER_VALIDATE_EMAIL);
    $pintorNombre = $_POST['pintor'];
    if (!$nombreOK || !$claveOK || !$emailOK) {
        $pintores = Pintor::recuperaPintores($bd);
        echo $blade->run("registro", compact('auth', 'nombre', 'nombreOK', 'clave', 'claveOK', 'email', 'emailOK', 'pintores'));
        die;
    }
    try {
        $usuario = new Usuario ($nombre, $clave, $email, $pintorNombre);
        $usuario->setPintor(Pintor::recuperaPintorPorNombre($bd, $pintorNombre));
        $usuario->persiste($bd);
    } catch (Exception $e) {
        switch ((int) ($e->getCode())) {
            case 23000:
                $registroMsg = "Nombre de usuario no está disponible. Inténtalo de nuevo";
                echo $blade->run("registro", compact('auth', 'pintores'));
                die();
            default:
                $registroMsg = "Problemas con el alta de usuario";
                echo $blade->run("registro", compact('auth', 'pintores'));
                die();
        }
    }
    $auth->login($usuario);
    $cuadro = $usuario->getPintor()->getCuadroAleatorio();
    echo $blade->run("private", compact('auth', 'usuario', 'cuadro'));
    die;
} else {
    // Redirijo al cliente a la vista del formulario de login
    $error['nombre'] = 1;
    echo $blade->run("formlogin", compact('auth'));
    die;
}
?>
 