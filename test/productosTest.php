<?php

class ProductosTest extends PHPUnit_Framework_TestCase{
    
    private $controladorProducto;
    
    protected function setUp(){
        $this->controladorProducto = new Productos();
    }


    public function testAgregarProducto()
    {
        $_POST["idProd"] = "k01";
        $_POST["nProd"] = "Hola";
        $_POST["empProd"] = "Coca Cola";
        $_POST["descProd"] = "Es un pesimo producto";
        $_POST["ivaProd"] = "20";
        $_POST["categoriaProd"] = "Gaseosas";
        $_POST["unidadesProd"] = "20";
    }
    /**
     * @depends testAgregarProducto
     */
    public function testRevisarSiProductoFueAgregado()
    {
        
    }
}