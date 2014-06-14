<?php

class Reporte extends Controlador {

    private $modelreporte;

    // Constructor clase producto
    function __construct() {
        parent::__construct();
        include("graficos.php");
        $this->modelreporte = $this->loadModel("modelreporte");
    }

    // 
    function index() {
        header("Location: " . URL);
    }

    function top20mas() {
        $top = $this->modelreporte->top20mas();

        $g = new Grafico();
        $g->dibujarGrafico($top);
        return array("titulo" => "Top 20 mas vendidos", "imagen" => "temp/ejemplo.png", "descripcion" => "Hola mundo");
    }

    function top20menos() {
        $top = $this->modelreporte->top20menos();
        $g = new Grafico();
        $g->dibujarGrafico($top);
        return array("titulo" => "Top 20 menos vendidos", "imagen" => "temp/ejemplo.png", "descripcion" => "Hola mundo2");
    }

    function totalVentasProd() {
        $prod = $_POST['producto'];
        if (isset($prod) && !empty($prod)) {
            $totalProd = $this->modelreporte->totalVentasProd($prod);
            $g = new Grafico();
            $g->dibujarGrafico($totalProd);
            return array("titulo" => "Ventas mes a mes producto " . $prod, "imagen" => "temp/ejemplo.png", "descripcion" => "Hola mundo3");
        }
        return null;
    }

    function totalVentasFab() {
        $totalFab = $this->modelreporte->totalVentasFab();
        $g = new Grafico();
        $g->dibujarGrafico($totalFab);

        return array("titulo" => "Resumen ventas fabricantes", "imagen" => "temp/ejemplo.png", "descripcion" => "Hola mundo4");
    }

    function topClientes() {
        return NULL;
    }

    ///---------------------------------------

    function clientesCumpleanno() {
        return NULL;
    }

    function bajasExistencias() {
        $bajasExistencias = $this->modelreporte->bajasExistencias();
        return array("titulo" => "Bajas Existencias",
            "titulos_tabla" => array("Item", "Nombre", "Existencias"),
            "tabla" => $bajasExistencias,
            "descripcion" => "Hola mundo6");
    }

    function recaudoIva() {
        $recaudoIva = $this->modelreporte->recaudoIva();
        return array("titulo" => "Recaudo iva",
            "titulos_tabla" => array("Item", "Nombre", "IVA"),
            "tabla" => $recaudoIva,
            "descripcion" => "Hola mundo7");
    }

    function terminar() {
        $this->modelreporte->terminarConexion();
    }
}
