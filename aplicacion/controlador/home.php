<?php
	class Home extends Controlador
	{
		var $estaConectado;
		public function __construct()
		{
			//parent::__construct();
			$this->estaConectado = true;
		}
		
		// manejador home
		function index()
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
		
		function about()
		{
			require('aplicacion/vista/Home/header.php');
			require('aplicacion/vista/Home/about.php');
			require('aplicacion/vista/Home/footer.php');
		}
	}
?>