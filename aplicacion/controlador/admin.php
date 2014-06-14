<?php

class Admin extends Controlador {

    public $categoria;

    public function __construct() {
        parent::__construct();
    }

    /**
     * Función que despliega la página base del modulo de
     * administración.
     */
    function /* void */ index() {
        $this->categoria = "informacion";
        require('aplicacion/vista/Admin/header.php');
        require('aplicacion/vista/Admin/index.php');
        require('aplicacion/vista/Admin/footer.php');
    }

    /**
     * Función que despliega la página de ventas
     */
    function /* void */ ventas($id = null) {
        $this->categoria = "ventas";
        $modelFacturas = $this->loadModel("modelFactura");
        if (isset($id)) {
            $productos = $modelFacturas->getFactura($id[0]);
            require('aplicacion/vista/Admin/header.php');
            require('aplicacion/vista/Admin/detallesVenta.php');
            require('aplicacion/vista/Admin/footer.php');
        } else {
            $facturas = $modelFacturas->getFacturas();
            require('aplicacion/vista/Admin/header.php');
            require('aplicacion/vista/Admin/ventas.php');
            require('aplicacion/vista/Admin/footer.php');
        }
        $modelFacturas->terminarConexion();
    }

    /**
     * Función que despliega la página para la administración
     * de productos.
     */
    function /* void */ producto() {
        $this->categoria = "productos";
        $modelprod = $this->loadModel("modelProd");
        $productos = $modelprod->getProductos();
        $modelprod->terminarConexion();
        require('aplicacion/vista/Admin/header.php');
        require('aplicacion/vista/Admin/producto.php');
        require('aplicacion/vista/Admin/footer.php');
    }

    /**
     * Función que despliega la página para la administración
     * de promociones de los productos.
     */
    function /* void */ promociones() {
        $this->categoria = "promociones";
        $modelpromo = $this->loadModel("modelPromo");
        $promociones = $modelpromo->getPromociones();
        $modelpromo->terminarConexion();
        require('aplicacion/vista/Admin/header.php');
        require('aplicacion/vista/Admin/promo.php');
        require('aplicacion/vista/Admin/footer.php');
    }

    /**
     * Función que despliega la página para la administración
     * de precios de los productos.
     * @param array() $id el producto que será afectado
     */
    function /* void */ precio($id = null) {
        $this->categoria = "productos";
        if (isset($id)) {
            $id = $id[0];
            $modelprecio = $this->loadModel("modelPrecio");
            $precios = $modelprecio->getPrecios($id);
            $modelprecio->terminarConexion();
            require('aplicacion/vista/Admin/header.php');
            require('aplicacion/vista/Admin/precioId.php');
            require('aplicacion/vista/Admin/footer.php');
        } else {
            $modelprod = $this->loadModel("modelPrecio");
            $productos = $modelprod->getPrecios();
            $modelprod->terminarConexion();
            require('aplicacion/vista/Admin/header.php');
            require('aplicacion/vista/Admin/precio.php');
            require('aplicacion/vista/Admin/footer.php');
        }
    }

    /**
     * Función encargada de desplegar la página de configuración de reportes
     */
    function /* void */ reportes() {
        $this->categoria = "reportes";
        require('aplicacion/vista/Admin/header.php');
        require('aplicacion/vista/Admin/reportes.php');
        require('aplicacion/vista/Admin/footer.php');
    }
    
}
