<?php
date_default_timezone_set('America/Bogota');
// Carga la configuración
require 'aplicacion/cfg/config.php';

// Carga el controlador de la aplicación (CGI)
require 'aplicacion/libs/uvshop.php';

//require 'aplicacion/libs/login.php';

// Carga el controlador 
require 'aplicacion/libs/controlador.php';

// configurar autoloading
require 'aplicacion/libs/vendor/autoload.php';

// configurar Propel
require 'aplicacion/libs/generated-conf/config.php';
/*
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
}*/

// iniciar la tienda virtual
$app = new Uvshop();
?>
