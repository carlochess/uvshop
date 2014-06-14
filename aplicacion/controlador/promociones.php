<?php

class Promociones extends Controlador {

    // Constructor clase producto
    function __construct() {
        parent::__construct();
    }

    // 
    function index() {
        
    }

    /**
     * Función encargada de agregar una promoción 
     */
    function /* void */ agregarpromo() {
        require('validador.php');
        $valid = new removedor();
        $id_item = $valid->test_input($_POST['idItem']);
        $f_inic = $valid->test_input($_POST['f_inicio']);
        $f_fin = $valid->test_input($_POST['f_finalizacion']);
        $desc = $valid->test_input($_POST['descuento']);
        $modelpromo = $this->loadModel("modelPromo");
        require('validadorB.php');
        $error = array();
        if (Validador::createBuilder($id_item)->esCadena()->tieneLongitud(1, 5)->build()->isValid()) {
            if (Validador::createBuilder($f_inic)->esFecha()->fechaNoSeCruzaCon($f_fin)->build()->isValid()) {
                if (Validador::createBuilder($desc)->esFloat()->enIntervalo(1, 100)->build()->isValid()) {
                    try {
                        $modelpromo->agregarPromocion($id_item, $f_inic, $f_fin, floatval($desc));
                    } catch (Exception $ex) {
                        array_push($error, "Item no encontrado");
                    }
                } else {
                    array_push($error, "Error en número de descuento");
                }
            } else {
                array_push($error, "Error en las fechas");
            }
        } else {
            array_push($error, "Error en el id del producto");
        }
        $this->categoria = "promociones";
        $promociones = $modelpromo->getPromociones();
        $modelpromo->terminarConexion();
        require('aplicacion/vista/Admin/header.php');
        require('aplicacion/vista/Admin/promo.php');
        require('aplicacion/vista/Admin/footer.php');
        //header('Location: ' . URL . 'admin/promociones');
    }

    /**
     * Función encargada de editar una promoción 
     */
    function /* void */ editarpromo() {
        require('validador.php');
        $valid = new removedor();
        $id_item = $valid->test_input($_POST['idItem']);
        $f_inic = $valid->test_input($_POST['f_inicio']);
        $f_fin = $valid->test_input($_POST['f_finalizacion']);
        $desc = $valid->test_input($_POST['descuento']);
        $modelpromo = $this->loadModel("modelPromo");
        require('validadorB.php');
        $error = array();
        if (Validador::createBuilder($id_item)->esCadena()->tieneLongitud(1, 5)->build()->isValid()) {
            if (Validador::createBuilder($f_inic)->esFecha()->fechaNoSeCruzaCon($f_fin)->build()->isValid()) {
                if (Validador::createBuilder($desc)->esFloat()->enIntervalo(1, 100)->build()->isValid()) {
                    try {
                        $modelpromo->actualizarPromocion($id_item, $f_inic, $f_fin, $desc);
                    } catch (Exception $ex) {
                        array_push($error, "Item no encontrado");
                    }
                } else {
                    array_push($error, "Error en número de descuento");
                }
            } else {
                array_push($error, "Error en las fechas");
            }
        } else {
            array_push($error, "Error en el id del producto");
        }
        $this->categoria = "promociones";
        $promociones = $modelpromo->getPromociones();
        $modelpromo->terminarConexion();
        require('aplicacion/vista/Admin/header.php');
        require('aplicacion/vista/Admin/promo.php');
        require('aplicacion/vista/Admin/footer.php');
        //header('Location: ' . URL . 'admin/promociones');
    }

    /**
     * Función encargada de eliminar una promoción 
     */
    function /* void */ eliminarpromo($id) {
        $modelpromo = $this->loadModel("modelPromo");
        try{
            $modelpromo->eliminarPromocion($id[0]);
        } catch (Exception $ex) {

        }
        $modelpromo->terminarConexion();
        header('Location: ' . URL . 'admin/promociones');
    }

}
