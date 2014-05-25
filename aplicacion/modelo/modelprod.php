
<?php

// configurar autoloading
//require_once '../libs/orm/vendor/autoload.php';
// configurar Propel
//require_once '../libs/orm/generated-conf/config.php';

class ModelProd {
    public $oMySQL;

    function __construct(MySQL $db=null) {

        $this->oMySQL = $db;
    }

    /** Toda la info del producto 
     * TODO : ORM
     */
    function getInforProd($id) {
        $consulta = \Base\ProductoQuery::create()
                ->filterByIdProd($id)
                ->select(array("id_prod", "nombre","descripcion", "empresa_fab", "iva" ))
                ->limit(1)
                ->find();
        $arregloObj = json_decode (json_encode ( $consulta->toArray()), FALSE);
        //print_r($arregloObj);
        return $arregloObj;
        /*
        return $this->oMySQL->ejecutarConsultaSelect('
          SELECT producto.id_prod AS id_prod, nombre, descripcion, empresa_fab, iva
          FROM producto
          WHERE
          producto.id_prod="'.$id.'" LIMIT 1'
        );*/
    }

    /** Todos los productos */
    function getProductos() {
        $producto = \Base\ProductoQuery::create()
                ->select(array("producto.id_prod", "id_prod" ,"nombre", "empresa_fab", "descripcion", "iva", "unidades", "categoria"))
                ->find();
        $arregloObj = json_decode(json_encode($producto->toArray()), FALSE);
        return $arregloObj;
        /*
        	return $this->oMySQL->ejecutarConsultaSelect('SELECT producto.id_prod, nombre, empresa_fab, descripcion, iva, unidades, categoria
        	FROM producto');*/
    }

    /** Las filas afectadas en la consuta SQL */
    function getNumProd() {
        return $this->oMySQL->contarFilasAfectadas();
    }

    /**
     * Función que, dado un id, elimina un producto de la base de datos
     * TODO: ORM
     */
    function eliminarProducto($id) {
        if (isset($id)) {
            $producto = ProductoQuery::create()
                    ->findOneByIdProd($id);
            $producto->delete();
            //$sql = 'DELETE FROM producto WHERE id_prod="'.$id.'"';
            //$this->oMySQL->ejecutarConsultaI($sql);
        }
        header('Location: ' . URL . 'admin/producto');
    }

    /**
     * Función que agrega un producto a la base de datos
     */
    function agregarProducto($id_prod, $nombreP, $empresa_fab, $descripcion, $iva, $categoria, $unidades) {
        $producto = new Producto();
        $producto->setIdProd($id_prod);
        $producto->setNombre($nombreP);
        $producto->setEmpresaFab($empresa_fab);
        $producto->setDescripcion($descripcion);
        $producto->setIva($iva);
        $producto->setCategoria($categoria);
        $producto->setUnidades($unidades);
        $producto->save();
        
        /*$sql = 'INSERT INTO producto(id_prod, nombre, empresa_fab, descripcion, iva, categoria,unidades) 
        VALUES ("'.$id_prod.'","'.$nombreP.'","'.$empresa_fab.'","'.$descripcion.'",'.$iva.',"'.$categoria.'",'.$unidades.')';
        $this->oMySQL->ejecutarConsultaI($sql);*/
    }

    /**
     * Función que actualiza un producto de la base de datos
     */
    function actualizarProducto($id_prod, $nombreP, $empresa_fab, $descripcion, $iva, $categoria, $unidades) {
        \Base\ProductoQuery::create()
                ->filterByIdProd($id_prod)
                ->update(array('nombre' => $nombreP, 'empresa_fab' => $empresa_fab
                    , 'descripcion' => $descripcion, 'iva' => $iva, 'categoria' => $categoria, 'unidades' => $unidades));
        /*
        $sql = 'UPDATE producto SET nombre="'.$nombreP.'",empresa_fab="'.$empresa_fab.'",descripcion="'.$descripcion.'",iva='.$iva.',categoria="'.$categoria.'",unidades='.$unidades.' WHERE id_prod="'.$id_prod.'"';
        $this->oMySQL->ejecutarConsultaI($sql);*/
    }

    /**
     * Retorna todos los detalles relacionados a una lista de items
     */
    function infoProductos($items) {
        $clausulaWhere = '';
        foreach ($items as $item) {
            $clausulaWhere .= ('id_prod="' . $item . '" OR ');
        }
        $clausulaWhere = substr($clausulaWhere, 0, strrpos($clausulaWhere, 'OR', 0));
        /*
        $producto = \Base\ProductoQuery::create()
                ->select(array("id_prod", "nombre", "empresa_fab", "descripcion", "iva",
                    "precio", "porcetaje", "unidades", "categoria"))
                ->find();
        */
         		$sql = 'SELECT id_prod,nombre,empresa_fab,descripcion,iva,precio.valor AS precio, Prod.porcetaje_red AS descuento
          FROM (SELECT * FROM producto LEFT JOIN (SELECT * FROM promocion WHERE CAST(now() AS DATE) between promocion.fecha_ini and promocion.fecha_fin) AS  promocion on producto.id_prod = promocion.cod_producto) AS Prod
          INNER JOIN precio on Prod.id_prod = precio.cod_producto
          WHERE CAST(now() AS DATE) between precio.fecha_ini and precio.fecha_fin  AND '
          .$clausulaWhere. " ORDER BY id_prod ASC";

         return $this->oMySQL->ejecutarConsultaSelect($sql);
    }

    /**
     * 	Devuelve la cantidad de ocurrencias en un arreglo
     */
    function cantidadInicial($items) {
        $arr = array();
        for ($i = 0; $i < count($items); $i++) {
            if ($items[$i] != '-1') {
                $ocurrencias = 1;
                for ($j = $i + 1; $j < count($items); $j++) {
                    if (strcmp($items[$j], $items[$i]) == 0) {
                        $ocurrencias++;
                        $items[$j] = '-1';
                    }
                }
                $arr[$items[$i]] = $ocurrencias;
            }
        }
        return $arr;
    }

    /**
     * Función que termina la conexión con la base de datos
     */
    function terminarConexion() {
        $this->oMySQL->cerrarConexion();
    }

}

//main();
?>