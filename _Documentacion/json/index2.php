<?php

function /* String */ leerArchivo($ruta) {
    if (file_exists($ruta))
        return file_get_contents($ruta);
}

function insertarBD($str) {

    $json = json_decode(utf8_encode($str), true);

    foreach ($json as $key => $value) {
        
        // Imagen
        $url = $value["imagen"];
        $temp = end(explode(".", $url));
        $nombreImg = "img/".$value["codigo"].".". $temp;
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
            'file' => '@'.realpath($nombreImg). ';type=image/'. $temp);
        curl_setopt($ch, CURLOPT_URL, 'http://localhost/uvshop/productos/agregarProd');
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
        curl_setopt($ch, CURLOPT_URL, 'http://localhost/uvshop/precios/agregarprecio/'.$id_prod);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_exec($ch);
        
        if (file_exists($nombreImg))
            unlink($nombreImg);
    }
}

function main() {
    $contenido = leerArchivo("1.json");
    //foreach ($argv as $arg)
    //    insertarBD($arg);
    insertarBD($contenido);
}

main();

