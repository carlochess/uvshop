
<?php

// configurar autoloading
//require_once '../libs/vendor/autoload.php';
// configurar Propel
//require_once '../libs/generated-conf/config.php';

class ModelPago {
    public $oMySQL;
    private $factura;
    /*  */

    function __construct(MySQL $db) {

        $this->oMySQL = $db;
    }

    /** Agrega una factura a la base de datos */
    function /* void */ agregarFactura($id_cliente, $fecha, $cantidadProd) {
        $this->factura = new Factura();
        $this->factura->setIdCliente($id_cliente);
        $this->factura->setFecha($fecha);
        $this->factura->setCantidadProductos($cantidadProd);
        $this->factura->save();

        /*$sql = 'INSERT INTO factura(`id_cliente`, `fecha`, `cantidad_productos`) VALUES ("' . $id_cliente . '","' . $fecha . '",' . $cantidadProd . ')';
        $this->oMySQL->ejecutarConsultaI($sql);*/
    }

    /** Retorna el id del último registro insertado en a bd */
    function /* int */ getIDfactura() {
        return $this->factura->getIdFactura();
    }

    /** Agrega un precio a la base de datos */
    function /* void */ agregarCompra($id_prod, $id_factura, $cantidadProd) {
        $compra = new Compra();
        $compra->setIdProd($id_prod);
        $compra->setIdFactura($id_factura);
        $compra->setCantProd($cantidadProd);
        $compra->save();

        //$sql = 'INSERT INTO compra(id_prod, id_factura, cant_prod) VALUES ("' . $id_prod . '",' . $id_factura . ',' . $cantidadProd . ')';
        //$this->oMySQL->ejecutarConsultaI($sql);
    }

    /** Agrega un método de pago a la base de datos */
    function /* void */ agregarMetodo($id_factura, $tipo, $cuotas, $monto) {
        $metodo = new MetodoPago();
        $metodo->setIdFactura($id_factura);
        $metodo->setTipo($tipo);
        $metodo->setCuotas($cuotas);
        $metodo->setMonto($monto);
        $metodo->save();
        //$sql = 'INSERT INTO metodo_pago(`id_factura`, `tipo`, `cuotas`, `monto`) VALUES ('.$id_factura.',"'.$tipo.'",'.$cuotas.','.$monto.')';
        //$this->oMySQL->ejecutarConsultaI($sql);
    }

    /**
     * Función que termina la conexión con la base de datos
     */
    function /* void */ terminarConexion() {
        $this->oMySQL->cerrarConexion();
    }

}

?> 