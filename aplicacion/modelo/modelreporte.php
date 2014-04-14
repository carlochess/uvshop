
<?php

class ModelReporte
{
	/* Clase encargada de las consultas a la bd*/
	public $oMySQL;
	/*  */
	function __construct(MySQL $db)
	{
		$this->oMySQL = $db;
	}
		
	/**  */
	function /*array(stdObject)*/ top20mas()
	{
		$sql = 'SELECT id_prod, count(`id_prod`) AS cantidad FROM `compra` GROUP BY id_prod ORDER BY cantidad DESC LIMIT 20';
		return $this->oMySQL->ejecutarConsultaSelect($sql);
	}
	
	/**  */
	function /*array(stdObject)*/ top20menos()
	{
		$sql = 'SELECT `id_prod`, count(`id_prod`) AS cantidad FROM `compra` GROUP BY id_prod ORDER BY cantidad ASC LIMIT 20';
		return $this->oMySQL->ejecutarConsultaSelect($sql);
	}
	
	/**  */
	function /*array(stdObject)*/ totalVentasProd($nombreProd)
	{
		$sql = ' 
		SELECT MONTH(factura.fecha) as id_prod, SUM(venta.total) as cantidad
		FROM 
		(SELECT id_factura, compra.id_prod, (valor*((100-porcetaje_red)/100)*cant_prod) as total
		FROM compra,producto
		WHERE nombre="'.$nombreProd.'" AND compra.id_prod = producto.id_prod
		GROUP BY id_prod) AS venta INNER JOIN factura ON venta.id_factura = factura.id_factura 
		WHERE factura.fecha BETWEEN (CURRENT_DATE() - INTERVAL 6 MONTH) AND CURRENT_DATE()
		GROUP BY id_prod
		ORDER BY cantidad
		LIMIT 20;';
		return $this->oMySQL->ejecutarConsultaSelect($sql);
	}
	/**  */
	function /*array(stdObject)*/ totalVentasFab()
	{
		$sql = 'SELECT producto.empresa_fab as id_prod, SUM(compra.total) as cantidad
				FROM 
				(
					SELECT id_prod, SUM(valor*((100-porcetaje_red)/100)*cant_prod) as total
					FROM compra
					GROUP BY id_prod 
				) AS compra INNER JOIN producto ON compra.id_prod = producto.id_prod 
				GROUP BY producto.empresa_fab
				LIMIT 20';
		return $this->oMySQL->ejecutarConsultaSelect($sql);
	}
	//-------------
	/**  */
	function /*array(stdObject)*/ bajasExistencias()
	{
		$sql = 'SELECT id_prod, nombre,unidades FROM producto WHERE unidades < 10';
		return $this->oMySQL->ejecutarConsultaSelect($sql);
	}
	/**  */
	function /*array(stdObject)*/ recaudoIva()
	{
		$sql = 'SELECT id_prod, nombre, SUM(compra.recaudoIva) AS unidades
				FROM (
				SELECT compra.id_prod, nombre, `id_factura`, cant_prod*valor*((100-compra.iva)/100) AS recaudoIva 
				FROM compra,producto
				WHERE compra.id_prod = producto.id_prod) AS compra INNER JOIN factura ON compra.id_factura = factura.id_factura 
				WHERE MONTH(factura.fecha) = MONTH(now())';
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