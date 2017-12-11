# user_mgmt
*Escribe un programa PHP que valide a los usuarios para acceder a su página personal. 
Realiza la aplicación siguiendo el patrón MVC.
Cuando alguien visita el sitio web se le presentará un formulario invitándole a introducir un
nombre de usuario y un password. Las credenciales se comprobarán internamente con la
información almacenada en un array de credenciales (parejas de usuario y password).
Si el usuario y password es correcto se direccionará al usuario a una página de contenido
que contiene un mensaje personalizado con su nombre. Además se presentará
un botón para finalizar la sesión. Una vez finalizada la sesión se dirigirá al usuario a la ventana
de login para que vuelva a validarse si quiere ver su página personal.
Si los datos no son correctos se volverá a presentar el formulario de inicio de sesión
solicitando el nombre de usuario y contraseña.
Si el usuario pretende entrar directamente a la página de contenido sin pasar previamente
por la ventana de login se le mostrará el formulario de login para que se valide.*

Rama: "user_mgmt"

Orientaciones:

1. Estructuras de control variadas

2. Patrón Modelo Vista Controlador

3. Utilización de sesiones PHP.

*Realiza una nueva versión del programa en la que los usuarios y sus contraseñas se
encuentran en una base de datos MySQL. Utiliza la clase PDO.
Los usuarios podrán registrarse automáticamante rellenando un formulario de registro con los 
campos de usuario, contraseña, correo electrónico y un desplegable con nombre de pintores 
para que el usuario escoja su pintor favorito. Una vez enviados esos datos al servidor se creará un nuevo registro
en la base de datos con los credenciales aportados por el usuario y se presentará al
usuario la ventana de login para que pueda iniciar sesión con los mismos.
La aplicación validará al usuario y en caso de éxito le dará acceso a una página personal que contiene
un mensaje personalizado con su nombre y un cuadro de su pintor favorito.
Además la aplicación permitirá al usuario la modificación de sus datos de perfil (nombre de usuario, contraseña, correo electrónico y pintor
favorito). También podrá darse de baja de la aplicación.*

Rama: "user_mgmt_oo_db"

Orientaciones:

1. Estructuras de control variadas

2. Patrón Modelo Vista Controlador

3. Utilización de sesiones PHP.

4. Uso de construcciones Orientadas a Objetos

5. Uso de librería de acceso a BBDD PDO
