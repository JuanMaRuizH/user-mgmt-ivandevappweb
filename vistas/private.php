<!DOCTYPE html>
<html>
    <head>
        <title>Formulario de lOGIN</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="stylesheet.css">
    </head>
    <body>
        <h1>Pagina de Cliente</h1>
        <form class="form-font" name="FormLogout" 
              action="index.php" method="POST">
            <input class="submit" type="submit" 
                   value="logout" name="botonenviologout" /> 
        </form>
        <h1>Hola <?= $nombre ?> </h1>


    </body>
</html>
