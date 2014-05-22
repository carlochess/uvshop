
<?php

// configurar autoloading
require_once '../libs/vendor/autoload.php';

// configurar Propel
require_once '../libs/generated-conf/config.php';

class ModelPromo {
    /* Clase encargada de las consultas a la bd */

    public $oMySQL;

    function __construct(MySQL $db=null) {
        $this->oMySQL = $db;
    }

    /** Agrega una promoción a la base de datos */
    function agregarPromocion($id_item, $f_inic, $f_fin, $desc) {
        $promocion = new Precio();
        $promocion->setIdPrecio($id_item);
        $promocion->setFechaIni($f_inic);
        $promocion->setFechaFin($f_fin);
        $promocion->setValor($desc);
        $promocion->save();
        //$sql = 'INSERT INTO promocion(cod_producto, fecha_ini, fecha_fin, valor, porcetaje_red) VALUES ("' . $id_item . '", "' . $f_inic . '","' . $f_fin . '",0,' . $desc . ')';
        //$this->oMySQL->ejecutarConsultaI($sql);
    }

    /** retorna todas las promociones de hoy */
    function getPromociones() {
        /*$consulta = \Base\::create()
                ->select(array("cod_producto", "fecha_ini", "fecha_fin", "porcetaje_red"))
                ->find();
        return $consulta->toArray();*/
        //return $this->oMySQL->ejecutarConsultaSelect('SELECT cod_producto, fecha_ini, fecha_fin, porcetaje_red FROM promocion');
    }

    /** retorna las promociones de un producto para este día */
    function getPromocion($id) {
        $consulta = \Base\PrecioQuery::create()
                ->select(array("id_precio", "fecha_ini", "fecha_fin"))
                ->where("cod_producto='".$id."' and  CAST(now() AS DATE) between precio.fecha_ini and precio.fecha_fin")
                ->find();
        return $consulta->toArray();
        /*return $this->oMySQL->ejecutarConsultaSelect('SELECT cod_producto, fecha_ini, fecha_fin, porcetaje_red 
		FROM promocion 
		WHERE cod_producto="' . $id . '" AND CAST(now() AS DATE) between promocion.fecha_ini and promocion.fecha_fin');
         */
    }

    /** recibe todas las promociones */
    function eliminarPromocion($id) {
        return $this->oMySQL->ejecutarConsultaI('DELETE FROM promocion WHERE cod_producto="' . $id . '"');
    }

    /** recibe todas las promociones */
    function actualizarPromocion($id_item, $f_inic, $f_fin, $desc) {
        $sql = 'UPDATE promocion SET fecha_ini="' . $f_inic . '",fecha_fin="' . $f_fin . '",porcetaje_red= ' . $desc . ' WHERE cod_producto= "' . $id_item . '"';
        return $this->oMySQL->ejecutarConsultaI($sql);
    }

    /**
     * Función que termina la conexión con la base de datos
     */
    function terminarConexion() {
        $this->oMySQL->cerrarConexion();
    }

}

?>