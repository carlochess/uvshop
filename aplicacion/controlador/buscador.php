<?php

/**
* Clase encargada del manejo del buscador del sitio.
*/
class Buscador extends Controlador
{
	// Constructor clase buscador
	function __construct(){
	}
	
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
			$categoria = array();
			$modelprod = $this->loadModel("modelbuscador");
			$resBusqueda = $modelprod->buscarInfoProd($nombre[0]);
			$numResBusqueda = $modelprod->numResultados();
			require('aplicacion/vista/Buscador/header.php');
			require('aplicacion/vista/Buscador/index.php');
			require('aplicacion/vista/Buscador/footer.php');
		}
	}
	
	function /* void */ categoria($categoriaBusc)
	{
		if(isset($categoriaBusc) && count($categoriaBusc)==1)
		{
			$modelprod = $this->loadModel("modelbuscador");
			$resBusqueda = $modelprod->buscarInfoCategoria(str_replace('_',' ',$categoriaBusc[0]));
			$numResBusqueda = $modelprod->numResultados();
			$categoria = array();
			require('aplicacion/vista/Buscador/header.php');
			require('aplicacion/vista/Buscador/index.php');
			require('aplicacion/vista/Buscador/footer.php');
		}
		else{
			$this->index();
		}
	}
}
?>