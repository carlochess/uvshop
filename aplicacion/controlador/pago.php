<?php
/**
* Clase encargada de las transacciones y la adquisción de productos
*/
class Pago extends Controlador
{
	// Constructor clase Pago
	function __construct(){}
	
	/*
	* Función encargada de desplegar la información concerniente
	* a lo que lleva el carrito.
	*/
	function /* void */ index()
	{
		if(isset($_COOKIE['carritoCod']) && !empty($_COOKIE['carritoCod']))
		{
			$modelprod = $this->loadModel("modelProd");
			$str = str_replace("\"", "", $_COOKIE['carritoCod']);
			$articulos = explode(' ', $str);
			$cantidadInit = $modelprod->cantidadInicial($articulos);
			$detallesProductos = $modelprod->infoProductos($articulos);
			require('aplicacion/vista/Pagos/header.php');
			require('aplicacion/vista/Pagos/pago.php');
			require('aplicacion/vista/Pagos/footer.php');
			$modelprod->terminarConexion();
		}
		else
		{
			header('Location: '.URL);
		}
	}
	/**
	* Nota: 'modos' Se refiere a "modos de pago"
	* Habiendo seleccionado los items a comprar, es hora de 
	* especificar los medios de pago, las cuotas y los montos
	* 
	*/
	function /* void */ modos()
	{
		if(isset($_POST) && count($_POST)>0)
		{
			$modelprod = $this->loadModel("modelProd");
			$ids = array(); $cantidades = array();
			for($i=0;$i<count($_POST)-1; $i+=2)
			{
				$ids[] = $_POST[$i];
				$cantidades[] = $_POST[$i+1];
			}
			$detallesProductos = $modelprod->infoProductos($ids);
			$total = 0;$i=0;
			
			foreach ($detallesProductos as $detalleProducto)
			{
				$total += floatval($detalleProducto->precio)*intval($cantidades[$i]);++$i;
			}
			
			require('aplicacion/vista/Pagos/header.php');
			require('aplicacion/vista/Pagos/modo.php');
			require('aplicacion/vista/Pagos/footer.php');
		}
		else{
			header('Location: '.URL);
		}
	}
	
}
?>