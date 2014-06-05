<?php

class ValidatorTest extends PHPUnit_Framework_TestCase {

    protected function setUp() {
        
    }
    
    public function testCreacionInstanciaEstatica() {
        $this->assertInstanceOf('ValidadorBuilder', Validador::createBuilder(null));
    }

    public function testCadenaVacia() {
        $this->assertTrue(Validador::createBuilder("")->estaVacia()->build()->isValid());
    }

    public function testNegacion() {
        $this->assertFalse(Validador::createBuilder("")->estaVacia()->not()->build()->isValid());
    }

    public function testContineEspacioCadena() {
        $this->assertFalse(Validador::createBuilder(" Hola Mundo")->esCadena()->contieneEspacios()->build()->isValid());
    }

    public function testComprobarFechaMenorQueOtra() {
        $fechaInicial = "2014-05-10";
        $fechaFinal = "2014-05-10";
        $this->assertTrue(Validador::createBuilder($fechaInicial)->esFecha()->fechaNoSeCruzaCon($fechaFinal)->build()->isValid());
    }

    public function testCadenaNula() {
        $this->assertFalse(Validador::createBuilder(null)->esCadena()->build()->isValid());
    }

    /**
     * @dataProvider data
     */
    public function testEnteroMenorAVeinte($actual_1) {
        $this->assertTrue(Validador::createBuilder($actual_1)->esInt()->max(20)->build()->isValid());
    }

    /**
     * @dataProvider proveedorCadenasValidas
     */
    public function testCadenaValida($data, $d="") {
        $this->assertTrue(Validador::createBuilder($data)->esCadena()->build()->isValid());
    }
    
    /**
     * @dataProvider proveedorCadenasInvalidas
     */
    public function testCadenaInvalida($data, $d="") {
        $this->assertFalse(Validador::createBuilder($data)->esCadena()->build()->isValid(),
                sprintf('Cadena "%s" deberia ser válida. (Comprobar: %s)', $data, var_export($data, true)));
    }
    
    public function proveedorCadenasValidas() {
        return array(array("", ""),
            array('alganet', ''),
            array('alganet', 'alganet'),
            array('0alg-anet0', '0-9'),
            array('1', ''),
            array("\t", ''),
            array("\n", ''),
            array('a', ''),
            array('foobar', ''),
            array('rubinho_', '_'),
            array('google.com', '.'),
            array('alganet alganet', ''),
            array("\nabc", ''),
            array("\tdef", ''),
            array("\nabc \t", '')
            );
    }
    

    public function proveedorCadenasInvalidas() {
        return array(
            array('@#$', ''),
            array('_', ''),
            array('dgç', ''),
            array(1e21, ''), //evaluates to "1.0E+21"
            array(null, ''),
            array(new \stdClass, ''),
            array(array(), ''),
        );
    }
    
    public function data() {
        return [[-1], [2], [6]];
    }
}

?>