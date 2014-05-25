
<?php
// configurar autoloading
//require_once '../libs/vendor/autoload.php';

// configurar Propel
//require_once '../libs/generated-conf/config.php';
class ModelPrecio {
    /* Clase encargada de las consultas a la bd */

    public $oMySQL;

    /*  */

    function __construct(MySQL $db=null) {
        $this->oMySQL = $db;
    }

    /** Agrega un precio a la base de datos */
    function /* void */ agregarPrecio($id_item, $f_inic, $f_fin, $precio) {
        /*$precio = new Precio();
        $precio->setCodProducto($id_item);
        $precio->setFechaIni($f_inic);
        $precio->setFechaFin($f_fin);
        $precio->setValor($precio);
        $precio->save();*/
        
        $sql = 'INSERT INTO precio(cod_producto, fecha_ini, fecha_fin, valor) VALUES ("' . $id_item . '", "' . $f_inic . '","' . $f_fin . '",' . $precio . ')';
        $this->oMySQL->ejecutarConsultaI($sql);
    }

    /** Retorna los precios de un producto */
    function /* array(stdObject) */ getPrecios($id) {
        $consulta = \Base\PrecioQuery::create()
                ->filterByCodProducto($id)
                ->select(array("id_precio", "fecha_ini", "fecha_fin", "valor"))
                ->find();
        $arregloObj = json_decode(json_encode($consulta->toArray()), FALSE);
        return $arregloObj;
        //return $this->oMySQL->ejecutarConsultaSelect('SELECT id_precio, fecha_ini, fecha_fin, valor FROM precio WHERE cod_producto="' . $id . '"');
    }

    /** Retorna el precio de un producto para el día de hoy (no importa cuando sea leido esto) */
    function /* array(stdObject) */ getPrecioHoy($id) {
        $consulta = \Base\PrecioQuery::create()
                ->select(array("id_precio", "fecha_ini", "fecha_fin", "valor"))
                ->where("cod_producto='".$id."' and  CAST(now() AS DATE) between precio.fecha_ini and precio.fecha_fin")
                ->find();
        $arregloObj = json_decode(json_encode($consulta->toArray()), FALSE);
        return $arregloObj;
        //return $this->oMySQL->ejecutarConsultaSelect('SELECT id_precio, fecha_ini, fecha_fin, valor FROM precio WHERE cod_producto="' . $id . '" AND CAST(now() AS DATE) between precio.fecha_ini and precio.fecha_fin ');
    }

    /** Elimina el precio de un producto
     */
    function /* bool */ eliminarPrecio($id) {
        $precio = \Base\PrecioQuery::create()->filterByIdPrecio($id)->find();
        $precio->delete();
        //return $this->oMySQL->ejecutarConsultaI('DELETE FROM precio WHERE id_precio="' . $id . '"');
    }

    /** 
     * Actualiza el precio de un producto 
     */
    function /* bool */ actualizarPrecio($id_precio, $f_inic, $f_fin, $precio) {
        \Base\PrecioQuery::create()
        ->filterByIdPrecio($id_precio)
        ->update(array("FechaIni" => $f_inic,
            "FechaFin" => $f_fin,
            "Valor" => $precio
            ));
        /*$sql = 'UPDATE precio SET fecha_ini="' . $f_inic . '",fecha_fin="' . $f_fin . '",valor= ' . $precio . ' WHERE id_precio= "' . $id_precio . '"';
        return $this->oMySQL->ejecutarConsultaI($sql);*/
    }

    /**
     * Función que termina la conexión con la base de datos
     */
    function /* void */ terminarConexion() {
        $this->oMySQL->cerrarConexion();
    }

}

?>