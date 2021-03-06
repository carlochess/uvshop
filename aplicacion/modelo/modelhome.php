
<?php

class ModelHome {
    private $oMySQL;

    function __construct(MySQL $db) {
        $this->oMySQL = $db;
    }

    /** Retorna las categorías que agrupan a los producto */
    function /* array(stdObject) */ getCategorias() {
        $consulta = \Base\ProductoQuery::create()->select(array("categoria"))->distinct()->find();
        $arregloObj = json_decode(json_encode($consulta->toArray()), FALSE);
        return $arregloObj;
        //return $this->oMySQL->ejecutarConsultaSelect('SELECT DISTINCT categoria FROM producto');
    }

    /*     * Retorna los productos mas vendidos */

    function getProdMasVend() {
        $consulta = \Base\ProductoQuery::create()
                ->select("*")
                ->addAsColumn("cantidad", 'COUNT(unidades)')
                ->groupBy("unidades")//'SUM(price_equipment)'
                ->orderBy("cantidad", "DESC")
                ->limit(6)
                ->find();
        $arregloObj = json_decode(json_encode($consulta->toArray()), FALSE);
        return $arregloObj;
        //return $this->oMySQL->ejecutarConsultaSelect('SELECT id_prod, COUNT(cant_prod) FROM compra ORDER BY cant_prod DESC LIMIT 6');
        //                                            SELECT COUNT(unidades) AS cantidad FROM  GROUP BY producto.UNIDADES ORDER BY cantidad ASC LIMIT 6
    }

    /** Retorna las ofertas de día */
    function getOfertas() {
        /*
        $consulta = \Base\ProductoQuery::create()
                ->joinPromocion("promocion.cod_producto = producto.id_prod")
                ->joinPrecio("promocion.cod_producto = producto.id_prod")
                ->where("now() between Promocion.fecha_ini AND Promocion.fecha_fin AND now() between Precio.fecha_ini and Precio.fecha_fin")
                ->select(array("Promocion.cod_producto", "Promocion.fecha_ini", "Promocion.fecha_fin","porcetaje_red"))
                ->addAsColumn("valor", 'Precio.valor')
                ->addAsColumn("id_prod", 'Producto.id_prod')
                ->addAsColumn("nombre", 'Producto.nombre')
                ->addAsColumn("descripcion", 'Producto.descripcion')
                ->limit(6)
                ->find();
        $arregloObj = json_decode(json_encode($consulta->toArray()), FALSE);
        return $arregloObj;*/
        
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
    function getProdAleatorios() {
        $consulta = \Base\PrecioQuery::create()
                ->joinWith('Precio.Producto')
                ->select("Producto.IdProd")
                ->withColumn("Producto.IdProd", 'id_prod')
                ->withColumn("Producto.IdProd", 'ruta')
                ->withColumn("Producto.nombre", 'nombre')
                ->withColumn("Producto.descripcion", 'descripcion')
                ->withColumn("Producto.empresa_fab", 'empresa_fab')
                ->withColumn("Producto.iva", 'iva')
                ->withColumn("Precio.valor", 'precio')
                ->addAscendingOrderByColumn("RAND()")
                ->limit(3)
                ->find();
        $arregloObj = json_decode(json_encode($consulta->toArray()), FALSE);
        
        return $arregloObj;
        
        /*
        $sql = "SELECT producto.id_prod AS id_prod, nombre, descripcion,empresa_fab,iva, producto.id_prod AS ruta,precio.valor AS precio  "
          . "FROM producto,precio WHERE producto.id_prod=precio.cod_producto "
          . "ORDER BY RAND() "
          . "LIMIT 3";
        return $this->oMySQL->ejecutarConsultaSelect($sql);*/
    }

    /** Retorna los 10 productos mas vendidos */
    function getMasVendidos() {
        $consulta = \Base\CompraQuery::create()
                ->select(array("id_prod"))
                ->addAsColumn("veces", 'count(id_prod)')
                ->addAsColumn("cantidad", 'count(cant_prod)')
                ->groupBy("id_prod")//'SUM(price_equipment)'
                ->orderBy("veces", "DESC")
                ->limit(10)
                ->find();
        $arregloObj = json_decode(json_encode($consulta->toArray()), FALSE);
        return $arregloObj;
        //return $this->oMySQL->ejecutarConsultaSelect('SELECT id_prod, count(id_prod) AS veces ,count(cant_prod) as cantidad FROM compra GROUP BY id_prod ORDER BY veces DESC LIMIT 10 ');
    }

    function terminarConexion() {
        $this->oMySQL->cerrarConexion();
    }

}

//main();
?>
