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

// Expresión regular para comprobación de nombre
// Cadena entre tres y 25 caracteres
define("REGEXP_NOMBRE", "/^\w{3,25}$/");
// Expresión regular para comprobación de clave
// Cadena de 4 a 8 caracteres con al menos 1 digito
define("REGEXP_CLAVE", "/^(?=.*\d).{4,8}$/");
// Expresión regular para comprobación de Email
define("REGEXP_EMAIL", "/^.+@[^\.].*\.[a-z]{2,}$/");


$views = __DIR__ . '/vistas';
$cache = __DIR__ . '/cache';
define("BLADEONE_MODE", 1); // (optional) 1=forced (test),2=run fast (production), 0=automatic, default value.
$blade = new bladeone\BladeOne($views, $cache);

$dotenv = new Dotenv(__DIR__);
$dotenv->load();

// Elimina los delimitadores de la expresión regular para que se pueda aplicar a un elemento HTML

$REGEXP_NOMBRE = substr(REGEXP_NOMBRE, 1, strlen(REGEXP_NOMBRE) -2);
$REGEXP_CLAVE = substr(REGEXP_CLAVE, 1, strlen(REGEXP_CLAVE) -2);
$REGEXP_EMAIL = substr(REGEXP_EMAIL, 1, strlen(REGEXP_EMAIL) -2);

$patterns = ["REGEXP_NOMBRE", "REGEXP_CLAVE" ,"REGEXP_EMAIL"];

$auth = Auth::getAuth();

$auth->init();

try {
    $bd = BD::getConexion();
} catch (PDOException $error) {
    echo $blade->run("cnxbderror", compact('auth', 'error'));
    die;
}

// Si el usuario ya está validado
if ($auth->check()) {
    // Si es una petición de cierre de sesión
    if (isset($_REQUEST['botonpetlogout'])) {
        // destruyo la sesión
        $auth->logout();
        // Redirijo al cliente a la vista del formulario de login
        echo $blade->run("formlogin", compact($patterns, 'auth'));
        die;
    } elseif (isset($_REQUEST['botonpetperfil'])) {
        $pintores = Pintor::recuperaPintores($bd);
        // Muestro la vista de formulario de perfil

        echo $blade->run("perfil", compact($patterns, 'auth', 'pintores'));
        die;
    } elseif (isset($_POST['botonpetprocperfil'])) {
        $usuario = $auth->loggedUsuario();
        $nombre = filter_var(
            trim(filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING)),
            FILTER_VALIDATE_REGEXP,
            ['options' => ['regexp' => REGEXP_NOMBRE]]
        );
        $nombreAnterior = $usuario->getNombre();
        $clave = filter_var(
            trim(filter_input(INPUT_POST, 'clave', FILTER_SANITIZE_STRING)),
            FILTER_VALIDATE_REGEXP,
            ['options' => ['regexp' => REGEXP_CLAVE]]
        );
        $claveAnterior = $usuario->getClave();
        $email = filter_var(
            trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING)),
            FILTER_VALIDATE_REGEXP,
            ['options' => ['regexp' => REGEXP_EMAIL]]
        );
        $emailAnterior = $usuario->getEmail();
        $pintor = $_POST['pintor'];
        $pintorAnterior = $usuario->getPintor();
        if (!$nombre || !$clave || !$email) {
            $pintores = Pintor::recuperaPintores($bd);
            echo $blade->run("perfil", compact($patterns, 'auth', 'nombre', 'clave', 'email', 'pintores'));
            die;
        }
        

        $usuario->setNombre($nombre);
        $usuario->setClave($clave);
        $usuario->setEmail($email);
        $pintor = Pintor::recuperaPintorPorNombre($bd, $pintor);
        $usuario->setPintor($pintor);
        try {
            $usuario->persiste($bd);
        } catch (PDOException $e) {
            $usuario->setNombre($nombreAnterior);
            $usuario->setClave($claveAnterior);
            $usuario->setEmail($emailAnterior);
            $usuario->setPintor($pintorAnterior);
            $error = true;
            $pintores = Pintor::recuperaPintores($bd);
            echo $blade->run("perfil", compact($patterns, 'auth', 'pintores', 'error'));
            die();
        }
        $cuadro = $usuario->getPintor()->getCuadroAleatorio();
        echo $blade->run("private", compact('auth', 'cuadro'));
        die;
    } elseif (isset($_REQUEST['botonpetbaja'])) {
        $usuario = $auth->loggedUsuario();
        $usuario->elimina($bd);
        $auth->logout();
        echo $blade->run("formlogin", compact($patterns, 'auth'));
        die;
    }
    //En otro caso
    else {
        // Redirijo al cliente a la vista de contenido
        $usuario = $auth->loggedUsuario();
        $cuadro = $usuario->getPintor()->getCuadroAleatorio();
        echo $blade->run("private", compact('auth', 'cuadro'));
        die;
    }

    // Si se está solicitando el formulario de login
} elseif ((empty($_REQUEST)) || isset($_REQUEST['botonpetlogin'])) {
    // Redirijo al cliente a la vista del formulario de login
    echo $blade->run("formlogin", compact($patterns, 'auth'));
    die;

// Si se está enviando el formulario de login con los datos
} elseif (isset($_REQUEST['botonpetproclogin'])) {
    $nombre = filter_var(
        trim(filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING)),
        FILTER_VALIDATE_REGEXP,
        ['options' => ['regexp' => REGEXP_NOMBRE]]
    );
    $clave = filter_var(
        trim(filter_input(INPUT_POST, 'clave', FILTER_SANITIZE_STRING)),
        FILTER_VALIDATE_REGEXP,
        ['options' => ['regexp' => REGEXP_CLAVE]]
    );

    if (!$nombre || !$clave) {
        echo $blade->run("formlogin", compact($patterns, 'auth', 'nombre', 'clave'));
        die;
    }
    $usuario = Usuario::recuperaUsuarioPorCredencial($bd, $nombre, $clave);
    if ($usuario) {
        $auth->login($usuario);
        // Redirijo al cliente a la vista de contenido

        $cuadro = $usuario->getPintor()->getCuadroAleatorio();

        echo $blade->run("private", compact('auth', 'cuadro', 'error'));
        die;
    }

    // Si los credenciales son incorrectos
    else {
        // Establezco un mensaje de error para la
        $error = true;
        // Redirijo al cliente a la vista del formulario de login
        echo $blade->run("formlogin", compact($patterns, 'auth', 'error'));
        die;
    }
    // En cualquier otro caso
} elseif (isset($_REQUEST['botonpetregistro'])) {
    $pintores = Pintor::recuperaPintores($bd);
    // Si los credenciales son correctos
    echo $blade->run("registro", compact($patterns, 'auth', 'pintores'));
    die;
} elseif (isset($_POST['botonpetprocregistro'])) {
    $nombre = filter_var(
        trim(filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING)),
        FILTER_VALIDATE_REGEXP,
        ['options' => ['regexp' => REGEXP_NOMBRE]]
    );
    $clave = filter_var(
        trim(filter_input(INPUT_POST, 'clave', FILTER_SANITIZE_STRING)),
        FILTER_VALIDATE_REGEXP,
        ['options' => ['regexp' => REGEXP_CLAVE]]
    );
    $email = filter_var(
        trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING)),
        FILTER_VALIDATE_REGEXP,
        ['options' => ['regexp' => REGEXP_EMAIL]]
    );
    $pintorNombre = $_POST['pintor'];
    if (!$nombre || !$clave || !$email) {
        echo $blade->run("registro", compact($patterns, 'auth', 'nombre', 'clave', 'email'));
        die;
    } 
    
    $usuario = new Usuario($nombre, $clave, $email);
    $usuario->setPintor(Pintor::recuperaPintorPorNombre($bd, $pintorNombre));
        try {        
            $usuario->persiste($bd);        
        } catch (PDOException $e) {
            $error = true;
            echo $blade->run("registro", compact($patterns, 'auth', 'error'));
            die();
        }
        $auth->login($usuario);
        // Redirijo al cliente a la vista de contenido
    $cuadro = $usuario->getPintor()->getCuadroAleatorio();
    echo $blade->run("private", compact('auth', 'cuadro'));
    die;
} else {
    // Redirijo al cliente a la vista del formulario de login
    echo $blade->run("formlogin", compact($patterns, 'auth'));
    die;
}
?>
 