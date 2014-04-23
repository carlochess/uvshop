<?php
date_default_timezone_set('America/Bogota');
// Carga la configuración
require 'aplicacion/cfg/config.php';

// Carga el controlador de la aplicación (CGI)
require 'aplicacion/libs/uvshop.php';

require 'aplicacion/libs/login.php';

// Carga el controlador 
require 'aplicacion/libs/controlador.php';

// iniciar la tienda virtual
$app = new Uvshop();
?>