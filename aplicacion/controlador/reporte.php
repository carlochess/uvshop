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
        return array("titulo" => "Top 20 mas vendidos",
            "imagen" => "temp/ejemplo.png",
            "descripcion" => "El gráfico muestra los veinte productos más vendidos durante un mes en la tienda");
    }

    function top20menos() {
        $top = $this->modelreporte->top20menos();
        $g = new Grafico();
        $g->dibujarGrafico($top);
        return array("titulo" => "Top 20 menos vendidos",
            "imagen" => "temp/ejemplo.png",
            "descripcion" => "El gráfico muestra los veinte productos menos vendidos durante un mes en la tienda");
    }

    function totalVentasProd() {
        $prod = $_POST['producto'];
        if (isset($prod) && !empty($prod)) {
            $totalProd = $this->modelreporte->totalVentasProd($prod);
            $g = new Grafico();
            $g->dibujarGrafico($totalProd);
            return array("titulo" => "Ventas mes a mes producto " . $prod,
                "imagen" => "temp/ejemplo.png",
                "descripcion" => "El gráfico muestra la cantidad de ventas, mes a mes, de cada producto");
        }
        return null;
    }

    function totalVentasFab() {
        $totalFab = $this->modelreporte->totalVentasFab();
        $g = new Grafico();
        $g->dibujarGrafico($totalFab);

    return array("titulo" => "Resumen ventas fabricantes",
        "imagen" => "temp/ejemplo.png",
        "descripcion" => "El gráfico muestra el total de las ventas que un fabricante obtuvo gracias a sus productos");
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
            "descripcion" => "Los productos con bajas existencias en el stock");
    }

    function recaudoIva() {
        $recaudoIva = $this->modelreporte->recaudoIva();
        return array("titulo" => "Recaudo iva",
            "titulos_tabla" => array("Item", "Nombre", "IVA"),
            "tabla" => $recaudoIva,
            "descripcion" => "Total recaudado por IVA en la tienda");
    }

    function terminar() {
        $this->modelreporte->terminarConexion();
    }
    
    /**
      TODO
     */
    function /* void */ generarReporte() {
        
        if (isset($_POST) && count($_POST) > 1) {
            require(LIBRERIAS. 'pdf/fpdf.php');
            
            $pdf = new FPDF();
            $pdf->SetTitle("Reporte");
            $pdf->SetAutoPageBreak(TRUE);
            //--
            $arreglo = array("top20mas", "topClientes", "top20menos", "totalVentasProd", "totalVentasFab", "clientesCumpleanno", "bajasExistencias", "recaudoIva");
            $n = count($arreglo);
            
            // Portada del documento
            $pdf->AddPage();
            $pdf->SetFont('Arial','B',16);
            $pdf->Ln(120);
            $pdf->Cell(70);
            $pdf->Cell(40,10,'Reporte de ventas');
            
            // Índice del documento
            
            
            
            for ($i = 0; $i < $n; $i++) {
                if (isset($_POST[$arreglo[$i]]) && $_POST[$arreglo[$i]] == "on") {
                    $arr = $this->$arreglo[$i]();
                    if ($arr != NULL) {
                        $pdf->AddPage();
                        $pdf->SetFont('Arial', 'B', 16);
                        if (isset($arr['titulo']) && !empty($arr['titulo'])) {
                            // Logo
                            $pdf->Image(DIR_APP.'imagenes/aaserver/logo.gif',10,8,33);
                            // Movernos a la derecha
                            $pdf->Cell(80);
                            // Título
                            $pdf->Cell(20, 10, $arr['titulo']);
                            $pdf->Ln(20);
                        }
                        // Imagen
                        if (isset($arr['imagen']) && !empty($arr['imagen'])) {
                            $pdf->Cell(40);
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

                            $w = array(50, 80, 50);
                            $pdf->Cell(50, 7, $header[0], 1, 0, 'C', true);
                            $pdf->Cell(80, 7, $header[1], 1, 0, 'C', true);
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
                            $pdf->Write(10, $str = iconv('UTF-8', 'windows-1252',$arr['descripcion']));
                        }
                        $pdf->Ln(20);
                    }
                }
            }
            /*
            */
            $this->terminar();
            $pdf->Output();
        } else {
            header("Location: " . URL . "admin/reportes");
        }
    }
    
}
