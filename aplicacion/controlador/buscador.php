<?php

/**
* Clase encargada del manejo del buscador del sitio.
*/
class Buscador extends Controlador
{
	// Constructor clase buscador
	function __construct(){}
	
	/* 
	*  Si no hay información para buscar, vuelve a la home
	*/
	function /* void */ index()
	{
		header('Location: '.URL);
	}
	
	// Función que se encarga de controlar 
	// y desplegar la información de la busqueda
	function /* void */ buscar()
	{
		$nombre=$_POST['nombre'];
		if(isset($nombre))
		{
			$modelprod = $this->loadModel("modelbuscador");
			$resBusqueda = $modelprod->buscarInfoProd($nombre[0]);
			require('aplicacion/vista/Buscador/header.php');
			require('aplicacion/vista/Buscador/index.php');
			require('aplicacion/vista/Buscador/footer.php');
		}
	}
}
?>