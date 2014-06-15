<?php

class Precios extends Controlador {

    // Constructor clase producto
    function __construct() {
        parent::__construct();
    }

    // 
    function index() {
        
    }

    /**
     * Función que agrega un precio a la tabla.
     */
    function /* void */ agregarprecio($id) {
        require('validador.php');
        $valid = new removedor();
        $f_inic = $valid->test_input($_POST['f_inicio']);
        $f_fin = $valid->test_input($_POST['f_finalizacion']);
        $precio = $valid->test_input($_POST['precio']);
        $id = $id[0];
        require('validadorB.php');
        $error = array();
        $modelprecio = $this->loadModel("modelPrecio");
        if (Validador::createBuilder($f_inic)->esFecha()->fechaNoSeCruzaCon($f_fin)->build()->isValid()) {
            if (Validador::createBuilder($precio)->esFloat()->enIntervalo(0, 10000000)->build()->isValid()) {
                try {
                    $modelprecio->agregarPrecio($id, $f_inic, $f_fin, intval($precio));
                } catch (Exception $ex) {
                    array_push($error, "Error al agregar precio: ");
                }
            } else {
                array_push($error, "Error en el precio");
            }
        } else {
            array_push($error, "Error en las fechas");
        }
        $precios = $modelprecio->getPrecios($id);
        $modelprecio->terminarConexion();
        require('aplicacion/vista/Admin/header.php');
        require('aplicacion/vista/Admin/precioId.php');
        require('aplicacion/vista/Admin/footer.php');
    }

    /**
     * 	Función que edita los datos del precio de un producto
     */
    function /* void */ editarprecio($id) {
        $id_precio = $_POST['id_precio'];
        require('validador.php');
        $valid = new removedor();
        $f_inic = $valid->test_input($_POST['f_inicio']);
        $f_fin = $valid->test_input($_POST['f_finalizacion']);
        $precio = $valid->test_input($_POST['precio']);
        require('validadorB.php');
        $error = array();
        $modelprecio = $this->loadModel("modelPrecio");
        $id = $id[0];
        if (Validador::createBuilder($f_inic)->esFecha()->fechaNoSeCruzaCon($f_fin)->build()->isValid()) {
            if (Validador::createBuilder($precio)->esFloat()->enIntervalo(0, 10000000)->build()->isValid()) {
                try {
                    $modelprecio->actualizarPrecio($id_precio, $f_inic, $f_fin, $precio);
                } catch (Exception $ex) {
                    array_push($error, "Error al agregar precio: ");
                }
            } else {
                array_push($error, "Error en el precio");
            }
        } else {
            array_push($error, "Error en las fechas");
        }
        $precios = $modelprecio->getPrecios($id);
        $modelprecio->terminarConexion();
        require('aplicacion/vista/Admin/header.php');
        require('aplicacion/vista/Admin/precioId.php');
        require('aplicacion/vista/Admin/footer.php');
        //header('Location: ' . URL . 'admin/precio/' . $id[0]);
    }

    /**
     * Función que elimina el precio según identificación del mismo y el item al cual pertenece
     */
    function /* void */ eliminarprecio($id) {
        $modelprecio = $this->loadModel("modelPrecio");
        $modelprecio->eliminarPrecio($id[0]);
        $modelprecio->terminarConexion();
        header('Location: ' . URL . 'admin/precio/' . $id[1]);
    }

}
