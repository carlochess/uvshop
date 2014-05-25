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
        $f_inic = $_POST['f_inicio'];
        $f_fin = $_POST['f_finalizacion'];
        $precio = $_POST['precio'];
        echo floatval($precio);
        $modelprecio = $this->loadModel("modelPrecio");
        $modelprecio->agregarPrecio($id[0], $f_inic, $f_fin, intval($precio));
        $modelprecio->terminarConexion();
        header('Location: '.URL.'admin/precio/'.$id[0]);
    }

    /**
     * 	Función que edita los datos del precio de un producto
     */
    function /* void */ editarprecio($id) {
        $id_precio = $_POST['id_precio'];
        $f_inic = $_POST['f_inicio'];
        $f_fin = $_POST['f_finalizacion'];
        $precio = $_POST['precio'];
        $modelprecio = $this->loadModel("modelPrecio");
        $modelprecio->actualizarPrecio($id_precio, $f_inic, $f_fin, $precio);
        $modelprecio->terminarConexion();
        header('Location: ' . URL . 'admin/precio/' . $id[0]);
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
