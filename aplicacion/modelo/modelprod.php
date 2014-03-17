
<?php

class ModelProd
{
	/* Clase encargada de las consultas a la bd*/
	public $oMySQL;
	
	function __construct()
	{
		require 'aplicacion/libs/bd.php';
		$this->oMySQL = new MySQL();
	}
	/** Toda la info del producto */
	function getInforProd($id)
	{
		return $this->oMySQL->ejecutarConsultaSelect('SELECT codigo, nombre, descripcion, empresa_fab, iva, ruta, extension FROM producto INNER JOIN imagen ON producto.codigo = imagen.id_prod WHERE codigo="'.$id.'"');
	}
	
	/** Toda la info del producto */
	function getProductos()
	{
		return $this->oMySQL->ejecutarConsultaSelect('SELECT codigo, nombre, empresa_fab, descripcion, iva FROM producto');
	}
	
	/** Las filas afectadas en la consuta SQL */
	function getNumProd()
	{
		return $this->oMySQL->contarFilasAfectadas();
	}
	
	/**
	* Función que, dado un id, elimina un producto de la base de datos
	*/
	function eliminarProducto($id)
	{
		if(isset($id))
		{
			$sql = 'DELETE FROM producto WHERE codigo="'.$id.'"';
			$this->oMySQL->ejecutarConsultaI($sql);
		}
		header('Location: '.URL.'admin/producto');
	}
	
	/**
	* Función que agrega un producto a la base de datos
	*/
	function agregarProducto($codigo,$nombreP,$empresa_fab,$descripcion,$iva,$IMG)
	{
			$v = "/".$_FILES["file"]["name"] ;
			$path_parts = pathinfo($v);
			$IMG =  $path_parts['filename'];
			$sql = 'INSERT INTO producto(codigo, nombre, empresa_fab, descripcion, iva) VALUES ("'.$codigo.'","'.$nombreP.'","'.$empresa_fab.'","'.$descripcion.'",'.$iva.' )';
			$this->oMySQL->ejecutarConsultaI($sql);
			echo $sql.'<br/>';
			$sql = 'INSERT INTO imagen(id_prod, ruta, ancho, largo, extension) VALUES ("'.$codigo.'","'.$IMG.'",0,0,"'.$path_parts['extension'].'")';
			$this->oMySQL->ejecutarConsultaI($sql);
			echo $sql;
	}
	/**
	* Función que actualiza un producto de la base de datos
	*/
	function actualizarProducto($codigo,$nombreP,$empresa_fab,$descripcion,$iva, $IMG)
	{
			$sql = 'UPDATE producto SET nombre="'.$nombreP.'",empresa_fab="'.$empresa_fab.'",descripcion="'.$descripcion.'",iva='.$iva.' WHERE codigo="'.$codigo.'"';
			$this->oMySQL->ejecutarConsultaI($sql);
			if(isset($IMG))
			{
				$sql = 'UPDATE imagen SET ruta="'.$IMG.'" WHERE id_prod="'.$codigo.'"';
				$this->oMySQL->ejecutarConsultaI($sql);
			}
			echo $sql;
	}
	
	/**
	* Función que termina la conexión con la base de datos
	*/
	function terminarConexion()
	{
		$this->oMySQL->cerrarConexion();
	}
}
?>