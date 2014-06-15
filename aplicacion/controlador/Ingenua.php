<?php
//Ingenua 
	require("AlgoritmoBusqueda.php");
	class Ingenua extends Controlador implements AlgoritmoBusqueda
	{
		// Constructor clase Ingenua
		function __construct(){
			parent::__construct();
		}
		
		public function buscar($nombre)
		{
			$modelprod = $this->loadModel("modelbuscador");
			$resBusqueda = $modelprod->buscarInfoProd($nombre);
			return $resBusqueda;
		}
		
		
	}
?>