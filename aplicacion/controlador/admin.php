<?php
	class Admin extends Controlador
	{
		public $categoria;
		public function __construct(){
			parent::__construct();
		}
		
		/** 
		* Función que despliega la página base del modulo de
		* administración.
		*/
		function /* void */ index()
		{
			$this->categoria = "informacion";
			require('aplicacion/vista/Admin/header.php');
			echo '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">Dashboard</h1>
			<div class="row placeholders"></div>
			<h2 class="sub-header">Estas en el index</h2>
			</div>';
			require('aplicacion/vista/Admin/footer.php');
		}
		
		/** 
		* Función que despliega la página de ventas
		*/
		function /* void */ ventas($id=null)
		{
			$this->categoria = "ventas";
			$modelFacturas = $this->loadModel("modelFactura");
			if(isset($id))
			{
				$productos = $modelFacturas->getFactura($id[0]);
				require('aplicacion/vista/Admin/header.php');
				require('aplicacion/vista/Admin/detallesVenta.php');
				require('aplicacion/vista/Admin/footer.php');
			}else{
				$facturas = $modelFacturas->getFacturas();
				require('aplicacion/vista/Admin/header.php');
				require('aplicacion/vista/Admin/ventas.php');
				require('aplicacion/vista/Admin/footer.php');
			}
			$modelFacturas->terminarConexion();
		}
		
		/** 
		* Función que despliega la página para la administración
		* de productos.
		*/
		function /* void */ producto()
		{
			$this->categoria = "productos";
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
			$this->categoria = "promociones";
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
			$this->categoria = "productos";
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
		
		/**
		* Función encargada de desplegar la página de configuración de reportes
		*/
		function /* void */ reportes()
		{
			$this->categoria = "reportes";
			require('aplicacion/vista/Admin/header.php');
			require('aplicacion/vista/Admin/reportes.php');
			require('aplicacion/vista/Admin/footer.php');
		}
		
		/**
		 TODO
		*/
		function /* void */ generarReporte($str=null)
		{
			require('aplicacion/libs/pdf/fpdf.php');
			$pdf = new FPDF();
			$pdf->SetTitle("Reporte");
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',16);
			//--
			$arreglo = array("top20mas", "topClientes", "top20menos","totalVentasProd","totalVentasFab","clientesCumpleanno","bajasExistencias","recaudoIva");
			$n = count($arreglo);
			for($i =0; $i < $n ; $i++)
			{
				if(isset($_POST[$arreglo[$i]]) && $_POST[$arreglo[$i]]=="on")
				{
					if(method_exists($this, $arreglo[$i])){
						$str = $this->$arreglo[$i]();
						$pdf->Cell(40,10,$str);
						$pdf->Ln();
					}
				}
			}
			$pdf->Output();
		}
		function top20mas()
		{
			return "Top 20: Mas Vendidos";
		}
		function topClientes()
		{
			return "Top Clientes";
		}
		function top20menos()
		{
			return "Top 20: Menos Vendidos";
		}
		function totalVentasProd()
		{
			return "Total Ventas Prod";
		}
		function totalVentasFab()
		{
			return "Total Ventas Fabricante";
		}
		function clientesCumpleanno()
		{
			return "Clientes Cumpleanno";
		}
		function bajasExistencias()
		{
			return "Bajas Existencias";
		}
		function recaudoIva()
		{
			return "Recaudo Iva";
		}
	}