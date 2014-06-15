<?php

//Levenshtein 
require("AlgoritmoBusqueda.php");

class Levenshtein extends Controlador implements AlgoritmoBusqueda {

    // Constructor clase Liechtenstein
    function __construct() {
        parent::__construct();
    }

    public function buscar($nombre) {
        $modelprod = $this->loadModel("modelbuscador");
        $productos = $modelprod->getProductos();
        $nombre= strtolower($nombre);
        $resBusqueda = array();
        foreach ($productos as $prod) {
            $nombreSeparado = explode(" ", $prod->nombre);
            foreach ($nombreSeparado as $p)
            {
                if (levenshtein(strtolower($p), $nombre) < 4) {
                    $resBusqueda[] = $prod;
                    break;
                }
            }
        }

        return $resBusqueda;
    }
}

?>