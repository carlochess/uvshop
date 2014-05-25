<!DOCTYPE html>
<?php
if (isset($_POST['loginBD']) && isset($_POST['passBD']) && isset($_POST['hostBD']) && isset($_POST['rutaAbs']) && isset($_POST['dirServer'])) {
    $contenido = "define('DIR_APP', '%s');\n
    define('URL', '%s');\n
    define ('LIBRERIAS', '\$_SERVER['DOCUMENT_ROOT'].'/uvshop/aplicacion/libs/'');\n
    // Base de datos\n
    define('DB_USER', '%s');\n
    define('DB_PASS', '%s');\n
    define('DB_NAME', 'uvshop');\n
    define('DB_HOST', '%s');\n
    define('DB_TYPE', 'mysql');";
    $archivo = 'aplicacion/cfg/config.php';
    $cadena = sprintf($contenido, $_POST['rutaAbs'], $_POST['dirServer'], $_POST['loginBD'], $_POST['passBD'], $_POST['hostBD']);
    file_put_contents($archivo,$cadena);
    echo $cadena.'<br/>';
    $command="mysql -h {$_POST['hostBD']} -u '{$_POST['loginBD']}' -p'{$_POST['passBD']}' 
    uvshop < _Documentación/uvshop.sql";
    $salida = shell_exec($command);
    echo $command;
} else {
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <title></title>
        </head>
        <body>
            <form method="post" action="instalacion.php">
                <p>
                    Login base de datos
                </p>
                <input type="text" name="loginBD"/>
                <p>
                    Contraseña base de datos
                </p>
                <input type="text" name="passBD"/>
                <p>
                    Host base de datos
                </p>
                <input type="text" name="hostBD"/>
                <!-- -->
                <p>
                    Ruta absoluta (ejemplo: /var/www)
                </p>
                <input type="text" name="rutaAbs"/>
                <p>
                    Dirección servidor (http://127.0.0.1)
                </p>
                <input type="text" name="dirServer"/>
                <p>
                    <input type="submit" name="Instalar"/>
                </p>
            </form>
        </body>
    </html>
<?php } ?>
