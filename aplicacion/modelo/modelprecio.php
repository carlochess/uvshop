
<?php

class ModelPrecio
{
	/* Clase encargada de las consultas a la bd*/
	public $oMySQL;
	
	function __construct()
	{
		require 'aplicacion/libs/bd.php';
		$this->oMySQL = new MySQL();
	}
	/** Agrega un precio a la base de datos*/
	function agregarPrecio($id_item,$f_inic,$f_fin,$precio)
	{
		$sql = 'INSERT INTO precio(cod_producto, fecha_ini, fecha_fin, valor) VALUES ("'.$id_item.'", "'.$f_inic.'","'.$f_fin.'",'.$precio.')';
		$this->oMySQL->ejecutarConsultaI($sql);
	}
	
	/** Retorna los precios de un producto */
	function getPrecios($id)
	{
		return $this->oMySQL->ejecutarConsultaSelect('SELECT id_precio, fecha_ini, fecha_fin, valor FROM precio WHERE cod_producto="'.$id.'"');
	}
	
	/** Elimina el precio de un producto
	* NO SIRVE Hasta tanto no haya un id
	*/
	function eliminarPrecio($id)
	{
		return $this->oMySQL->ejecutarConsultaI('DELETE FROM precio WHERE id_precio="'.$id.'"');
	}
	
	/** Actualiza el precio de un producto */
	function actualizarPrecio($id_precio, $f_inic,$f_fin,$precio)
	{
		$sql = 'UPDATE precio SET fecha_ini="'.$f_inic.'",fecha_fin="'.$f_fin.'",valor= '.$precio.' WHERE id_precio= "'.$id_precio.'"';
		return $this->oMySQL->ejecutarConsultaI($sql);
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