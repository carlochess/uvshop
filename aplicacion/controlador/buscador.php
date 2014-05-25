<?php

/**
* Clase encargada del manejo del buscador del sitio.
*/
class Buscador extends Controlador
{
	// Constructor clase buscador
	function __construct(){
		parent::__construct();
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
			$i = rand(0,10);
			if($i <6)
			{
				include("Levenshtein.php");
				echo "Levenshtein";
				$var = new Levenshtein();
			}
			else
			{
				include("Ingenua.php");
				$var = new Ingenua();
			}
			$categoria = array();
			$resBusqueda = $var->buscar($nombre);
			$numResBusqueda = count($resBusqueda);
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