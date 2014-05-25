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
        echo '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">Dashboard</h1>
			<div class="row placeholders"></div>
			<h2 class="sub-header">Estas en el index</h2>
			</div>';
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

    /**
      TODO
     */
    function /* void */ generarReporte() {
        if (isset($_POST) && count($_POST) > 1) {
            require('aplicacion/libs/pdf/fpdf.php');
            require 'aplicacion/controlador/reporte.php';
            $pdf = new FPDF();
            $reporte = new Reporte();
            $pdf->SetTitle("Reporte");
            //--
            $arreglo = array("top20mas", "topClientes", "top20menos", "totalVentasProd", "totalVentasFab", "clientesCumpleanno", "bajasExistencias", "recaudoIva");
            $n = count($arreglo);

            for ($i = 0; $i < $n; $i++) {
                if (isset($_POST[$arreglo[$i]]) && $_POST[$arreglo[$i]] == "on") {
                    $arr = $reporte->$arreglo[$i]();
                    if ($arr != NULL) {
                        $pdf->AddPage();
                        $pdf->SetFont('Arial', 'B', 16);
                        if (isset($arr['titulo']) && !empty($arr['titulo'])) {
                            // Movernos a la derecha
                            $pdf->Cell(80);
                            // Título
                            $pdf->Cell(20, 10, $arr['titulo']);
                            $pdf->Ln(20);
                        }
                        // Imagen
                        if (isset($arr['imagen']) && !empty($arr['imagen'])) {
                            $pdf->Image($arr['imagen']);
                            $pdf->Ln(20);
                        } else if (isset($arr['tabla']) && $arr['tabla'] != NULL) {
                            $header = $arr['titulos_tabla'];
                            $data = $arr['tabla'];

                            // Colores, ancho de línea y fuente en negrita
                            $pdf->SetFillColor(255, 140, 0);
                            $pdf->SetTextColor(255);
                            $pdf->SetDrawColor(128, 0, 0);
                            $pdf->SetLineWidth(.3);
                            $pdf->SetFont('', 'B');
                            // Cabecera

                            $w = array(50, 55, 50);
                            $pdf->Cell(50, 7, $header[0], 1, 0, 'C', true);
                            $pdf->Cell(55, 7, $header[1], 1, 0, 'C', true);
                            $pdf->Cell(50, 7, $header[2], 1, 0, 'C', true);
                            $pdf->Ln();

                            // Restauración de colores y fuentes
                            $pdf->SetFillColor(224, 235, 255);
                            $pdf->SetTextColor(0);
                            $pdf->SetFont('');
                            // Datos
                            $fill = false;
                            foreach ($data as $row) {
                                $pdf->Cell($w[0], 6, number_format($row->id_prod), 'LR', 0, 'R', $fill);
                                $pdf->Cell($w[1], 6, $row->nombre, 'LR', 0, 'R', $fill);
                                $pdf->Cell($w[2], 6, number_format($row->unidades), 'LR', 0, 'R', $fill);
                                $pdf->Ln();
                                $fill = !$fill;
                            }
                            // Línea de cierre
                            $pdf->Cell(array_sum($w), 0, '', 'T');
                            $pdf->Ln(20);
                        }
                        // descripción
                        if (isset($arr['descripcion']) && !empty($arr['descripcion'])) {
                            $pdf->SetFont('');
                            $pdf->Cell(10, 0, $arr['descripcion']);
                        }
                        $pdf->Ln(20);
                    }
                }
            }
            $reporte->terminar();
            $pdf->Output();
        } else {
            header("Location: " . URL . "admin/reportes");
        }
    }

}
