
<?php
require_once 'aplicacion/libs/bd.php';
class ModelHome
{
	/* Clase encargada de las consultas a la bd*/
	public $oMySQL;
	
	function __construct()
	{
		
		$this->oMySQL = new MySQL();
	}
	/** Retorna las categorias en las que se clasifican los productos */
	function getCategorias()
	{
		return $this->oMySQL->ejecutarConsultaSelect('SELECT * FROM categoria WHERE id_padre=""');
	}
	
	/**Retorna los productos mas vendidos */
	function getProdMasVend()
	{
		return $this->oMySQL->ejecutarConsultaSelect('SELECT id_prod, COUNT(cant_prod) FROM compra ORDER BY cant_prod DESC LIMIT 6');
	}
	
	/** Retorna las ofertas de día */
	function getOfertas()
	{
		return $this->oMySQL->ejecutarConsultaSelect('SELECT * FROM promosdeldia');
	}
	
	/** Retorna N objetos aleatorios */
	function getProdAleatorios()
	{
		return $this->oMySQL->ejecutarConsultaSelect('SELECT id_prod, nombre, descripcion,empresa_fab,iva,ruta,extension FROM producto INNER JOIN imagen ON imagen.id_prod = producto.codigo ORDER BY RAND() LIMIT 3 ');
	}
	
	function terminarConexion()
	{
		$this->oMySQL->cerrarConexion();
	}
}
?>