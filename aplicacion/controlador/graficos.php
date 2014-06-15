	
<?php

include(LIBRERIAS . "pChart/class/pData.class.php");
include(LIBRERIAS . "pChart/class/pDraw.class.php");
include(LIBRERIAS . "pChart/class/pImage.class.php");

class Grafico {

    private $MyData;

    function __construct() {
        $this->MyData = new pData();
    }

    function graficoBarras() {
        $myPicture = new pImage(500, 400, $this->MyData);
        $myPicture->drawGradientArea(0, 0, 600, 600, DIRECTION_VERTICAL, array("StartR" => 240, "StartG" => 240, "StartB" => 240, "EndR" => 180, "EndG" => 180, "EndB" => 180, "Alpha" => 100));
        $myPicture->drawGradientArea(0, 0, 600, 600, DIRECTION_HORIZONTAL, array("StartR" => 240, "StartG" => 240, "StartB" => 240, "EndR" => 180, "EndG" => 180, "EndB" => 180, "Alpha" => 20));
        $myPicture->setFontProperties(array("FontName" => LIBRERIAS . "pChart/fonts/times.ttf", "FontSize" => 12));

        $myPicture->setGraphArea(50, 50, 450, 350);
        $myPicture->drawScale(array("CycleBackground" => TRUE, "DrawSubTicks" => TRUE, "GridR" => 0, "GridG" => 0, "GridB" => 0, "GridAlpha" => 10, "Pos" => SCALE_POS_TOPBOTTOM)); // 

        $myPicture->setShadow(TRUE, array("X" => 1, "Y" => 1, "R" => 0, "G" => 0, "B" => 0, "Alpha" => 10));

        $myPicture->drawBarChart(array("DisplayPos" => LABEL_POS_INSIDE, "DisplayValues" => TRUE, "Rounded" => TRUE, "Surrounding" => 30));

        $myPicture->drawLegend(200, 370, array("Style" => LEGEND_NOBORDER, "Mode" => LEGEND_HORIZONTAL));

        $myPicture->render(LIBRERIAS . "../../temp/ejemplo.png");
    }

    function dibujarGrafico($info) {
        $items = array();
        $data = array();
        foreach ($info as $record) {
            $items[] = $record->id_prod;
            $data[] = $record->cantidad;
        }
        $this->MyData->addPoints($data, "Compras");
        $this->MyData->setAxisName(0, "Numero de Compras");
        $this->MyData->addPoints($items, "Código productos");
        $this->MyData->setSerieDescription("Código productos", "Código productos");
        $this->MyData->setAbscissa("Código productos");
        $this->MyData->setAbscissaName("Código productos");
        $this->MyData->setAxisDisplay(0, AXIS_FORMAT_METRIC, 1);
        $this->graficoBarras();
    }

}
