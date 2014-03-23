<?php
	class Admin extends Controlador
	{
		public function __construct(){
			//$login = new Login();
			//if(!$login->estaConectado())
			//	header('Location: index.php');
		}
		
		/** 
		* Función que despliega la página base del modulo de
		* administración.
		*/
		function /* void */ index()
		{
			require('aplicacion/vista/Admin/header.php');
			echo '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">Dashboard</h1>
			<div class="row placeholders"></div>
			<h2 class="sub-header">Estas en el index</h2>
			</div>';
			require('aplicacion/vista/Admin/footer.php');
		}
		
		/** 
		* Función que despliega la página para la administración
		* de productos.
		*/
		function /* void */ producto()
		{
			$modelprod = $this->loadModel("modelProd");
			$productos = $modelprod->getProductos();
			$modelprod->terminarConexion();
			require('aplicacion/vista/Admin/header.php');
			require('aplicacion/vista/Admin/producto.php');
			require('aplicacion/vista/Admin/footer.php');
		}
		
		/** 
		* Función que despliega la página para la administración
		* de promociones de los productos.
		*/
		function /* void */ promociones()
		{
			$modelpromo = $this->loadModel("modelPromo");
			$promociones = $modelpromo->getPromociones();
			$modelpromo->terminarConexion();
			require('aplicacion/vista/Admin/header.php');
			require('aplicacion/vista/Admin/promo.php');
			require('aplicacion/vista/Admin/footer.php');
		}
		
		/** 
		* Función que despliega la página para la administración
		* de precios de los productos.
		* @param array() $id el producto que será afectado
		*/
		function /* void */ precio($id=null)
		{
			if(isset($id))
			{
				$id = $id[0];
				$modelprecio = $this->loadModel("modelPrecio");
				$precios = $modelprecio->getPrecios($id);
				$modelprecio->terminarConexion();
				require('aplicacion/vista/Admin/header.php');
				require('aplicacion/vista/Admin/precioId.php');
				require('aplicacion/vista/Admin/footer.php');
			}else
			{
				$modelprod = $this->loadModel("modelPrecio");
				$productos = $modelprod->getPrecios();
				$modelprod->terminarConexion();
				require('aplicacion/vista/Admin/header.php');
				require('aplicacion/vista/Admin/precio.php');
				require('aplicacion/vista/Admin/footer.php');
			}
		}
		/**
		* Función encargada de agregar una promoción 
		*/
		function /* void */ agregarpromo()
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
		
		/**
		* Función encargada de editar una promoción 
		*/
		function /* void */ editarpromo()
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
		
		/**
		* Función encargada de eliminar una promoción 
		*/
		function /* void */ eliminarpromo($id)
		{
			$modelpromo = $this->loadModel("modelPromo");
			$modelpromo->eliminarPromocion($id[0]);
			$modelpromo->terminarConexion();
			header('Location: '.URL.'admin/promociones');
		}
		//---
		/**
		* Función que agrega un precio a la tabla.
		*/
		function /* void */ agregarprecio($id)
		{
			$f_inic = $_POST['f_inicio'];
			$f_fin = $_POST['f_finalizacion'];
			$precio = $_POST['precio'];
			$modelprecio = $this->loadModel("modelPrecio");
			$modelprecio->agregarPrecio($id[0], $f_inic,$f_fin,$precio);
			$modelprecio->terminarConexion();
			header('Location: '.URL.'admin/precio/'.$id[0]);
		}
		/**
		* 	Función que edita los datos del precio de un producto
		*/
		function /* void */ editarprecio($id)
		{
			$id_precio = $_POST['id_precio'];
			$f_inic = $_POST['f_inicio'];
			$f_fin = $_POST['f_finalizacion'];
			$precio = $_POST['precio'];
			$modelprecio = $this->loadModel("modelPrecio");
			$modelprecio->actualizarPrecio($id_precio, $f_inic,$f_fin,$precio);
			$modelprecio->terminarConexion();
			header('Location: '.URL.'admin/precio/'.$id[0]);
		}
		/**
		* Función que elimina el precio según identificación del mismo y el item al cual pertenece
		*/
		function /* void */ eliminarprecio($id)
		{
			$modelprecio = $this->loadModel("modelPrecio");
			$modelprecio->eliminarPrecio($id[0]);
			$modelprecio->terminarConexion();
			header('Location: '.URL.'admin/precio/'.$id[1]);
		}
	}
?>