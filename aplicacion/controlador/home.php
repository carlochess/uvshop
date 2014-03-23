<?php

/**
* Clase encargada de el control de la página principal
*/	
class Home extends Controlador
{
		/** AUN NO IMPLEMENTADA **/
		var $estaConectado;
		public function __construct()
		{
			//parent::__construct();
			$this->estaConectado = true;
		}
		
		/**
		* Función encargada de desplegar la página
		* Principal de la aplicación
		*/
		function /*void*/ index()
		{
			$home = $this->loadModel("modelHome");
			// recibe 4 productos aleatorios
			$productosAleatorios = $home->getProdAleatorios();
			// recibe todas las promos del día
			$promos = $home->getOfertas();
			// recibe las super-categorias
			$categorias = $home->getCategorias();
			// Cierra la conexión a la base de datos
			$home->terminarConexion();
			
			require('aplicacion/vista/Home/header.php');
			require('aplicacion/vista/Home/index.php');
			require('aplicacion/vista/Home/footer.php');
		}
		/**
		* Función encargada de desplegar la información
		* sobre los desarrolladores
		*/
		function /*void*/ about()
		{
			require('aplicacion/vista/Home/header.php');
			require('aplicacion/vista/Home/about.php');
			require('aplicacion/vista/Home/footer.php');
		}
	}
?>