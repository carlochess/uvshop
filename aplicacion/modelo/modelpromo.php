
<?php

class ModelPromo
{
	/* Clase encargada de las consultas a la bd*/
	public $oMySQL;
	
	function __construct()
	{
		require 'aplicacion/libs/bd.php';
		$this->oMySQL = new MySQL();
	}
	/** Agrega una promoción a la base de datos [ Genera error]*/
	function agregarPromocion($id_item, $f_inic,$f_fin,$desc)
	{
		$sql = 'INSERT INTO promocion(cod_producto, fecha_ini, fecha_fin, valor, porcetaje_red) VALUES ("'.$id_item.'", "'.$f_inic.'","'.$f_fin.'",0,'.$desc.')';
		$this->oMySQL->ejecutarConsultaI($sql);
	}
	
	/** recibe todas las promociones */
	function getPromociones()
	{
		return $this->oMySQL->ejecutarConsultaSelect('SELECT cod_producto, fecha_ini, fecha_fin, porcetaje_red FROM promocion');
	}
	
	/** recibe todas las promociones */
	function eliminarPromocion($id)
	{
		return $this->oMySQL->ejecutarConsultaI('DELETE FROM promocion WHERE cod_producto="'.$id.'"');
	}
	
	/** recibe todas las promociones */
	function actualizarPromocion($id_item, $f_inic,$f_fin,$desc)
	{
		$sql = 'UPDATE promocion SET fecha_ini="'.$f_inic.'",fecha_fin="'.$f_fin.'",porcetaje_red= '.$desc.' WHERE cod_producto= "'.$id_item.'"';
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