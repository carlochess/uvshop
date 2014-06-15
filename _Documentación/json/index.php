<?php
include "../../aplicacion/cfg/config.php";
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(-1);
if (isset($_POST["arreglo"])) {

    function /* String */ leerArchivo($ruta) {
        if (file_exists($ruta))
            return file_get_contents($ruta);
    }

    function _isCurl() {
        return function_exists('curl_version');
    }

    function _isJson() {
        return function_exists('json_decode');
    }

    function insertarBD($str) {
        $str = leerArchivo($str);
        if (!_isCurl()) {
            echo "Curl no esta instalado en tu equipo <br />";
            return;
        }
        if (!_isJson()) {
            echo "JsonDecode no esta instalado en tu equipo <br />";
            return;
        }
        $json = json_decode(utf8_encode($str), true);
        if (is_array($json)) {
            foreach ($json as $key => $value) {

                // Imagen
                $url = $value["imagen"];
                $temp = end(explode(".", $url));
                $nombreImg = "img/" . $value["codigo"] . "." . $temp;
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
                $raw = curl_exec($ch);
                curl_close($ch);
                if (file_exists($nombreImg))
                    unlink($nombreImg);
                $fp = fopen($nombreImg, 'x');
                fwrite($fp, $raw);
                fclose($fp);

                // Producto
                $id_prod = $value["codigo"];
                $nombre = $value["nombre"];
                $empresa_fabricante = $value["empresa_fabricante"];
                $categoria = ( (array_key_exists("categoria", $value)) ? $value["categoria"] : NULL);
                $descripcion = $value["descripciÃ³n"];
                $porcentaje_iva = $value["porcentaje_iva"];
                $unidades = rand(5, 100);

                $ch = curl_init();
                $data = array('idProd' => $id_prod,
                    'nProd' => $nombre,
                    'empProd' => $empresa_fabricante,
                    'descProd' => $descripcion,
                    'ivaProd' => $porcentaje_iva,
                    'categoriaProd' => $categoria,
                    'unidadesProd' => $unidades,
                    'file' => '@' . realpath($nombreImg) . ';type=image/' . $temp);
                curl_setopt($ch, CURLOPT_URL, URL . 'productos/agregarProd');
                curl_setopt($ch, CURLOPT_MUTE, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_exec($ch);

                // Precio
                $fecha = date('Y-m-d');
                $intervalo = rand(0, 10);

                $fecha_inicial = date('Y-m-d', strtotime($fecha . ' - ' . $intervalo . ' days'));
                $fecha_final = date('Y-m-d', strtotime($fecha . ' + ' . $intervalo . ' days'));

                $cod_producto = $value["codigo"];
                $valor = rand(2000, 2000000);

                $ch = curl_init();
                $data = array('f_inicio' => $fecha_inicial,
                    'f_finalizacion' => $fecha_final,
                    'precio' => $valor);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_URL, URL . 'precios/agregarprecio/' . $id_prod);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_exec($ch);

                if (file_exists($nombreImg)) {
                    unlink($nombreImg);
                }
            }
        }
    }

    function main() {
        print_r(explode(",", $_POST['arreglo']));
        $k = explode(",", $_POST['arreglo']);
        foreach ($k as &$m) {
            insertarBD($m);
        }
    }

    main();
} else {
    ?>
    <html>
        <head>
            <title>JSON parse </title>
        </head>
        <body>
    <?php
    if ($handle = opendir('.')) {
        $thelist = "";
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'json') {
                $thelist .= '<li><a href="' . $file . '">' . $file . '</a></li>';
            }
        }
        closedir($handle);
        echo $thelist;
    }
    ?>
            <form method="post" action="index.php">
                <p> Ingresa la lista de archivos que quieras agregar (1.json, 2.json...) sin parentesis
                    y separadas por comas
                </p>
                <textarea rows="20" cols="70" name="arreglo"></textarea> 
                <p>
                    <input type="submit" name="Ingresar" />
                </p>
            </form>
        </body>
    </html>
<?php } ?>
