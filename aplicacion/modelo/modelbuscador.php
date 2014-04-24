
<?php

class ModelBuscador
{
	/* Clase encargada de las consultas a la bd*/
	public $oMySQL;
	
	function __construct(MySQL $db)
	{
		
		$this->oMySQL = $db;
	}
	/** Retorna la busqueda de los productos relacionados a la palabra clave*/
	function buscarInfoProd($nombre)
	{
		return $this->oMySQL->ejecutarConsultaSelect('SELECT nombre, producto.id_prod as id_prod FROM producto WHERE nombre LIKE "%'.$nombre.'%";');
	}
	
	/** Toda la info de todos los producto */
	function getProductos()
	{
		return $this->oMySQL->ejecutarConsultaSelect('SELECT nombre, producto.id_prod as id_prod FROM producto');
	}
	
	function buscarInfoCategoria($categoria)
	{
		return $this->oMySQL->ejecutarConsultaSelect('SELECT id_prod, nombre, descripcion, categoria FROM producto WHERE categoria="'.$categoria.'"');
	}
	
	function numResultados()
	{
		return $this->oMySQL->contarFilasAfectadas();
	}
	
	function terminarConexion()
	{
		$this->oMySQL->cerrarConexion();
	}
}
?>