<?php
class Producto extends Controlador
{
	// Constructor clase producto
	function __construct(){}
	
	// 
	function index()
	{
		require('aplicacion/vista/Producto/header.php');
		require('aplicacion/vista/Producto/notFound.php');
		require('aplicacion/vista/Producto/footer.php');
	}
	
	// Función que se encarga de controlar 
	// y desplegar la información concerniente
	// al producto según su $id
	function info($id=null)
	{
		if(isset($id))
		{
			$modelprod = $this->loadModel("modelProd");
			$info = $modelprod->getInforProd($id[0]);
			if($modelprod->getNumProd()==1)
			{
				$prod = $info[0];
				$ind = $this->loadModel("modelHome");
				// recibe 4 productos aleatorios
				$productosAleatorios = $ind->getProdAleatorios();
				require('aplicacion/vista/Producto/header.php');
				require('aplicacion/vista/Producto/producto.php');
				require('aplicacion/vista/Producto/footer.php');
			}
			else
			{
				$this->index();
			}
		}
		else
		{
			//echo "No seteado";
			$this->index();
		}
	}
	/*
	 * Función encargada de eliminar un producto de la base de datos
	 * @param string $prod Id del producto a eliminar
	 */
	function eliminarprod($prod)
	{
		$modelprod = $this->loadModel("modelProd");
		$modelprod->eliminarProducto($prod[0]);
		$modelprod->terminarConexion();
	}
	
	/**
	* Función encargada de agregar un producto a la base de datos
	*/
	function agregarProd()
	{
		require_once('imagen.php');
		$controladorImg = new Imagen();
		if($controladorImg->guardarImagen())
		{
			require('validador.php');
			$valid = new validador();
			$codigo = $valid->test_input($_POST["idProd"]);
			$nombreP = $valid->test_input($_POST["nProd"]);
			$empresa_fab = $valid->test_input($_POST["empProd"]);
			$descripcion = $valid->test_input($_POST["descProd"]);
			$iva = $valid->test_input($_POST["ivaProd"]);
			
			$modelprod = $this->loadModel("modelProd");
			$modelprod->agregarProducto($codigo,$nombreP,$empresa_fab,$descripcion,$iva,$controladorImg->getNombreImg());
			$modelprod->terminarConexion();
			header('Location: '.URL.'/admin/productos');
		}
	}
	/** 
	* Función encargada de actualizar un producto 
	* TODO : actualizar imagen
	*/
	function actualizarProd()
	{
		require('validador.php');
		require_once('imagen.php');
		$valid = new validador();
		$controladorImg = new Imagen();
		$codigo = $valid->test_input($_POST["idProd"]);
		$nombreP = $valid->test_input($_POST["nProd"]);
		$empresa_fab = $valid->test_input($_POST["empProd"]);
		$descripcion = $valid->test_input($_POST["descProd"]);
		$iva = $valid->test_input($_POST["ivaProd"]);
		
		$modelprod = $this->loadModel("modelProd");
		$imagen = ($controladorImg->guardarImagen())? $controladorImg->getNombreImg() : null;
		$modelprod->actualizarProducto($codigo,$nombreP,$empresa_fab,$descripcion,$iva,$imagen);
		$modelprod->terminarConexion();
		header('Location: '.URL.'/admin/producto');
	}
	
	
}
?>