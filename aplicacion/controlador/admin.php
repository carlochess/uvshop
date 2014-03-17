<?php
	class Admin extends Controlador
	{
		public function __construct(){
			$login = new Login();
			//if(!$login->estaConectado())
			//	header('Location: index.php');
		}
		
		// manejador home
		function index()
		{
			require('aplicacion/vista/Admin/header.php');
			echo '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">Dashboard</h1>
			<div class="row placeholders"></div>
			<h2 class="sub-header">Estas en el index</h2>
			</div>';
			require('aplicacion/vista/Admin/footer.php');
		}
		
		function producto()
		{
			$modelprod = $this->loadModel("modelProd");
			$productos = $modelprod->getProductos();
			$modelprod->terminarConexion();
			require('aplicacion/vista/Admin/header.php');
			require('aplicacion/vista/Admin/producto.php');
			require('aplicacion/vista/Admin/footer.php');
		}
		
		function promociones()
		{
			$modelpromo = $this->loadModel("modelPromo");
			$promociones = $modelpromo->getPromociones();
			$modelpromo->terminarConexion();
			require('aplicacion/vista/Admin/header.php');
			require('aplicacion/vista/Admin/promo.php');
			require('aplicacion/vista/Admin/footer.php');
		}
		
		function agregarpromo()
		{
			$id_item = $_POST['idItem'];
			$f_inic = $_POST['f_inicio'];
			$f_fin = $_POST['f_finalizacion'];
			$desc = $_POST['descuento'];
			$modelpromo = $this->loadModel("modelPromo");
			$modelpromo->agregarPromocion($id_item, $f_inic,$f_fin,$desc);
			$modelpromo->terminarConexion();
			header('Location: '.URL.'admin/promociones');
		}
		
		function editarpromo()
		{
			$id_item = $_POST['idItem'];
			$f_inic = $_POST['f_inicio'];
			$f_fin = $_POST['f_finalizacion'];
			$desc = $_POST['descuento'];
			$modelpromo = $this->loadModel("modelPromo");
			$modelpromo->actualizarPromocion($id_item, $f_inic,$f_fin,$desc);
			$modelpromo->terminarConexion();
			header('Location: '.URL.'admin/promociones');
		}
		
		function eliminarpromo($id)
		{
			$modelpromo = $this->loadModel("modelPromo");
			$modelpromo->eliminarPromocion($id[0]);
			$modelpromo->terminarConexion();
			header('Location: '.URL.'admin/promociones');
		}
	}
?>