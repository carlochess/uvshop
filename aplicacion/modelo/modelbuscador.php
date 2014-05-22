
<?php

// configurar autoloading
require_once '../libs/vendor/autoload.php';

// configurar Propel
require_once '../libs/generated-conf/config.php';

class ModelBuscador {
    /* Clase encargada de las consultas a la bd */
    private $filasAfectadas;
    public $oMySQL;

    function __construct(MySQL $db = null) {
        $this->oMySQL = $db;
    }

    /** Retorna la busqueda de los productos relacionados a la palabra clave */
    function buscarInfoProd($nombre) {
        $consulta = \Base\ProductoQuery::create()
                ->select("nombre")
                ->withColumn("Producto.id_prod", 'id_prod')
                ->filterBy(nombre, "%" . $nombre . "%")
                ->find();
        return $consulta->toArray();
        //return $this->oMySQL->ejecutarConsultaSelect('SELECT nombre, producto.id_prod as id_prod FROM producto WHERE nombre LIKE "%'.$nombre.'%";');
    }

    /** Toda la info de todos los producto */
    function getProductos() {
        $consulta = \Base\ProductoQuery::create()
                ->select("nombre")
                ->withColumn("Producto.id_prod", 'id_prod')
                ->find();
        return $consulta->toArray();
        //return $this->oMySQL->ejecutarConsultaSelect('SELECT nombre, producto.id_prod as id_prod FROM producto');
    }

    function buscarInfoCategoria($categoria) {
        $consulta = \Base\ProductoQuery::create()
                ->select(array("nombre", "id_prod", "descripcion", "categoria"))
                ->filterBy("categoria", $categoria)
                ->find();
        return $consulta->toArray();
        //return $this->oMySQL->ejecutarConsultaSelect('SELECT id_prod, nombre, descripcion, categoria FROM producto WHERE categoria="' . $categoria . '"');
    }

    function numResultados() {
        
        //return $this->oMySQL->contarFilasAfectadas();
    }

    function terminarConexion() {
        $this->oMySQL->cerrarConexion();
    }

}

?>