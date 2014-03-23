<?php
class Pago extends Controlador
{
	// Constructor clase producto
	function __construct(){}
	/*
	
	*/
	// 
	function index()
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
			echo "Nada por aquí, nada por allá";
		}
	}
	
	function modos()
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