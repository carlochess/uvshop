
<?php

class ModelFactura
{
	/* Clase encargada de las consultas a la bd*/
	public $oMySQL;
	/*  */
	function __construct(MySQL $db)
	{
		
		$this->oMySQL = $db;
	}
	
	/** Devuelve todas las facturas de la base de datos*/
	function /*array(stdObject)*/ getFacturas()
	{
		$sql = 'SELECT `id_factura`, `id_cliente`, `fecha`, `cantidad_productos` FROM `factura`';
		return $this->oMySQL->ejecutarConsultaSelect($sql);
	}
	
	/** Devuelve los elementos comprados en factura
	/* @arg int id identificación de la factura
	*/
	function /*array(stdObject)*/ getFactura($id)
	{
		$sql = 'SELECT id_prod, cant_prod FROM compra WHERE id_factura='.$id;
		return $this->oMySQL->ejecutarConsultaSelect($sql);
	}
	
	/**
	* Función que termina la conexión con la base de datos
	*/
	function /* void */  terminarConexion()
	{
		$this->oMySQL->cerrarConexion();
	}
}
?>