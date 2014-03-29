
<?php

class ModelPago
{
	/* Clase encargada de las consultas a la bd*/
	public $oMySQL;
	/*  */
	function __construct(MySQL $db)
	{
		
		$this->oMySQL = $db;
	}
	
	/** Agrega una factura a la base de datos*/
	function /*void*/ agregarFactura($id_cliente,$fecha,$cantidadProd)
	{
		$sql = 'INSERT INTO factura(`id_cliente`, `fecha`, `cantidad_productos`) VALUES ("'.$id_cliente.'","'.$fecha.'",'.$cantidadProd.')';
		$this->oMySQL->ejecutarConsultaI($sql);
	}
	
	/** Retorna el id del último registro insertado en a bd */
	function /* int */ getIDfactura()
	{
		return $this->oMySQL->getLastID();
		
	}
	
	/** Agrega un precio a la base de datos*/
	function /*void*/ agregarCompra($id_prod,$id_factura,$cantidadProd)
	{
		$sql = 'INSERT INTO compra(id_prod, id_factura, cant_prod) VALUES ("'.$id_prod.'",'.$id_factura.','.$cantidadProd.')';
		$this->oMySQL->ejecutarConsultaI($sql);
	}
	
	/** Agrega un método de pago a la base de datos*/
	function /*void*/ agregarMetodo($id_factura,$tipo, $cuotas, $monto)
	{
		$sql = 'INSERT INTO metodo_pago(`id_factura`, `tipo`, `cuotas`, `monto`) VALUES ('.$id_factura.',"'.$tipo.'",'.$cuotas.','.$monto.')';
		$this->oMySQL->ejecutarConsultaI($sql);
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