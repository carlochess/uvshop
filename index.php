<?php
date_default_timezone_set('America/Bogota');
 error_reporting(E_ALL);
 ini_set('display_errors', 1);
// Carga la configuración
require 'aplicacion/cfg/config.php';

// Carga el controlador de la aplicación (CGI)
require 'aplicacion/libs/uvshop.php';


// Carga el controlador de la aplicación (CGI)
require 'aplicacion/libs/vendor/autoload.php';

// Carga el controlador 
require 'aplicacion/libs/controlador.php';

// configurar autoloading
require 'aplicacion/libs/orm/vendor/autoload.php';

// configurar Propel
require 'aplicacion/libs/orm/generated-conf/config.php';

require  'aplicacion/libs/easyphpthumbnail.class.php';

// iniciar la tienda virtual
$app = new Uvshop();
?>
