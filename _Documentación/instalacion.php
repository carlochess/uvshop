<!DOCTYPE html>
<?php
function tienePhp53()
{
    return strnatcmp(phpversion(),'5.0.0') >= 0;
}

function tieneMods()
{// mod_rewrite, php_json, php_curl
    return in_array('mod_rewrite', apache_get_modules());
}

if (isset($_POST['loginBD']) && isset($_POST['passBD']) && isset($_POST['hostBD']) && isset($_POST['rutaAbs']) && isset($_POST['dirServer'])) {
    $dbhost = 'localhost:3036';
    $dbuser = $_POST['loginBD'];
    $dbpass =  $_POST['passBD'];
    $conn = mysql_connect($dbhost, $dbuser, $dbpass);
    if(! $conn )
    {
      die('Imposible conectar a mysql: ' . mysql_error());
    }
    echo 'Conectado <br/>';
    $sql = 'CREATE Database uvshop';
    $retval = mysql_query( $sql, $conn );
    if(! $retval )
    {
      echo 'No se pudo crear la base de datos: ' . mysql_error();
    }
 else {
        echo "Base de datos uvshop creada <br>";
    }
    echo "<br/>";
    mysql_close($conn);
    
    $contenido = 
   "<?php \n
    define('DIR_APP', '%s');\n
    define('URL', '%s');\n
    define ('LIBRERIAS', \$_SERVER['DOCUMENT_ROOT'].'/uvshop/aplicacion/libs/');\n
    // Base de datos\n
    define('DB_USER', '%s');\n
    define('DB_PASS', '%s');\n
    define('DB_NAME', 'uvshop');\n
    define('DB_HOST', '%s');\n
    define('DB_TYPE', 'mysql');\n
    ?>\n";
    echo "Creando archivo de configuracion  <br/>";
    $archivo = '../aplicacion/cfg/config.php';
    if(file_exists($archivo))
    {
        echo "El archivo existe";
    }
    else
    {
        $cadena = sprintf($contenido, $_POST['rutaAbs'], $_POST['dirServer'], $_POST['loginBD'], $_POST['passBD'], $_POST['hostBD']);
        file_put_contents($archivo,$cadena);
        echo "Creado";
    }
    echo "<br/>";
    
    $db = new PDO('mysql:host='.$_POST['hostBD'].';dbname=uvshop', $_POST['loginBD'], $_POST['passBD']);
    $sql = file_get_contents('uvshop.sql');
    $qr = $db->exec($sql);

    

    echo "Si quieres poblar la base de datos, debes ir a ";
    echo '<a href="json/index.php"> esta web </a>';
    echo "<br/>";
    echo '<a href="./index.php"> Volver </a>';
    echo "<br/>";
} else {
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <title></title>
        </head>
        <body>
            <?php 
            echo "<li>";
            if (tienePhp53())
                echo "Tienes php 5";
            else
                echo "No tienes php 5";
            echo "</li><li>";
            if (tieneMods())
                echo "Tiene mod_rewrite habilitado";
            else
                echo "Debes habilitar mod_rewrite en tu computador";
            echo "</li>"
            ?>
                  
            <form method="post" action="instalacion.php">
                <p>
                    Login a la base de datos
                </p>
                <input type="text" name="loginBD"/>
                <p>
                    Contraseña de la base de datos
                </p>
                <input type="text" name="passBD"/>
                <p>
                    Host base de datos (localhost por ejemplo)
                </p>
                <input type="text" name="hostBD"/>
                <p>
                    Ruta absoluta (Donde se alojara uvshop, ejemplo: /var/www)
                </p>
                <input type="text" name="rutaAbs"/>
                <p>
                    Dirección servidor (ejemplo http://127.0.0.1/)
                </p>
                <input type="text" name="dirServer"/>
                <p>
                    <input type="submit" name="Instalar"/>
                </p>
            </form>
        </body>
    </html>
<?php } ?>
