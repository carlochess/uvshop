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
        $id_item = $_POST['idItem'];
        $f_inic = $_POST['f_inicio'];
        $f_fin = $_POST['f_finalizacion'];
        $desc = floatval($_POST['descuento']);
        $modelpromo = $this->loadModel("modelPromo");
        try{
        $modelpromo->agregarPromocion($id_item, $f_inic, $f_fin, $desc);
        }  catch (Exception $ex)
        {
            
        }
        $modelpromo->terminarConexion();
        header('Location: ' . URL . 'admin/promociones');
    }

    /**
     * Función encargada de editar una promoción 
     */
    function /* void */ editarpromo() {
        $id_item = $_POST['idItem'];
        $f_inic = $_POST['f_inicio'];
        $f_fin = $_POST['f_finalizacion'];
        $desc = floatval($_POST['descuento']);
        $modelpromo = $this->loadModel("modelPromo");
        $modelpromo->actualizarPromocion($id_item, $f_inic, $f_fin, $desc);
        $modelpromo->terminarConexion();
        //header('Location: ' . URL . 'admin/promociones');
    }

    /**
     * Función encargada de eliminar una promoción 
     */
    function /* void */ eliminarpromo($id) {
        $modelpromo = $this->loadModel("modelPromo");
        $modelpromo->eliminarPromocion($id[0]);
        $modelpromo->terminarConexion();
        header('Location: ' . URL . 'admin/promociones');
    }

}
