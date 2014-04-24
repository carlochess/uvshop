<?php

/**
* Clase encargada de el control de la página principal
*/	
class Home extends Controlador// implements Control
{
	private $home;
	private $categorias;
		public function __construct()
		{
			parent::__construct();
			$this->home = $this->loadModel("modelHome");
			// recibe las super-categorias
			$this->categorias = $this->home->getCategorias();
		}
		
		/**
		* Función encargada de desplegar la página
		* Principal de la aplicación
		*/
		function /*void*/ index($json=null)
		{
			// recibe 4 productos aleatorios
			$productosAleatorios = $this->home->getProdAleatorios();
			// recibe todas las promos del día
			$promos = $this->home->getOfertas();
			$categorias = $this->categorias;
			$masVendidos = $this->home->getMasVendidos();
			// Cierra la conexión a la base de datos
			$this->home->terminarConexion();
			if(count($json) == 1  && $json[0] == "true")
			{
				echo json_encode($productosAleatorios);
			}
			else
			{
				require('aplicacion/vista/Home/header.php');
				require('aplicacion/vista/Home/index.php');
				require('aplicacion/vista/Home/footer.php');
			}
		}
		/**
		* Función encargada de desplegar la información
		* sobre los desarrolladores
		*/
		function /*void*/ about()
		{
			$this->home->terminarConexion();
			$categorias = $this->categorias;
			require('aplicacion/vista/Home/header.php');
			require('aplicacion/vista/Home/about.php');
			require('aplicacion/vista/Home/footer.php');
		}
	}