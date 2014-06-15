<?php

class Productos extends Controlador {

    public $categoria = "productos";
    private $categorias;
    // Constructor clase producto
    function __construct() {
        parent::__construct();
        $this->home = $this->loadModel("modelHome");
        // recibe las super-categorias
        $this->categorias = $this->home->getCategorias();
    }

    // 
    function index() {
        require('aplicacion/vista/Producto/header.php');
        require('aplicacion/vista/Producto/notFound.php');
        require('aplicacion/vista/Producto/footer.php');
    }

    // Función que se encarga de controlar 
    // y desplegar la información concerniente
    // al producto según su $id
    function info($id = null) {
        if (isset($id)) {
            $modelprod = $this->loadModel("modelProd");
            $info = $modelprod->getInforProd($id[0]);

            if (count($info) >= 1) {
                $prod = $info[0];
                $ind = $this->loadModel("modelHome");
                $modPromocion = $this->loadModel("modelPromo");
                $modPrecio = $this->loadModel("modelPrecio");

                $promocion = $modPromocion->getPromocion($prod->id_prod);
                $promocion = (isset($promocion) && count($promocion) == 1) ? $promocion[0] : null;
                $precio = $modPrecio->getPrecioHoy($prod->id_prod);
                $precio = (isset($precio) && !empty($precio)) ? $precio[0] : null;
                $productosAleatorios = $ind->getProdAleatorios();
                if (count($id) == 2 && $id[1] == "true") {
                    echo json_encode($info);
                } else {
                    require('aplicacion/vista/Producto/header.php');
                    require('aplicacion/vista/Producto/producto.php');
                    require('aplicacion/vista/Producto/footer.php');
                }
            } else {
                $this->index();
            }
        } else {
            //echo "No seteado";
            $this->index();
        }
    }

    /*
     * Función encargada de eliminar un producto de la base de datos
     * @param string $prod Id del producto a eliminar
     */

    function eliminarprod($prod) {
        $modelprod = $this->loadModel("modelProd");
        $modelprod->eliminarProducto($prod[0]);
        $modelprod->terminarConexion();
    }

    /**
     * Función encargada de agregar un producto a la base de datos
     */
    function agregarProd() {
        require_once('imagen.php');
        require('validador.php');
        require('validadorB.php');
        $controladorImg = new Imagen();
        $valid = new removedor();
        $agregadoExito = false;
        $codigo = $valid->test_input($_POST["idProd"]);
        $nombreP = $valid->test_input($_POST["nProd"]);
        $empresa_fab = $valid->test_input($_POST["empProd"]);
        $descripcion = $valid->test_input($_POST["descProd"]);
        $iva = $valid->test_input($_POST["ivaProd"]);
        $categoria = $valid->test_input($_POST["categoriaProd"]);
        $unidades = $valid->test_input($_POST["unidadesProd"]);
        $error = array();
        $modelprod = $this->loadModel("modelProd");
        if ($controladorImg->guardarImagen($codigo)) {
            //Validador::createBuilder(5.56)->esFloat()->max(20)->build()->isValid()
            if (Validador::createBuilder($codigo)->esCadena()->tieneLongitud(1, 10)->build()->isValid()) {
                if (Validador::createBuilder($nombreP)->esCadena()->tieneLongitud(1, 30)->build()->isValid()) {
                    if (Validador::createBuilder($empresa_fab)->esCadena()->tieneLongitud(1, 50)->build()->isValid()) {
                        if (Validador::createBuilder(intval($unidades))->esInt()->enIntervalo(0, 100000)->build()->isValid()) {
                            try {
                                $agregadoExito = $modelprod->agregarProducto($codigo, $nombreP, $empresa_fab, $descripcion, $iva, $categoria, $unidades);
                                header("Location: " . URL . "admin/precio/" . $codigo);
                            } catch (Exception $ex) {
                                array_push($error, "Error al agregar producto: ");
                            }
                        } else {
                            array_push($error, "Número de unidades inválido");
                        }
                    } else {
                        array_push($error, "Nombre empresa fabricante inválido");
                    }
                } else {
                    array_push($error, "Nombre inválido");
                }
            } else {
                array_push($error, "Código inválido");
            }
        } else {
            array_push($error, "Error al agregar imagen");
        }
        $productos = $modelprod->getProductos();
        require('aplicacion/vista/Admin/header.php');
        require('aplicacion/vista/Admin/producto.php');
        require('aplicacion/vista/Admin/footer.php');
    }

    /**
     * Función encargada de actualizar un producto 
     */
    function actualizarProd() {
        require('validador.php');
        require_once('imagen.php');
        require('validadorB.php');
        $valid = new removedor();
        $controladorImg = new Imagen();

        $codigo = $valid->test_input($_POST["idProd"]);
        $nombreP = $valid->test_input($_POST["nProd"]);
        $empresa_fab = $valid->test_input($_POST["empProd"]);
        $descripcion = $valid->test_input($_POST["descProd"]);
        $iva = $valid->test_input($_POST["ivaProd"]);
        $categoria = $valid->test_input($_POST["categoriaProd"]);
        $unidades = $valid->test_input($_POST["unidadesProd"]);
        $controladorImg->guardarImagen($codigo);
        $modelprod = $this->loadModel("modelProd");
        $error = array();
        
        if (Validador::createBuilder($codigo)->esCadena()->tieneLongitud(1, 10)->build()->isValid()) {
            if (Validador::createBuilder($nombreP)->esCadena()->tieneLongitud(1, 30)->build()->isValid()) {
                if (Validador::createBuilder($empresa_fab)->esCadena()->tieneLongitud(1, 50)->build()->isValid()) {
                    if (Validador::createBuilder(intval($unidades))->esInt()->enIntervalo(0, 100000)->build()->isValid()) {
                        try {
                            $modelprod->actualizarProducto($codigo, $nombreP, $empresa_fab, $descripcion, $iva, $categoria, $unidades);
                            $modelprod->terminarConexion();
                            header('Location: ' . URL . '/admin/producto');
                        } catch (Exception $ex) {
                            array_push($error, "Error al agregar producto: ");
                        }
                    } else {
                        array_push($error, "Número de unidades inválido");
                    }
                } else {
                    array_push($error, "Nombre empresa fabricante inválido");
                }
            } else {
                array_push($error, "Nombre inválido");
            }
        } else {
            array_push($error, "Código inválido");
        }
        $productos = $modelprod->getProductos();
        require('aplicacion/vista/Admin/header.php');
        require('aplicacion/vista/Admin/producto.php');
        require('aplicacion/vista/Admin/footer.php');
    }

}
