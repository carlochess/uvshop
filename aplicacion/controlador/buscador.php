<?php
class Buscador extends Controlador
{
	// Constructor clase producto
	function __construct(){}
	
	// 
	function index()
	{
		echo "10 Jabon 40000<br/>";
		echo "20 Shampoo 40000<br/>";
		echo "30 Pañal 40000<br/>";
		echo "40 Acondicionador 40000<br/>";
	}
	
	// Función que se encarga de controlar 
	// y desplegar la información de la busqueda
	function buscar()
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