<?php

/**
 * Clase encargada de las transacciones y la adquisción de productos
 */
class Pago extends Controlador {

    // Constructor clase Pago
    function __construct() {
        parent::__construct();
    }

    /*
     * Función encargada de desplegar la información concerniente
     * a lo que lleva el carrito.
     */

    function /* void */ index() {
        if (isset($_COOKIE['carritoCod']) && !empty($_COOKIE['carritoCod'])) {
            $modelprod = $this->loadModel("modelProd");
            $str = str_replace("\"", "", $_COOKIE['carritoCod']);
            $articulos = explode(' ', $str);
            $cantidadInit = $modelprod->cantidadInicial($articulos);
            $detallesProductos = $modelprod->infoProductos($articulos);
            require('aplicacion/vista/Pagos/header.php');
            require('aplicacion/vista/Pagos/pago.php');
            require('aplicacion/vista/Pagos/footer.php');
            $modelprod->terminarConexion();
        } else {
            //header('Location: ' . URL);
            print_r($_COOKIE['carritoCod']);
            echo "<br />";
        }
    }

    /**
     * Nota: 'modos' Se refiere a "modos de pago"
     * Habiendo seleccionado los items a comprar, es hora de 
     * especificar los medios de pago, las cuotas y los montos
     * 
     */
    function /* void */ modos() {

        if (isset($_POST) && count($_POST) > 0) {
            $modelprod = $this->loadModel("modelProd");
            $ids = array();
            $cantidades = array();
            for ($i = 0; $i < count($_POST) - 1; $i+=2) {
                $ids[] = $_POST[$i];
                $cantidades[] = $_POST[$i + 1];
            }
            if (count($ids) > 0) {
                $detallesProductos = $modelprod->infoProductos($ids);
                $total = 0;
                $i = 0;

                foreach ($detallesProductos as $detalleProducto) {
                    $total += floatval($detalleProducto->precio) * intval($cantidades[$i]);
                    ++$i;
                }
                require('aplicacion/vista/Pagos/header.php');
                require('aplicacion/vista/Pagos/modo.php');
                require('aplicacion/vista/Pagos/footer.php');
            } else {
                header('Location: ' . URL);
            }
        } else {
            header('Location: ' . URL);
        }
    }

    function /* void */ confirmar() {

        if (isset($_POST['metodosFIN']) && $_POST['prodFIN']) {
            $metodosPago = json_decode($_POST['metodosFIN']);
            $productos = json_decode($_POST['prodFIN']);
            if (count($metodosPago) > 3 && count($productos) > 1) {
                require('validadorB.php');
                $metodosPago = array_slice($metodosPago, 3, count($metodosPago));
                $productos = array_slice($productos, 1, count($productos));
                echo "Validando los productos";
                if(!$this->validarProductos($productos)){
                    echo "Error al validar productos";
                    header('Location: ' . URL . 'pago/modos');
                }
                if(!$this->validarPagos($metodosPago)){
                    echo "Error al validar métodos de pago";
                    header('Location: ' . URL . 'pago/modos');
                }
                
                require('aplicacion/vista/Pagos/header.php');
                require('aplicacion/vista/Pagos/confirmar.php');
                require('aplicacion/vista/Pagos/footer.php');
            }
            else {
                header('Location: ' . URL . 'pago/modos');
            }
        } else {
            header('Location: ' . URL . 'pago/modos');
        }
    }

    function /* void */ finalizar() {
        if (isset($_POST['metodosFIN']) && $_POST['prodFIN']) {
            $metodosPago = json_decode($_POST['metodosFIN']);
            $productos = json_decode($_POST['prodFIN']);
            if (count($metodosPago) > 1 && count($productos) > 1) {
                $metodosPago = array_slice($metodosPago, 1, count($metodosPago));
                $productos = array_slice($productos, 1, count($productos));
                $modelpago = $this->loadModel("modelPago");
                // 1. valido los productos y sus cantidades
                $this->validarProductos($productos);
                // 2. valido los métodos de pago
                $this->validarPagos($metodosPago);
                // 3. Inserto un registro en 'factura'
                $modelpago->agregarFactura('01', date("Y/m/d"), count($productos));
                // 4. recibo el id de la factura
                $id_factura = intval($modelpago->getIDfactura());
                echo $id_factura;
                // 5. inserto los productos (como compras) en la base de datos
                foreach ($productos as $producto) {
                    $modelpago->agregarCompra($producto->id, $id_factura, $producto->Cantidad);
                }
                // 6. inserto los métodos de pago 
                foreach ($metodosPago as $metododePago) {
                    $modelpago->agregarMetodo($id_factura, $metododePago->Medio_de_pago, $metododePago->Numero_de_cuotas, $metododePago->Monto);
                }
                $modelpago->terminarConexion();
                unset($_COOKIE['carritoCod']);
                setcookie('carritoCod', null, -1, '/');
                // 7. borrar los elementos del carrito
                require('aplicacion/vista/Pagos/header.php');
                require('aplicacion/vista/Pagos/finalizar.php');
                require('aplicacion/vista/Pagos/footer.php');
            } else {
                print_r($metodosPago);
                print_r($productos);
            }
        } else {
            header('Location: ' . URL);
        }
    }

    function validarProductos($productos) {
        // 1. valido los productos y sus cantidades
        foreach ($productos as $prod) {
            // Se asegura de que la cantidad este entre [1,100]
            if (!Validador::createBuilder(intval($prod->Cantidad))->esInt()->enIntervalo(1, 100)->build()->isValid()) {
                echo "Error cantidad: " . $prod->Cantidad;
                return false;
            }
            if (!Validador::createBuilder($prod->id)->esCadena()->tieneLongitud(1, 10)->build()->isValid()) {
                echo "Error id: " . $prod->id;
                return false;
            }
            if (!Validador::createBuilder($prod->Nombre)->esCadena()->tieneLongitud(1, 30)->build()->isValid()) {
                echo "Error Nombre: " . $prod->Nombre;
                return false;
            }
        }
    }

    function validarPagos($metodosPago) {
        // 2. valido los métodos de pago
        foreach ($metodosPago as $metodo) {
            // Se asegura de que la cantidad este entre [1,100]
            if (Validador::createBuilder($metodo->Medio_de_pago)
                            ->esCadena()
                            ->igualA(array("tarjeta", "efectivo"))
                            ->build()->isValid()) {
                if (strcmp($metodo->Medio_de_pago, "tarjeta") == 0) {
                    if (!Validador::createBuilder($metodo->Numero_de_tarjeta)->esTarjeta()->build()->isValid() ||
                            !Validador::createBuilder(intval($metodo->Numero_de_cuotas))->esInt()->enIntervalo(1, 36)->build()->isValid() ||
                            !Validador::createBuilder(floatval($metodo->Monto))->esFloat()->min(1)->build()->isValid()
                    ) {
                        echo "Error en tarjeta: " . $metodo->Numero_de_tarjeta;
                        return false;
                    }
                } else { // efectivo
                    if (!Validador::createBuilder(floatval($metodo->Monto))->esFloat()->min(0.1)->build()->isValid()) {
                        echo "Error en efectivo, monto: " . $metodo->Monto;
                        return false;
                    }
                }
            } else {
                echo "Error en el medio de pago: " . $metodo->Medio_de_pago;
                return false;
            }
        }
    }

}
