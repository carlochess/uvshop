
<?php

// configurar autoloading
require_once '../libs/vendor/autoload.php';

// configurar Propel
require_once '../libs/generated-conf/config.php';

class ModelHome
{
	/* Clase encargada de las consultas a la bd*/
	private $oMySQL;
	
	function __construct(/*MySQL*/ $db)
	{
            $this->oMySQL = $db;
	}
	/** Retorna las categorías que agrupan a los producto */
	function /* array(stdObject) */ getCategorias()
	{
            $consulta = \Base\ProductoQuery::create()->select("*")->distinct()->find();
            return $consulta->toArray();
            //return $this->oMySQL->ejecutarConsultaSelect('SELECT DISTINCT categoria FROM producto');
	}
	
	/**Retorna los productos mas vendidos */
	function getProdMasVend()
	{
            $consulta = \Base\ProductoQuery::create()
                    ->select("*")
                    ->addAsColumn("cantidad", 'COUNT(unidades)')
                    ->groupBy("unidades")//'SUM(price_equipment)'
                    ->orderBy("cantidad", "DESC")
                    ->limit(6)
                    ->find();
            return $consulta->toArray();
            //return $this->oMySQL->ejecutarConsultaSelect('SELECT id_prod, COUNT(cant_prod) FROM compra ORDER BY cant_prod DESC LIMIT 6');
            //                                            SELECT COUNT(unidades) AS cantidad FROM  GROUP BY producto.UNIDADES ORDER BY cantidad ASC LIMIT 6

	}
	
	/** Retorna las ofertas de día */
	function getOfertas()
	{
		$sql = "SELECT promocion.cod_producto, promocion.fecha_ini, promocion.fecha_fin, precio.valor AS valor, porcetaje_red, producto.id_prod AS id_prod,producto.nombre AS nombre, producto.descripcion  AS descripcion
FROM promocion, producto, precio
WHERE 
promocion.cod_producto = producto.id_prod AND
producto.id_prod=precio.cod_producto AND 
now() between promocion.fecha_ini and promocion.fecha_fin AND
now() between precio.fecha_ini and precio.fecha_fin";
		return $this->oMySQL->ejecutarConsultaSelect($sql);
	}
	
	/** Retorna N objetos aleatorios */
	function getProdAleatorios()
	{
            $consulta = \Base\ProductoQuery::create()
                    ->joinPrecio()
                    ->select("*")
                    ->find();
            return $consulta->toArray();
            //return $this->oMySQL->ejecutarConsultaSelect('SELECT producto.id_prod AS id_prod, nombre, descripcion,empresa_fab,iva, producto.id_prod AS ruta,precio.valor AS precio  FROM producto,precio WHERE producto.id_prod=precio.cod_producto ORDER BY RAND() LIMIT 3 ');
	}
	
	/** Retorna los 10 productos mas vendidos*/
	function getMasVendidos()
	{
            $consulta = \Base\ProductoQuery::create()
                    ->select("*")
                    ->addAsColumn("veces", 'count(id_prod)')
                    ->addAsColumn("cantidad", 'count(unidades)')
                    ->groupBy("id_prod")//'SUM(price_equipment)'
                    ->orderBy("veces", "DESC")
                    ->limit(10)
                    ->find();
            return $consulta->toArray();
            //return $this->oMySQL->ejecutarConsultaSelect('SELECT id_prod, count(id_prod) AS veces ,count(cant_prod) as cantidad FROM compra GROUP BY id_prod ORDER BY veces DESC LIMIT 10 ');
	}
	
	function terminarConexion()
	{
		$this->oMySQL->cerrarConexion();
	}
}

function main()
{
    $objHome = new ModelHome(NULL);
    print_r($objHome->getProdAleatorios());
}

main();

?>