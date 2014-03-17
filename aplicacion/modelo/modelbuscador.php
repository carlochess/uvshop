
<?php

class ModelBuscador
{
	/* Clase encargada de las consultas a la bd*/
	public $oMySQL;
	
	function __construct()
	{
		require 'aplicacion/libs/bd.php';
		$this->oMySQL = new MySQL();
	}
	/** Retorna la busqueda de los productos relacionados a la palabra clave*/
	function buscarInfoProd($nombre)
	{
		return $this->oMySQL->ejecutarConsultaSelect('SELECT nombre, codigo, ruta FROM producto,imagen WHERE producto.codigo = imagen.id_prod AND nombre LIKE "%'.$nombre.'%";');
	}
	
	function terminarConexion()
	{
		$this->oMySQL->cerrarConexion();
	}
}
?>