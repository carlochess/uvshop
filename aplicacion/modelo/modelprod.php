
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
		return $this->oMySQL->ejecutarConsultaSelect('SELECT producto.id_prod AS id_prod, precio.valor AS precio, nombre, descripcion, empresa_fab, iva, ruta, extension 
		FROM producto,imagen,precio 
		WHERE 
		producto.id_prod = imagen.id_prod AND
		producto.id_prod = precio.cod_producto AND
		now() between precio.fecha_ini and precio.fecha_fin AND
		producto.id_prod="'.$id.'"');
	}
	
	/** Toda la info del producto */
	function getProductos()
	{/*return $this->oMySQL->ejecutarConsultaSelect('SELECT producto.id_prod, nombre, empresa_fab, descripcion, iva,precio.valor AS precio
		FROM producto,precio WHERE now() between precio.fecha_ini and precio.fecha_fin AND	producto.id_prod = precio.cod_producto');*/
		return $this->oMySQL->ejecutarConsultaSelect('SELECT producto.id_prod, nombre, empresa_fab, descripcion, iva, unidades, id_categoria
		FROM producto');
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
			$sql = 'DELETE FROM producto WHERE id_prod="'.$id.'"';
			$this->oMySQL->ejecutarConsultaI($sql);
		}
		header('Location: '.URL.'admin/producto');
	}
	
	/**
	* Función que agrega un producto a la base de datos
	*/
	function agregarProducto($id_prod,$nombreP,$empresa_fab,$descripcion,$iva,$IMG,$IMGext)
	{
			$v = "/".$_FILES["file"]["name"] ;
			$path_parts = pathinfo($v);
			$IMG =  $path_parts['filename'];
			$sql = 'INSERT INTO producto(id_prod, nombre, empresa_fab, descripcion, iva) VALUES ("'.$id_prod.'","'.$nombreP.'","'.$empresa_fab.'","'.$descripcion.'",'.$iva.' )';
			$this->oMySQL->ejecutarConsultaI($sql);
			$sql = 'INSERT INTO imagen(id_prod, ruta, ancho, largo, extension) VALUES ("'.$id_prod.'","'.$IMG.'",0,0,"'.$IMGext.'")';
			$this->oMySQL->ejecutarConsultaI($sql);
	}
	/**
	* Función que actualiza un producto de la base de datos
	*/
	function actualizarProducto($id_prod,$nombreP,$empresa_fab,$descripcion,$iva, $IMG)
	{
			$sql = 'UPDATE producto SET nombre="'.$nombreP.'",empresa_fab="'.$empresa_fab.'",descripcion="'.$descripcion.'",iva='.$iva.' WHERE id_prod="'.$id_prod.'"';
			$this->oMySQL->ejecutarConsultaI($sql);
			if(isset($IMG))
			{
				$sql = 'UPDATE imagen SET ruta="'.$IMG.'" WHERE id_prod="'.$id_prod.'"';
				$this->oMySQL->ejecutarConsultaI($sql);
			}
			echo $sql;
	}
	
	/**
	* Retorna todos los detalles relacionados a una lista de items
	*/
	function infoProductos($items)
	{
		$clausulaWhere = '';
		foreach($items as $item)
		{
			$clausulaWhere .= ('id_prod="'.$item.'" OR ');
		}
		$clausulaWhere = substr($clausulaWhere, 0, strrpos($clausulaWhere, 'OR', 0));
		$sql = 'SELECT id_prod,nombre,empresa_fab,descripcion,iva,precio.valor AS precio 
FROM producto INNER JOIN precio ON producto.id_prod = precio.cod_producto
WHERE now() between precio.fecha_ini and precio.fecha_fin AND '
		.$clausulaWhere. " ORDER BY id_prod ASC";
		
		return $this->oMySQL->ejecutarConsultaSelect($sql);
	}
	
	/**
	*	Devuelve la cantidad de ocurrencias en un arreglo
	*/
	function cantidadInicial($items)
	{
		$arr = array();
		//print_r($items);
		for($i =0; $i< count($items); $i++)
		{	
			if($items[$i] != '-1')
			{
				$ocurrencias = 1;
				for($j = $i+1; $j < count ($items); $j++)
				{
					if(strcmp($items[$j],$items[$i])==0 )
					{
						$ocurrencias++;
						$items[$j] = '-1';
					}
				}
				$arr[$items[$i]] = $ocurrencias;
			}
		}
		return $arr;
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