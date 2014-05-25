<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
if(isset($_POST["arreglo"]))
{
	require 'rb.phar';
	R::setup('mysql:host=localhost;dbname=prueba','root','Univalle');
	$json = json_decode(utf8_encode($_POST["arreglo"]), true);
	
	foreach ($json as $key => $value) {
		// Producto
		$b = R::dispense( 'producto' );
	    $b->id_prod = $value["codigo"];
	    $b->nombre = $value["nombre"];
	    $b->empresa_fabricante = $value["empresa_fabricante"];
	    $b->categoria = ( (array_key_exists ( "categoria" , $value ))? $value["categoria"] :  NULL);
	    $b->descripcion = $value["descripción"];
	    $b->porcentaje_iva = $value["porcentaje_iva"];
	    $id = R::store( $b );
	    
	    // Precio
	    $fecha = date('Y-m-d');
	    $intervalo = rand (0,10);
		$fecha_inicial = date_format(date_add($fecha, date_interval_create_from_date_string($intervalo.' days')),'Y-m-d');
		$fecha_final = date_format(date_sub($fecha, date_interval_create_from_date_string($intervalo.' days')),'Y-m-d');
		$p = R::dispense( 'precio' );
	    $p->cod_producto = $value["codigo"];
	    $p->fecha_ini = $fecha_inicial;
	    $p->fecha_ini = $fecha_final;
	    $p->valor = rand ( 2000 , 2000000 );
	    $id = R::store( $p );
	    
	    // Imagen
	    $url = $value["imagen"];
	    $temp =explode("/",$url);
	    $nombreImg = end($temp);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
		$raw=curl_exec($ch);
		curl_close ($ch);
		if(file_exists($nombreImg)) unlink($nombreImg);
		$fp = fopen($nombreImg,'x');
		fwrite($fp, $raw);
		fclose($fp);
	}
	R::close();
}
else
{
?>
<html>
    <head>
        <title>JSON parse </title>
    </head>
    <body>
        <form method="post" action="index.php">
            <p> Ingresa el archivo JSON </p>
            <textarea rows="20" cols="70" name="arreglo"></textarea> 
            <p>
                <input type="submit" name="Ingresar Productos" />
            </p>
        </form>
    </body>
</html>
<?php } ?>
