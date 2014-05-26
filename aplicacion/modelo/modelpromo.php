
<?php

// configurar autoloading
//require_once '../libs/vendor/autoload.php';

// configurar Propel
//require_once '../libs/generated-conf/config.php';

class ModelPromo {
    /* Clase encargada de las consultas a la bd */

    public $oMySQL;

    function __construct(MySQL $db=null) {
        $this->oMySQL = $db;
    }

    /** Agrega una promoción a la base de datos */
    function agregarPromocion($id_item, $f_inic, $f_fin, $desc) {
        $promocion = new Promocion();
        $promocion->setCodProducto($id_item);
        $promocion->setFechaIni($f_inic);
        $promocion->setFechaFin($f_fin);
        $promocion->setPorcetajeRed($desc);
        $promocion->save();
        /*$sql = 'INSERT INTO promocion(cod_producto, fecha_ini, fecha_fin, valor, porcetaje_red) VALUES ("' . $id_item . '", "' . $f_inic . '","' . $f_fin . '",0,' . $desc . ')';
        $this->oMySQL->ejecutarConsultaI($sql);*/
    }

    /** 
     * retorna todas las promociones de hoy 
     */
    function getPromociones() {
        $consulta = \Base\PromocionQuery::create()
                ->select(array("id_promocion","cod_producto", "fecha_ini", "fecha_fin", "porcetaje_red"))
                ->find();
        $arregloObj = json_decode(json_encode($consulta->toArray()), FALSE);
        return $arregloObj;/*
        return $this->oMySQL->ejecutarConsultaSelect('SELECT cod_producto, fecha_ini, fecha_fin, porcetaje_red FROM promocion');
         * */
    }

    /** 
     * retorna las promociones de un producto para este día 
     */
    function getPromocion($id) {
        $consulta = \Base\PromocionQuery::create()
                ->select(array("cod_producto", "fecha_ini", "fecha_fin", "porcetaje_red"))
                ->where("cod_producto='".$id."' and  CAST(now() AS DATE) between fecha_ini and fecha_fin")
                ->find();
        $arregloObj = json_decode(json_encode($consulta->toArray()), FALSE);
        return $arregloObj;
        /*
        return $this->oMySQL->ejecutarConsultaSelect('SELECT cod_producto, fecha_ini, fecha_fin, porcetaje_red 
		FROM promocion 
		WHERE cod_producto="' . $id . '" AND CAST(now() AS DATE) between promocion.fecha_ini and promocion.fecha_fin');*/
    }

    /** recibe todas las promociones */
    function eliminarPromocion($id) {
        $promo = \Base\PromocionQuery::create()->filterByIdPromocion($id)->find();
        $promo->delete();
        //return $this->oMySQL->ejecutarConsultaI('DELETE FROM promocion WHERE cod_producto="' . $id . '"');
    }

    function actualizarPromocion($id_item, $f_inic, $f_fin, $desc) {
        \Base\PromocionQuery::create()
        ->filterByIdPromocion($id_item)
        ->update(array("FechaIni" => $f_inic,
            "FechaFin" => $f_fin,
            "PorcetajeRed" => $desc
            ));
        echo "actualizado $desc";
        /*$sql = 'UPDATE promocion SET fecha_ini="' . $f_inic . '",fecha_fin="' . $f_fin . '",porcetaje_red= ' . $desc . ' WHERE cod_producto= "' . $id_item . '"';
        return $this->oMySQL->ejecutarConsultaI($sql);*/
    }

    /**
     * Función que termina la conexión con la base de datos
     */
    function terminarConexion() {
        $this->oMySQL->cerrarConexion();
    }

}

?>