<?php
//Levenshtein 
	require("AlgoritmoBusqueda.php");
	class Levenshtein extends Controlador implements AlgoritmoBusqueda
	{
		// Constructor clase Liechtenstein
		function __construct(){
			parent::__construct();
		}
		
		public function buscar($nombre)
		{
			$modelprod = $this->loadModel("modelbuscador");
			$productos = $modelprod->getProductos();
			$resBusqueda = array();
			foreach($productos as $prod)
			{
				if(levenshtein ( $prod->nombre,$nombre ) < 4)
				{
					$resBusqueda[] =  $prod;
				}
			}
			
			return $resBusqueda;
		}
	}
?>