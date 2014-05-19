<?php
date_default_timezone_set('America/Bogota');
// Carga la configuración
//require 'aplicacion/cfg/config.php';

// Carga el controlador de la aplicación (CGI)
//require 'aplicacion/libs/uvshop.php';

//require 'aplicacion/libs/login.php';

// Carga el controlador 
//require 'aplicacion/libs/controlador.php';
/*
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
}*/

// configurar autoloading
require_once 'aplicacion/libs/vendor/autoload.php';

// configurar Propel
require_once 'aplicacion/libs/generated-conf/config.php';

$producto = new Producto();
$producto->setIdProd('Field');
$producto->setNombre('Cristian'); 
$producto->setEmpresaFab('Hola');
$producto->setDescripcion('Ninguna');
$producto->setIva(20);
$producto->setCategoria('Idiotas');
$producto->setUnidades(1);
$producto->save();

// iniciar la tienda virtual
//$app = new Uvshop();
?>
